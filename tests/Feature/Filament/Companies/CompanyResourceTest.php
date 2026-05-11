<?php

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

it('adds lightweight visual guidance to the company form', function () {
    $contents = file_get_contents(base_path('app/Filament/Resources/Companies/Schemas/CompanyForm.php'));

    expect($contents)
        ->toContain('Información Fiscal de las Empresas')
        ->toContain('Grid::make(2)')
        ->toContain("->placeholder('J123456789')")
        ->toContain("->placeholder('Empresa S.A. de C.V.')")
        ->toContain('->columnSpanFull()');
});
