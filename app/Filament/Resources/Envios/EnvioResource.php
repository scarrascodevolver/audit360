<?php

namespace App\Filament\Resources\Envios;

use App\Filament\Resources\Envios\Pages\ListEnvios;
use App\Filament\Resources\Envios\Pages\ViewEnvio;
use App\Filament\Resources\Envios\RelationManagers\DocumentosRelationManager;
use App\Filament\Resources\Envios\Tables\EnviosTable;
use App\Models\Envio;
use BackedEnum;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EnvioResource extends Resource
{
    protected static ?string $model = Envio::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInboxArrowDown;

    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return 'envío';
    }

    public static function getPluralModelLabel(): string
    {
        return 'envíos';
    }

    // Los envíos solo se crean desde el formulario público.
    public static function canCreate(): bool
    {
        return false;
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            TextEntry::make('comunidad')->label('Comunidad')->placeholder('—'),
            TextEntry::make('telefono')->label('Teléfono'),
            TextEntry::make('email')->label('Email'),
            TextEntry::make('estado')->label('Estado')->badge()
                ->color(fn (string $state): string => $state === Envio::ESTADO_NUEVO ? 'warning' : 'success'),
            TextEntry::make('consentimiento_at')->label('Consentimiento RGPD')->dateTime('d/m/Y H:i'),
            TextEntry::make('created_at')->label('Recibido')->dateTime('d/m/Y H:i'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return EnviosTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            DocumentosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEnvios::route('/'),
            'view' => ViewEnvio::route('/{record}'),
        ];
    }
}
