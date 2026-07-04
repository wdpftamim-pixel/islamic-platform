<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Filament\Resources\ArticleResource\RelationManagers;
use App\Models\Article;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function canViewAny(): bool
    {
        return auth()->user()->hasAnyRole([
        'super-admin',
        'admin',
        'editor',
        'author',
        ]);
    }
    public static function canCreate(): bool
    {
        return auth()->user()->hasAnyRole([
        'super-admin',
        'admin',
        'editor',
        'author',
        ]);
    }
    public static function canEdit($record): bool
    {
        $user = auth()->user();
        if ($user->hasAnyRole(['super-admin', 'admin'])) {
            return true;
        }
        return $record->user_id === $user->id;
    }
    public static function canDelete($record): bool
    {
        $user = auth()->user();
        if ($user->hasAnyRole(['super-admin', 'admin'])) {
            return true;
        }
        return $record->user_id === $user->id;

    }

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
                Forms\Components\Select::make('category_id')
                ->relationship('category', 'name')
                ->searchable()
                ->preload(),

            Forms\Components\TextInput::make('title')
                ->required()
                ->maxLength(255)
                ->live(onBlur: true)
                ->afterStateUpdated(fn ($state, callable $set) =>
                    $set('slug', \Illuminate\Support\Str::slug($state))
                ),

            Forms\Components\TextInput::make('slug')
                ->required()
                ->unique(ignoreRecord: true),

            Forms\Components\FileUpload::make('thumbnail')
                ->image()
                ->directory('articles')
                ->disk('public'),

            Forms\Components\Textarea::make('excerpt')
                ->rows(3),

            Forms\Components\RichEditor::make('content')
                ->required()
                ->columnSpanFull(),

            Forms\Components\Toggle::make('is_published')
                ->default(false),

            Forms\Components\Toggle::make('is_featured')
                ->default(false),

            Forms\Components\DateTimePicker::make('published_at'),

        ])
        ->columns(2);

    }


   public static function table(Table $table): Table
    {
    return $table
    ->columns([
            Tables\Columns\ImageColumn::make('thumbnail')
                ->disk('public'),

            Tables\Columns\TextColumn::make('title')
                ->searchable()
                ->sortable()
                ->limit(40),
            
            Tables\Columns\TextColumn::make('author.name')
                ->label('Author')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('category.name')
                ->badge()
                ->sortable(),

            Tables\Columns\IconColumn::make('is_published')
                ->boolean(),

            Tables\Columns\IconColumn::make('is_featured')
                ->boolean(),

            Tables\Columns\TextColumn::make('published_at')
                ->dateTime()
                ->sortable(),

            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),

        ])

        ->filters([

            Tables\Filters\TernaryFilter::make('is_published'),

            Tables\Filters\TernaryFilter::make('is_featured'),

        ])

        ->actions([
            Tables\Actions\EditAction::make(),
        ])

        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);

    }


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
