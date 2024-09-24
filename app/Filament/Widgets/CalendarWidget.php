<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\EstudianteResource;
use App\Models\Estudiante;
use App\Models\Instructor;
use Filament\Forms\FormsComponent;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Symfony\Contracts\Service\Attribute\Required;

class CalendarWidget extends FullCalendarWidget
{

    public Model | string | null $model = Estudiante::class;

    public function fetchEvents(array $fetchInfo): array
    {
        return Estudiante::query()
            ->where('start_at', '>=', $fetchInfo['start'])
            ->where('end_at', '<=', $fetchInfo['end'])
            ->get()
            ->map(
                fn (Estudiante $event) => [
                    'id' => $event->id,
                    'title' => $event->name,
                    'color' => $event->color,
                    'email' => $event->email,
                    'start' => $event->start_at,
                    'end' => $event->end_at,
                   
                ]
            )
            ->all();
    }

    public function getFormSchema(): array
    {
        return [
            Group::make()
                ->schema([
                    TextInput::make('name')
                        ->required(),
                    ColorPicker::make('color')
                        ->required(),
                    TextInput::make('email')
                        ->required()
                        ->email(),
                    TextInput::make('phone')
                        ->tel()
                        ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/'), 
                        
                    Select::make('instructor_id')
                        ->label('Instructor')
                        ->options(Instructor::all()->pluck('name', 'id'))
                        ->required(),    
                ])->columns('2'),
            Grid::make()
                ->schema([
                    DateTimePicker::make('start_at')
                        ->required()
                        ->seconds(false),
 
                    DateTimePicker::make('end_at')
                        ->required()
                        ->seconds(false),
                ]),
        ];
    }
}
