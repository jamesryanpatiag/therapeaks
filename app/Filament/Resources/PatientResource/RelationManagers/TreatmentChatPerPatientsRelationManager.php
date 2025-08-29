<?php

namespace App\Filament\Resources\PatientResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use ArielMejiaDev\FilamentPrintable\Actions\PrintAction;
use ArielMejiaDev\FilamentPrintable\Actions\PrintBulkAction;

class TreatmentChatPerPatientsRelationManager extends RelationManager
{
    protected static string $relationship = 'treatmentChatPerPatients';

    protected static ?string $title = 'Treatments';

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\TextInput::make('message')
                    ->label('Inquiry')
                    ->required()
                    ->columnSpanFull()
                    ->maxLength(65535),
                Forms\Components\Textarea::make('response')
                    ->label('Procedure')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull()
                    ->rows(20),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('message')
            ->columns([
                Tables\Columns\TextColumn::make('message')
                    ->label('Inquiry')
                    ->wrap(),
                Tables\Columns\TextColumn::make('created_at')  
                    ->dateTime('M d, Y H:i')
                    ->label('Date Executed')
                    ->wrap(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->createAnother(false),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    PrintBulkAction::make(),
                ]),
            ]);
    }

    public function getTablLabel(): ?string
    {
        return 'Patient Information';
    }
    
}
