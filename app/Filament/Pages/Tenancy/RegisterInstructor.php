<?php

namespace App\Filament\Pages\Tenancy;

use App\Models\Instructor;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\Register;
use Filament\Pages\Tenancy\RegisterTenant;
use Illuminate\Database\Eloquent\Model;



class RegisterInstructor extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Register instructor';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name'),
                ColorPicker::make('color'),
            ]);
    }

    protected function handleRegistration(array $data): Instructor
    {
        $instructor = Instructor::create($data);

        $instructor->members()->attach(auth()->user());

        return $instructor;
    }
}