<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TherapySessionResource\Pages;
use App\Filament\Resources\TherapySessionResource\RelationManagers;
use App\Models\TherapySession;
use App\Models\Patient;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TherapySessionResource extends Resource
{
    protected static ?string $model = TherapySession::class;

    protected static ?string $navigationGroup = 'Therapy';

    protected static ?string $navigationLabel = "Sessions";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Status')
                    ->schema([
                        Forms\Components\Select::make('patient_id')
                            ->label('Patient')
                            ->options(Patient::all()->pluck('name', 'id'))
                            ->columnSpan(1)
                            ->required(),
                        Forms\Components\Select::make('user_id')
                            ->label('Therapist')
                            ->options(User::all()->pluck('name', 'id'))
                            ->columnSpan(1)
                            ->required(),
                        Forms\Components\DateTimePicker::make('session_date')
                            ->required(),
                        Forms\Components\Textarea::make('notes')
                            ->columnSpanFull(),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('patient.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('therapist.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('session_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTherapySessions::route('/'),
            'create' => Pages\CreateTherapySession::route('/create'),
            'edit' => Pages\EditTherapySession::route('/{record}/edit'),
        ];
    }
}
