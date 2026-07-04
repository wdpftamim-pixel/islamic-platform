<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;


class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('parent_id')
            ->label('Parent Category')
            ->relationship('parent', 'name')
            ->searchable()
            ->preload(),

            Forms\Components\TextInput::make('name')
            ->required()
            ->maxLength(255)
            ->live(onBlur: true)
            ->afterStateUpdated(fn ($state, callable $set) =>
            $set('slug', Str::slug($state))
            ),


            Forms\Components\TextInput::make('slug')
            ->required()
            ->unique(ignoreRecord: true)
            ->maxLength(255),

            Forms\Components\Textarea::make('description')
            ->rows(4)
            ->columnSpanFull(),

            Forms\Components\Toggle::make('is_active')
            ->default(true),

            Forms\Components\Toggle::make('is_featured')
            ->default(false),

            Forms\Components\TextInput::make('sort_order')
            ->numeric()
            ->default(0),

                        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
           ->columns([
            Tables\Columns\TextColumn::make('name')
            ->searchable()
            ->sortable(),
            Tables\Columns\TextColumn::make('slug')
                ->searchable()
                ->copyable(),

            Tables\Columns\TextColumn::make('parent.name')
                ->label('Parent'),

            Tables\Columns\IconColumn::make('is_active')
                ->boolean(),

            Tables\Columns\IconColumn::make('is_featured')
                ->boolean(),

            Tables\Columns\TextColumn::make('sort_order')
                ->sortable(),

            Tables\Columns\TextColumn::make('created_at')
                ->dateTime('d M Y'),

            ])

            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
