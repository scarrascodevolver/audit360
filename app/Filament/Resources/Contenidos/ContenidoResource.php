<?php

namespace App\Filament\Resources\Contenidos;

use App\Filament\Resources\Contenidos\Pages\EditContenido;
use App\Filament\Resources\Contenidos\Pages\ListContenidos;
use App\Models\Contenido;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ContenidoResource extends Resource
{
    protected static ?string $model = Contenido::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPencilSquare;

    public static function getModelLabel(): string
    {
        return 'texto';
    }

    public static function getPluralModelLabel(): string
    {
        return 'textos del sitio';
    }

    public static function getNavigationLabel(): string
    {
        return 'Textos del sitio';
    }

    // Las claves las define el código: el cliente solo edita valores.
    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('clave')
                ->label('Clave')
                ->disabled(),
            Textarea::make('valor')
                ->label('Texto')
                ->rows(4)
                ->required()
                ->helperText('En las listas, cada línea es un elemento.'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultGroup('grupo')
            ->defaultSort('clave')
            ->paginated(false)
            ->columns([
                TextColumn::make('clave')
                    ->label('Clave')
                    ->searchable(),
                TextColumn::make('valor')
                    ->label('Texto')
                    ->limit(80)
                    ->wrap()
                    ->searchable(),
            ])
            ->recordActions([
                EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListContenidos::route('/'),
            'edit' => EditContenido::route('/{record}/edit'),
        ];
    }
}
