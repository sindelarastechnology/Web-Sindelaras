@php
    $files = $this->getFiles();
    $stats = $this->getStats();
    $directories = $this->getDirectories();
@endphp

<div class="space-y-6">
    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="fi-section rounded-xl bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10 p-5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center text-2xl shrink-0">🖼️</div>
                <div class="min-w-0">
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total'] }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 truncate">Total Gambar</p>
                </div>
            </div>
        </div>
        <div class="fi-section rounded-xl bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10 p-5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-2xl shrink-0">💾</div>
                <div class="min-w-0">
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_size'] }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 truncate">Total Ukuran</p>
                </div>
            </div>
        </div>
        <div class="fi-section rounded-xl bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10 p-5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center text-2xl shrink-0">🗑️</div>
                <div class="min-w-0">
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['unused'] }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 truncate">Tidak Digunakan</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Search & Filter --}}
    <div class="fi-section rounded-xl bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10 p-4">
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 min-w-0">
                <input type="text" wire:model.live.debounce.500ms="search" placeholder="Cari file..."
                       class="fi-input block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2 text-sm text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500">
            </div>
            <div class="sm:w-64">
                <select wire:model.live.debounce.500ms="directory"
                        class="fi-input block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2 text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                    @foreach($directories as $val => $label)
                        <option value="{{ $val }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- Loading Indicator --}}
    <div wire:loading.class="opacity-50" class="transition-opacity duration-200">
    <div class="fi-section rounded-xl bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10 overflow-hidden">
        @if(count($files) === 0)
            <div class="p-12 text-center">
                <div class="text-5xl mb-4">📂</div>
                <p class="text-gray-500 dark:text-gray-400">Tidak ada file ditemukan</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                            <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400 w-16">Preview</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Nama File</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400 hidden md:table-cell">Folder</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400 hidden sm:table-cell">Ukuran</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400 hidden lg:table-cell">Diubah</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Digunakan</th>
                            <th class="px-4 py-3 text-right font-medium text-gray-500 dark:text-gray-400">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($files as $file)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/30 transition-colors">
                                <td class="px-4 py-3">
                                    <button wire:click="openPreview('{{ $file['path'] }}')" class="block w-12 h-12 rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-800 hover:ring-2 hover:ring-primary-500 transition-all">
                                        <img src="{{ $file['url'] }}" alt="{{ $file['name'] }}" loading="lazy"
                                             onerror="this.onerror=null; this.classList.add(&apos;hidden&apos;); this.parentElement.classList.add(&apos;bg-gray-200&apos;,&apos;dark:bg-gray-700&apos;,&apos;flex&apos;,&apos;items-center&apos;,&apos;justify-center&apos;); var ic=document.createElement(&apos;span&apos;); ic.className=&apos;text-lg&apos;; ic.textContent=&apos;📷&apos;; this.parentElement.appendChild(ic)"
                                             class="w-full h-full object-cover">
                                    </button>
                                </td>
                                <td class="px-4 py-3 max-w-0">
                                    <p class="font-medium text-gray-900 dark:text-white truncate">{{ $file['name'] }}</p>
                                    <p class="text-xs text-gray-400 truncate">{{ $file['path'] }}</p>
                                </td>
                                <td class="px-4 py-3 hidden md:table-cell">
                                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $file['directory'] }}</span>
                                </td>
                                <td class="px-4 py-3 hidden sm:table-cell">
                                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $file['size_formatted'] }}</span>
                                </td>
                                <td class="px-4 py-3 hidden lg:table-cell">
                                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $file['last_modified'] }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    @php $u = $file['usage']; @endphp
                                    @if($u['total'] > 0)
                                        <div class="flex flex-wrap gap-1 max-w-[160px]">
                                            @foreach($u['details'] as $d)
                                                <span title="{{ $d['table'] }}.{{ $d['column'] }}"
                                                      class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300 truncate max-w-full">
                                                    {{ $d['label'] }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-xs text-gray-400 italic">Tidak dipakai</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-1">
                                        <button wire:click="openPreview('{{ $file['path'] }}')"
                                                class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors" title="Preview">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </button>
                                        <button wire:click="deleteFile('{{ $file['path'] }}')"
                                                wire:confirm="Hapus file ini?{{ $u['total'] > 0 ? ' File digunakan di ' . $u['total'] . ' tempat. Semua referensi akan dihapus.' : '' }}"
                                                class="p-1.5 rounded-lg text-gray-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700 text-xs text-gray-400 flex items-center justify-between">
                <span>Menampilkan {{ count($files) }} file</span>
                <span wire:loading class="text-primary-500">Memuat...</span>
            </div>
        @endif
    </div>
    </div>

    {{-- Preview Modal --}}
    @if($showPreviewModal && $previewFile)
        <div class="fixed inset-0 z-[60] flex items-center justify-center p-2 sm:p-4 bg-black/60"
             wire:click="closePreview"
             x-data
             x-init="$el.addEventListener('click', e => { if(e.target === $el) $wire.closePreview() })">
            <div class="relative w-full max-w-4xl max-h-[90vh] bg-white dark:bg-gray-900 rounded-2xl shadow-2xl overflow-hidden flex flex-col"
                 @click.stop>
                <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700 shrink-0">
                    <h3 class="font-semibold text-gray-900 dark:text-white truncate mr-4">{{ basename($previewFile) }}</h3>
                    <button wire:click="closePreview"
                            class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="p-4 flex items-center justify-center overflow-auto min-h-0 flex-1 bg-gray-100 dark:bg-gray-800">
                    <img src="/storage/{{ $previewFile }}" alt="{{ basename($previewFile) }}"
                         onerror="this.onerror=null; this.classList.add(&apos;hidden&apos;); this.parentElement.innerHTML=&apos;<span class=\&quot;text-gray-400 text-sm\&quot;>Gagal memuat gambar</span>&apos;"
                         class="max-w-full max-h-[65vh] w-auto h-auto object-contain rounded-lg">
                </div>
                <div class="p-4 border-t border-gray-200 dark:border-gray-700 flex items-center justify-between text-xs text-gray-500 shrink-0">
                    <span class="truncate mr-2">{{ $previewFile }}</span>
                    <span class="shrink-0">{{ \App\Filament\Pages\MediaGallery::formatSizeStatic(Storage::disk('public')->size($previewFile)) }}</span>
                </div>
            </div>
        </div>
    @endif
</div>
