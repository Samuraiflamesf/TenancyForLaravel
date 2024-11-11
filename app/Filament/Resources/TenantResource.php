<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Tenant;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TenantResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TenantResource\RelationManagers;

class TenantResource extends Resource
{
    protected static ?string $model = Tenant::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->label('Nome da unidade:')
                        ->maxLength(255),
                    Grid::make(2)
                        ->schema([
                            Forms\Components\TextInput::make('name_user')
                                ->required()
                                ->label('Nome do Usuário:')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('password')
                                ->label('Senha:')
                                ->password()
                                ->required()
                                ->revealable()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('cpf')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->label('CPF:')
                                ->mask('999.999.999-99'), // CPF também único
                            Forms\Components\TextInput::make('email')
                                ->label('E-mail:')
                                ->email()
                                ->required()
                                ->maxLength(255),
                        ]),
                    Forms\Components\TextInput::make('domain')
                        ->prefix('http://')
                        ->suffix('.localhost')
                        ->helperText('Ex: cedeba.localhost'),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(
                        'Nome do Domain'
                    )
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('E-mail')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(
                        'Criado em:'
                    )
                    ->dateTime('d/m/y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Atualizado em:')
                    ->dateTime('d/m/y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->limit(10),
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
            'index' => Pages\ListTenants::route('/'),
            'create' => Pages\CreateTenant::route('/create'),
            'edit' => Pages\EditTenant::route('/{record}/edit'),
        ];
    }
}