<?php

namespace App\Filament\Resources\Contenidos;

use App\Filament\Resources\Contenidos\Pages\EditContenido;
use App\Filament\Resources\Contenidos\Pages\ListContenidos;
use App\Models\Contenido;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Html;
use Filament\Schemas\Components\Section;
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

    /** Ruta de la página pública donde aparece cada grupo de textos. */
    public static function rutaDePagina(string $grupo): string
    {
        return match (true) {
            str_starts_with($grupo, 'Proceso') => '/recopilacion',
            str_starts_with($grupo, 'Cuota Segura') => '/cuota-segura',
            str_starts_with($grupo, 'Subir documentos') => '/subir-documentos',
            default => '/',
        };
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Grid::make(3)->columnSpanFull()->schema([
                Section::make('Texto')
                    ->columnSpan(1)
                    ->schema([
                        TextEntry::make('grupo')->label('Sección'),
                        TextEntry::make('etiqueta')->label('Elemento'),
                        Textarea::make('valor')
                            ->label('Texto')
                            ->rows(6)
                            ->required()
                            ->helperText('En las listas, cada línea es un elemento. El cambio se publica al guardar.'),
                    ]),
                Section::make('Vista previa')
                    ->description('La página donde aparece este texto, tal y como está publicada. Tras guardar, se actualiza.')
                    ->columnSpan(2)
                    ->schema([
                        Html::make(fn (Contenido $record): string => '<iframe src="'
                            .e(url(self::rutaDePagina($record->grupo)))
                            .'" style="width:100%;height:36rem;border:1px solid rgba(0,0,0,.1);border-radius:.75rem;background:#fff" loading="lazy"></iframe>'
                            .'<a href="'.e(url(self::rutaDePagina($record->grupo)))
                            .'" target="_blank" rel="noopener" style="display:inline-block;margin-top:.5rem;font-size:.8rem;text-decoration:underline">Abrir la página en una pestaña nueva</a>'),
                    ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultGroup('grupo')
            ->defaultSort('clave')
            ->paginated(false)
            ->columns([
                TextColumn::make('etiqueta')
                    ->label('Elemento')
                    ->searchable(),
                TextColumn::make('valor')
                    ->label('Texto actual')
                    ->limit(70)
                    ->wrap()
                    ->searchable(),
            ])
            ->recordActions([
                EditAction::make()->label('Editar'),
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
