<?php

namespace App\Filament\Resources\Envios\RelationManagers;

use App\Models\Documento;
use Filament\Actions\Action;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Number;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocumentosRelationManager extends RelationManager
{
    protected static string $relationship = 'documentos';

    protected static ?string $title = 'Documentos';

    public function isReadOnly(): bool
    {
        return true;
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nombre_original')
            ->columns([
                TextColumn::make('slot')
                    ->label('Apartado')
                    ->badge(),
                TextColumn::make('nombre_original')
                    ->label('Archivo')
                    ->searchable(),
                TextColumn::make('mime')
                    ->label('Tipo'),
                TextColumn::make('tamano_bytes')
                    ->label('Tamaño')
                    ->formatStateUsing(fn (int $state): string => Number::fileSize($state)),
            ])
            ->recordActions([
                Action::make('descargar')
                    ->label('Descargar')
                    ->icon(Heroicon::OutlinedArrowDownTray)
                    // Los archivos están cifrados en reposo: se descifran al vuelo.
                    ->action(fn (Documento $record): StreamedResponse => response()->streamDownload(
                        function () use ($record): void {
                            echo Crypt::decrypt(Storage::disk('envios')->get($record->ruta));
                        },
                        $record->nombre_original,
                        ['Content-Type' => $record->mime],
                    )),
            ]);
    }
}
