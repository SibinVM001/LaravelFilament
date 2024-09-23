<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Filament\Roles;
use App\Models\Category;
use Filament\Resources\Forms\Components;
use Filament\Resources\Forms\Form;
use Filament\Resources\Resource;
use Filament\Resources\Tables\Columns;
use Filament\Resources\Tables\Filter;
use Filament\Resources\Tables\Table;

class CustomerResource extends Resource
{
    public static $icon = 'heroicon-o-collection';

    public static function form(Form $form)
    {
        return $form
            ->schema([
                Components\TextInput::make('name')->autofocus()->required(),
                // Components\TextInput::make('category')->email()->required(),
                Components\BelongsToSelect::make('category_id')->label('category')->relationship('category', 'name')->preload()->required()
            
            
                // Components\Select::make('type')
                //     ->placeholder('Select a type')
                //     ->options([
                //         'individual' => 'Individual',
                //         'organization' => 'Organization',
                //     ]),
                // Components\DatePicker::make('birthday'),
            ]);
    }

    public static function table(Table $table)
    {
        return $table
            ->columns([
                Columns\Text::make('name')->label('New Name')->primary()->sortable()->searchable()->url('http://www.google.com', $shouldOpenInNewTab = true),
                // Columns\Text::make('category')->getValueUsing($callback = fn ($record) => $record->getAttribute('name')),
                // Columns\Text::make('category')->getValueUsing($callback = fn ($record) => Category::find($record->getAttribute('category'))->name)
                Columns\Text::make('category.name')->label('category')
            ])
            ->filters([
                Filter::make('individuals', fn ($query) => $query->where('type', 'individual')),
            ]);
    }

    public static function relations()
    {
        return [
            Category::class
        ];
    }

    public static function routes()
    {
        return [
            Pages\ListCustomers::routeTo('/', 'index'),
            Pages\CreateCustomer::routeTo('/create', 'create'),
            Pages\EditCustomer::routeTo('/{record}/edit', 'edit'),
        ];
    }
}
