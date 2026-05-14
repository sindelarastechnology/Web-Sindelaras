<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MediaGallery extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Media';
    protected static ?string $navigationLabel = 'Media Gallery';
    protected static ?string $slug = 'media-gallery';
    protected static ?int $navigationSort = 1;
    protected static string $view = 'filament.pages.media-gallery';

    public string $search = '';
    public string $directory = '';
    public ?string $previewFile = null;
    public bool $showPreviewModal = false;

    private ?array $cachedFiles = null;

    public function getTitle(): string
    {
        return 'Media Gallery';
    }

    public function getFiles(): array
    {
        if ($this->cachedFiles !== null) {
            return $this->cachedFiles;
        }

        $disk = Storage::disk('public');
        $allFiles = $disk->allFiles();

        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'avif', 'ico'];

        $paths = [];
        $rawFiles = [];
        foreach ($allFiles as $path) {
            $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
            if (!in_array($ext, $imageExtensions)) continue;

            $dir = dirname($path);
            if ($dir === '.') $dir = '/';

            if ($this->directory && $dir !== $this->directory) continue;
            if ($this->search && !str_contains(strtolower(basename($path)), strtolower($this->search))) continue;

            $paths[] = $path;
            $rawFiles[$path] = [
                'path' => $path,
                'name' => basename($path),
                'directory' => $dir,
                'size' => $disk->size($path),
                'size_formatted' => $this->formatSize($disk->size($path)),
                'last_modified' => $disk->lastModified($path),
                'url' => '/storage/' . $path,
                'usage' => ['total' => 0, 'details' => []],
            ];
        }

        if (!empty($paths)) {
            $usageMap = $this->batchFindUsage($paths);
            foreach ($usageMap as $path => $usage) {
                if (isset($rawFiles[$path])) {
                    $rawFiles[$path]['usage'] = $usage;
                }
            }
        }

        $files = array_values($rawFiles);
        usort($files, fn ($a, $b) => $b['last_modified'] <=> $a['last_modified']);

        $files = array_map(function ($f) {
            $f['last_modified'] = date('d M Y H:i', $f['last_modified']);
            return $f;
        }, $files);

        $this->cachedFiles = $files;
        return $files;
    }

    public function getDirectories(): array
    {
        $disk = Storage::disk('public');
        $dirs = ['' => 'Semua Folder'];
        foreach ($disk->allDirectories() as $dir) {
            if (str_starts_with($dir, '.') || str_starts_with($dir, 'livewire-tmp') || str_starts_with($dir, 'tmp')) continue;
            $dirs[$dir] = $dir;
        }
        return $dirs;
    }

    public function getStats(): array
    {
        $files = $this->getFiles();
        $totalSize = array_sum(array_column($files, 'size'));
        $unused = count(array_filter($files, fn ($f) => empty($f['usage']['total'])));

        return [
            'total' => count($files),
            'total_size' => $this->formatSize($totalSize),
            'unused' => $unused,
        ];
    }

    protected function batchFindUsage(array $paths): array
    {
        $allPaths = array_unique($paths);
        $usageMap = [];
        foreach ($allPaths as $p) {
            $usageMap[$p] = ['total' => 0, 'details' => []];
        }

        // 1. String columns — batched with GROUP BY
        $stringColumns = [
            'services' => ['image', 'banner_image'],
            'portfolios' => ['thumbnail', 'client_photo'],
            'posts' => ['featured_image'],
            'sliders' => ['image', 'mobile_image'],
            'testimonials' => ['client_photo'],
            'team_members' => ['photo'],
            'page_contents' => ['banner_image'],
            'settings' => ['logo', 'favicon', 'og_image', 'hero_image'],
        ];

        foreach ($stringColumns as $table => $columns) {
            foreach ($columns as $col) {
                $results = DB::table($table)
                    ->select($col, DB::raw('count(*) as cnt'))
                    ->whereNotNull($col)
                    ->whereIn($col, $allPaths)
                    ->groupBy($col)
                    ->get();

                foreach ($results as $r) {
                    $val = $r->$col;
                    if ($val && isset($usageMap[$val])) {
                        $usageMap[$val]['details'][] = [
                            'table' => $table,
                            'column' => $col,
                            'count' => $r->cnt,
                            'type' => 'field',
                            'label' => $this->tableLabel($table) . ' › ' . $col,
                        ];
                        $usageMap[$val]['total']++;
                    }
                }
            }
        }

        // 2. JSON gallery column
        $portfolios = DB::table('portfolios')
            ->whereNotNull('gallery')
            ->get(['id', 'gallery']);

        foreach ($portfolios as $p) {
            $gallery = json_decode($p->gallery, true) ?? [];
            $found = [];
            foreach ($gallery as $g) {
                $gPath = is_string($g) ? $g : ($g['path'] ?? '');
                if ($gPath && in_array($gPath, $allPaths, true) && !isset($found[$gPath])) {
                    if (isset($usageMap[$gPath])) {
                        $usageMap[$gPath]['details'][] = [
                            'table' => 'portfolios',
                            'column' => 'gallery',
                            'count' => 1,
                            'type' => 'json',
                            'label' => 'Portfolio › Gallery',
                        ];
                        $usageMap[$gPath]['total']++;
                    }
                    $found[$gPath] = true;
                }
            }
        }

        // 3. HTML content columns (Tiptap) — batched
        $htmlColumns = [
            'services' => ['description'],
            'portfolios' => ['description'],
            'posts' => ['content'],
            'page_contents' => ['content'],
        ];

        foreach ($htmlColumns as $table => $columns) {
            foreach ($columns as $col) {
                $results = DB::table($table)
                    ->select('id', $col)
                    ->whereNotNull($col)
                    ->where(function ($q) use ($col, $allPaths) {
                        foreach ($allPaths as $path) {
                            $q->orWhere($col, 'like', '%' . basename($path) . '%');
                        }
                    })
                    ->get();

                foreach ($results as $row) {
                    $content = $row->$col;
                    $seen = [];
                    foreach ($allPaths as $path) {
                        if (isset($seen[$path])) continue;
                        if (str_contains($content, basename($path)) && str_contains($content, '/storage/')) {
                            if (isset($usageMap[$path])) {
                                $usageMap[$path]['details'][] = [
                                    'table' => $table,
                                    'column' => $col,
                                    'count' => 1,
                                    'type' => 'html',
                                    'label' => $this->tableLabel($table) . ' › Konten',
                                ];
                                $usageMap[$path]['total']++;
                            }
                            $seen[$path] = true;
                        }
                    }
                }
            }
        }

        return $usageMap;
    }

    public function openPreview(string $path): void
    {
        $this->previewFile = $path;
        $this->showPreviewModal = true;
    }

    public function closePreview(): void
    {
        $this->showPreviewModal = false;
        $this->previewFile = null;
    }

    public function deleteFile(string $path): void
    {
        $disk = Storage::disk('public');
        if (!$disk->exists($path)) {
            Notification::make()->title('File tidak ditemukan')->danger()->send();
            return;
        }

        $usage = $this->findUsage($path);
        $count = $usage['total'] ?? 0;

        $this->cascadeDelete($path);

        $disk->delete($path);

        $this->cachedFiles = null;

        Notification::make()
            ->title('File berhasil dihapus')
            ->body($count > 0 ? "$count referensi di database telah dibersihkan." : null)
            ->success()
            ->send();
    }

    protected function findUsage(string $path): array
    {
        $filename = basename($path);
        $results = [];

        $stringColumns = [
            'services' => ['image', 'banner_image'],
            'portfolios' => ['thumbnail', 'client_photo'],
            'posts' => ['featured_image'],
            'sliders' => ['image', 'mobile_image'],
            'testimonials' => ['client_photo'],
            'team_members' => ['photo'],
            'page_contents' => ['banner_image'],
            'settings' => ['logo', 'favicon', 'og_image', 'hero_image'],
        ];

        foreach ($stringColumns as $table => $columns) {
            foreach ($columns as $col) {
                $count = DB::table($table)->where($col, $path)->count();
                if ($count > 0) {
                    $results[] = [
                        'table' => $table,
                        'column' => $col,
                        'count' => $count,
                        'type' => 'field',
                        'label' => $this->tableLabel($table) . ' › ' . $col,
                    ];
                }
            }
        }

        $portfolios = DB::table('portfolios')
            ->whereNotNull('gallery')
            ->where('gallery', 'like', '%' . $filename . '%')
            ->get(['id', 'title', 'gallery']);

        foreach ($portfolios as $p) {
            $gallery = json_decode($p->gallery, true) ?? [];
            $match = collect($gallery)->first(fn ($g) => (is_string($g) ? $g : ($g['path'] ?? '')) === $path);
            if ($match) {
                $results[] = [
                    'table' => 'portfolios',
                    'column' => 'gallery',
                    'count' => 1,
                    'type' => 'json',
                    'label' => 'Portfolio › Gallery',
                ];
            }
        }

        $htmlColumns = [
            'services' => ['description'],
            'portfolios' => ['description'],
            'posts' => ['content'],
            'page_contents' => ['content'],
        ];

        foreach ($htmlColumns as $table => $columns) {
            foreach ($columns as $col) {
                $count = DB::table($table)
                    ->whereNotNull($col)
                    ->where($col, 'like', '%' . $filename . '%')
                    ->where($col, 'like', '%/storage/%')
                    ->count();
                if ($count > 0) {
                    $results[] = [
                        'table' => $table,
                        'column' => $col,
                        'count' => $count,
                        'type' => 'html',
                        'label' => $this->tableLabel($table) . ' › Konten',
                    ];
                }
            }
        }

        return [
            'total' => count($results),
            'details' => $results,
        ];
    }

    protected function cascadeDelete(string $path): void
    {
        $filename = basename($path);

        $stringColumns = [
            'services' => ['image', 'banner_image'],
            'portfolios' => ['thumbnail', 'client_photo'],
            'posts' => ['featured_image'],
            'sliders' => ['image', 'mobile_image'],
            'testimonials' => ['client_photo'],
            'team_members' => ['photo'],
            'page_contents' => ['banner_image'],
            'settings' => ['logo', 'favicon', 'og_image', 'hero_image'],
        ];

        foreach ($stringColumns as $table => $columns) {
            foreach ($columns as $col) {
                DB::table($table)->where($col, $path)->update([$col => null]);
            }
        }

        $portfolios = DB::table('portfolios')
            ->whereNotNull('gallery')
            ->where('gallery', 'like', '%' . $filename . '%')
            ->get(['id', 'gallery']);

        foreach ($portfolios as $p) {
            $gallery = json_decode($p->gallery, true) ?? [];
            $gallery = collect($gallery)->filter(fn ($g) => (is_string($g) ? $g : ($g['path'] ?? '')) !== $path)->values()->toArray();
            DB::table('portfolios')->where('id', $p->id)->update(['gallery' => json_encode($gallery)]);
        }

        $htmlColumns = [
            'services' => ['description'],
            'portfolios' => ['description'],
            'posts' => ['content'],
            'page_contents' => ['content'],
        ];

        $patterns = [
            '/<img[^>]*src=["\'].*?' . preg_quote($filename, '/') . '.*?["\'][^>]*>/i',
            '/<img[^>]*src=["\'].*?\/storage\/' . preg_quote($path, '/') . '["\'][^>]*>/i',
        ];

        foreach ($htmlColumns as $table => $columns) {
            foreach ($columns as $col) {
                $rows = DB::table($table)
                    ->whereNotNull($col)
                    ->where($col, 'like', '%' . $filename . '%')
                    ->get(['id', $col]);

                foreach ($rows as $row) {
                    $content = $row->$col;
                    foreach ($patterns as $pattern) {
                        $content = preg_replace($pattern, '', $content);
                    }
                    DB::table($table)->where('id', $row->id)->update([$col => $content]);
                }
            }
        }
    }

    private function formatSize(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 1) . ' ' . $units[$i];
    }

    private function tableLabel(string $table): string
    {
        return match ($table) {
            'services' => 'Layanan',
            'portfolios' => 'Portfolio',
            'posts' => 'Artikel',
            'sliders' => 'Slider',
            'testimonials' => 'Testimonial',
            'team_members' => 'Tim',
            'page_contents' => 'Halaman',
            'settings' => 'Pengaturan',
            default => $table,
        };
    }

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function formatSizeStatic(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 1) . ' ' . $units[$i];
    }
}
