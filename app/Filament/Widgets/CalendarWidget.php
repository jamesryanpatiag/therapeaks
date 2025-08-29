<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Filament\Forms;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Saade\FilamentFullCalendar\Actions;
use Illuminate\Database\Eloquent\Model;
use App\Models\TherapySession;
use App\Filament\Resources\TherapySessionResource;
use Saade\FilamentFullCalendar\Data\EventData;
use Carbon\Carbon;
use Log;

class CalendarWidget extends FullCalendarWidget
{

    public Model | string | null $model = TherapySession::class;

    protected function headerActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->mountUsing(
                    function (Forms\Form $form, array $arguments) {
                        $form->fill([
                            'session_date' => $arguments['start'] ?? null,
                        ]);
                    }
                )
        ];
    }

    protected function modalActions(): array
    {
        return [
            Actions\EditAction::make()
                ->mountUsing(
                    function (TherapySession $record, Forms\Form $form, array $arguments) {
                        Log::info($record);
                        $form->fill([
                            'name' => $record->name,
                            'session_date' => $arguments['event']['start'] ?? $record->session_date,
                        ]);
                    }
                ),
            Actions\DeleteAction::make(),
        ];
    }

    public function config(): array
    {
        return [
            'firstDay' => 1,
            'headerToolbar' => [
                'left' => 'dayGridWeek,dayGridDay',
                'center' => 'title',
                'right' => 'prev,next today',
            ],
        ];
    }

    public function fetchEvents(array $fetchInfo): array
    {
        return TherapySession::query()
            ->whereDate('session_date', '>=', Carbon::parse($fetchInfo['start']))
            ->whereDate('session_date', '<=', Carbon::parse($fetchInfo['end']))
            ->get()
            ->map(
                fn (TherapySession $event) => EventData::make()
                    ->id($event->id)
                    ->title($event->patient->name)
                    ->start($event->session_date)
                    ->end($event->session_date)
                    ->url(
                        url: TherapySessionResource::getUrl(name: 'edit', parameters: ['record' => $event]),
                        shouldOpenUrlInNewTab: true
                    )
            )
            ->toArray();
    }

    public function getFormSchema(): array
    {
        return [
            Forms\Components\Grid::make()
                ->schema([
                    Forms\Components\DateTimePicker::make('session_date')
                        ->label('Session Date')
                        ->required()
                        ->columnSpanFull(),
                    Forms\Components\Select::make('user_id')
                        ->relationship('therapist', 'name')
                        ->required()
                        ->searchable()
                        ->columnSpanFull(),
                    Forms\Components\Select::make('patient_id')
                        ->relationship('patient', 'name')
                        ->required()
                        ->searchable()
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('notes')
                        ->required()
                        ->maxLength(65535)
                        ->columnSpanFull(),
                ]),
        ];
    }

    
}
