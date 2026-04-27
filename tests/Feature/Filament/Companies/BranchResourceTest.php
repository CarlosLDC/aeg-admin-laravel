<?php

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

it('adds lightweight visual guidance to the branch form', function () {
    $contents = file_get_contents(base_path('app/Filament/Resources/Companies/Resources/Branches/Schemas/BranchForm.php'));

    expect($contents)
        ->toContain('Nombre visible de la sucursal en listados y documentos.')
        ->toContain('Datos para ubicar y contactar la sucursal.')
        ->toContain('Medios principales para atención y seguimiento.')
        ->toContain('Grid::make(2)')
        ->toContain("->placeholder('Sucursal Caracas')")
        ->toContain("->placeholder('Av. Principal, edificio, piso y referencia')")
        ->toContain("->placeholder('0212-555-0000')")
        ->toContain("->placeholder('contacto@empresa.com')");
});
