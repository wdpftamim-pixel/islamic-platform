<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommentResource\Pages;
use App\Filament\Resources\CommentResource\RelationManagers;
use App\Models\Comment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

   public static function form(Form $form): Form
    {
    return $form
    ->schema([

            Forms\Components\Select::make('user_id')
                ->relationship('user', 'name')
                ->disabled(),

            Forms\Components\Select::make('article_id')
                ->relationship('article', 'title')
                ->disabled(),

            Forms\Components\Textarea::make('content')
                ->required()
                ->rows(6)
                ->columnSpanFull(),

            Forms\Components\Toggle::make('is_approved'),

        ])
        ->columns(2);
    }


    public static function table(Table $table): Table
    {
    return $table
    ->columns([

            Tables\Columns\TextColumn::make('user.name')
                ->label('User')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('article.title')
                ->label('Article')
                ->limit(40)
                ->searchable(),

            Tables\Columns\TextColumn::make('content')
                ->limit(80)
                ->wrap(),

            Tables\Columns\IconColumn::make('is_approved')
                ->boolean(),

            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),

        ])

        ->filters([

            Tables\Filters\TernaryFilter::make('is_approved'),

        ])

        ->actions([

            Tables\Actions\EditAction::make(),

            Tables\Actions\Action::make('approve')
                ->icon('heroicon-o-check')
                ->color('success')
                ->visible(fn ($record) => ! $record->is_approved)
                ->action(fn ($record) =>
                    $record->update([
                        'is_approved' => true,
                    ])
                ),

        ])

        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);

    }
    public static function canCreate(): bool
    {
    return false;
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
            'index' => Pages\ListComments::route('/'),
            'create' => Pages\CreateComment::route('/create'),
            'edit' => Pages\EditComment::route('/{record}/edit'),
        ];
    }
}
