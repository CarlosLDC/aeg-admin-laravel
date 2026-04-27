<?php

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

it('adds lightweight visual guidance to the company form', function () {
    $contents = file_get_contents(base_path('app/Filament/Resources/Companies/Schemas/CompanyForm.php'));

    expect($contents)
        ->toContain('Información General')
        ->toContain('Datos básicos para identificar la empresa en el panel.')
        ->toContain('Grid::make(2)')
        ->toContain("->placeholder('J-12345678')")
        ->toContain("->placeholder('AEG Admin C.A.')")
        ->toContain('->columnSpanFull()');
});
