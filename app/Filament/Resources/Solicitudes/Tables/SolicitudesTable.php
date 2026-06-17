<?php

namespace App\Filament\Resources\Solicitudes\Tables;

use App\Models\Solicitud;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SolicitudesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('created_at')
                    ->label('Recibida')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                TextColumn::make('telefono')
                    ->label('Teléfono')
                    ->placeholder('—')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->placeholder('—')
                    ->searchable(),
                TextColumn::make('estado')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => $state === Solicitud::ESTADO_NUEVA ? 'warning' : 'success'),
            ])
            ->recordActions([
                // Marca rápida de que ya se ha llamado al cliente.
                Action::make('contactada')
                    ->label('Marcar contactada')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->visible(fn (Solicitud $record): bool => $record->estado === Solicitud::ESTADO_NUEVA)
                    ->action(fn (Solicitud $record) => $record->update(['estado' => Solicitud::ESTADO_CONTACTADA])),
                ViewAction::make(),
            ]);
    }
}
