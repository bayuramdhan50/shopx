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
use Illuminate\Support\Collection;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    
    protected static ?string $navigationLabel = 'Categories';
    
    protected static ?string $navigationGroup = 'Shop Management';
    
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Category Information')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (string $state, callable $set) => $set('slug', \Illuminate\Support\Str::slug($state))),
                                
                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true),
                                
                                Forms\Components\Textarea::make('description')
                                    ->maxLength(1000)
                                    ->columnSpanFull(),
                                    
                                Forms\Components\Toggle::make('is_active')
                                    ->label('Active')
                                    ->default(true)
                                    ->helperText('Inactive categories won\'t be shown on the shop'),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),
                
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Image')
                            ->schema([
                                Forms\Components\FileUpload::make('image')
                                    ->image()
                                    ->imageResizeMode('cover')
                                    ->imageCropAspectRatio('16:9')
                                    ->imageResizeTargetWidth('1920')
                                    ->imageResizeTargetHeight('1080')
                                    ->directory('categories'),
                            ]),
                        
                        Forms\Components\Section::make('Statistics')
                            ->schema([
                                Forms\Components\Placeholder::make('products_count')
                                    ->label('Total Products')
                                    ->content(fn (Category $record): int => $record->products()->count()),
                                    
                                Forms\Components\Placeholder::make('created_at')
                                    ->label('Created at')
                                    ->content(fn (Category $record): ?string => $record->created_at?->diffForHumans()),
                                    
                                Forms\Components\Placeholder::make('updated_at')
                                    ->label('Last Updated')
                                    ->content(fn (Category $record): ?string => $record->updated_at?->diffForHumans()),
                            ])
                            ->hidden(fn (?Category $record) => $record === null),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Image')
                    ->circular(false)
                    ->square(),
                    
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('products_count')
                    ->label('Products')
                    ->counts('products')
                    ->sortable(),
                    
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Active')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created Date')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                    
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active')
                    ->placeholder('All Categories')
                    ->trueLabel('Active categories')
                    ->falseLabel('Inactive categories'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('activate')
                        ->label('Activate Categories')
                        ->icon('heroicon-o-check-circle')
                        ->action(fn (Collection $records) => $records->each->update(['is_active' => true]))
                        ->requiresConfirmation()
                        ->color('success'),
                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Deactivate Categories')
                        ->icon('heroicon-o-x-circle')
                        ->action(fn (Collection $records) => $records->each->update(['is_active' => false]))
                        ->requiresConfirmation()
                        ->color('danger'),
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
