<?php

namespace App\Filament\Resources\Envios\Tables;

use App\Models\Envio;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EnviosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('created_at')
                    ->label('Recibido')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                TextColumn::make('comunidad')
                    ->label('Comunidad')
                    ->placeholder('—')
                    ->searchable(),
                TextColumn::make('telefono')
                    ->label('Teléfono')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('documentos_count')
                    ->label('Docs')
                    ->counts('documentos'),
                TextColumn::make('estado')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => $state === Envio::ESTADO_NUEVO ? 'warning' : 'success'),
            ])
            ->recordActions([
                ViewAction::make(),
            ]);
    }
}
