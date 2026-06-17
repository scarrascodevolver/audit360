<?php

namespace App\Filament\Resources\Solicitudes;

use App\Filament\Resources\Solicitudes\Pages\ListSolicitudes;
use App\Filament\Resources\Solicitudes\Pages\ViewSolicitud;
use App\Filament\Resources\Solicitudes\Tables\SolicitudesTable;
use App\Models\Solicitud;
use BackedEnum;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SolicitudResource extends Resource
{
    protected static ?string $model = Solicitud::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoneArrowUpRight;

    protected static ?int $navigationSort = 0;

    public static function getModelLabel(): string
    {
        return 'solicitud';
    }

    public static function getPluralModelLabel(): string
    {
        return 'solicitudes';
    }

    // Las solicitudes solo se crean desde el formulario público.
    public static function canCreate(): bool
    {
        return false;
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            TextEntry::make('telefono')->label('Teléfono')->placeholder('—'),
            TextEntry::make('email')->label('Email')->placeholder('—'),
            TextEntry::make('estado')->label('Estado')->badge()
                ->color(fn (string $state): string => $state === Solicitud::ESTADO_NUEVA ? 'warning' : 'success'),
            TextEntry::make('consentimiento_at')->label('Consentimiento RGPD')->dateTime('d/m/Y H:i'),
            TextEntry::make('created_at')->label('Recibida')->dateTime('d/m/Y H:i'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return SolicitudesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSolicitudes::route('/'),
            'view' => ViewSolicitud::route('/{record}'),
        ];
    }
}
