<?php

namespace App\Filament\Pages;

use App\Models\Ajuste;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

/**
 * @property-read Schema $form
 */
class Ajustes extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Ajustes';

    protected static ?string $title = 'Ajustes';

    protected string $view = 'filament-panels::pages.page';

    /** @var array<string, mixed>|null */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'email_notificaciones' => Ajuste::emailsNotificaciones(),
            'adjuntar_archivos' => Ajuste::bool(Ajuste::ADJUNTAR_ARCHIVOS, true),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TagsInput::make('email_notificaciones')
                    ->label('Correos que reciben los avisos')
                    ->placeholder('escribe un correo y pulsa Enter')
                    ->nestedRecursiveRules(['email'])
                    ->helperText('Puedes añadir varios. A todos les llega el aviso de cada envío nuevo, con los archivos adjuntos.'),
                Toggle::make('adjuntar_archivos')
                    ->label('Adjuntar los archivos al correo')
                    ->helperText('Si el envío pesa demasiado para el correo, se enviará solo el aviso con enlace al panel.'),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        // Se guardan separados por comas en un único ajuste.
        $correos = collect($data['email_notificaciones'] ?? [])
            ->map(fn (string $email): string => trim($email))
            ->filter()
            ->unique()
            ->implode(',');

        Ajuste::set(Ajuste::EMAIL_NOTIFICACIONES, $correos ?: null);
        Ajuste::set(Ajuste::ADJUNTAR_ARCHIVOS, $data['adjuntar_archivos'] ? '1' : '0');

        Notification::make()
            ->title('Ajustes guardados')
            ->success()
            ->send();
    }

    public function content(Schema $schema): Schema
    {
        return $schema->components([
            $this->getFormContentComponent(),
        ]);
    }

    public function getFormContentComponent(): Component
    {
        return Form::make([EmbeddedSchema::make('form')])
            ->id('form')
            ->livewireSubmitHandler('save')
            ->footer([
                Actions::make([
                    Action::make('save')
                        ->label('Guardar')
                        ->submit('save'),
                ])->key('form-actions'),
            ]);
    }
}
