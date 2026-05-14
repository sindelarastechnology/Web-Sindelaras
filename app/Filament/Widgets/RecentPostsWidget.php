<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentPostsWidget extends BaseWidget
{
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Post::where('status', 'published')->latest('published_at')->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Judul')->limit(40),
                Tables\Columns\TextColumn::make('category.name')->label('Kategori')->badge(),
                Tables\Columns\TextColumn::make('published_at')->label('Publikasi')->dateTime('d M Y'),
                Tables\Columns\TextColumn::make('views')->label('Dilihat'),
            ]);
    }
}
