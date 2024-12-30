<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AddressRelationManager extends RelationManager
{
    protected static string $relationship = 'address';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('first_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('last_name')
                ->required()
                ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                ->required()
                ->maxLength(255),
                Forms\Components\TextInput::make('jalan')
                ->required()
                ->maxLength(255),
                Forms\Components\TextInput::make('kecamatan')
                ->required()
                ->maxLength(255),
                Forms\Components\TextInput::make('kabkota')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('provinsi')
                ->required()
                ->maxLength(255),
                Forms\Components\TextInput::make('kode_pos')
                ->required()
                ->maxLength(255),


            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('phone')
            ->columns([
                TextColumn::make('first_name')
                                ->label('First Name'),
                TextColumn::make('last_name')
                                ->label('Last Name'),
                TextColumn::make('phone'),

                TextColumn::make('jalan'),

                TextColumn::make('kecamatan'),

                TextColumn::make('kabkota'),
                TextColumn::make('provinsi'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
