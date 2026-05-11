<?php

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

it('adds lightweight visual guidance to the branch form', function () {
    $contents = file_get_contents(base_path('app/Filament/Resources/Branches/Schemas/BranchForm.php'));

    expect($contents)
        ->toContain('Tabs::make(\'branch_form_tabs\')')
        ->toContain('Grid::make(2)')
        ->toContain("->placeholder('J123456789')")
        ->toContain("->placeholder('Alpha Engineer Group, C.A.')")
        ->toContain("->placeholder('AEG Caracas')")
        ->toContain("->placeholder('Av. Principal, edificio, piso y referencia')")
        ->toContain("->placeholder('+5802125550000')")
        ->toContain("->placeholder('contacto@empresa.com')");
});
