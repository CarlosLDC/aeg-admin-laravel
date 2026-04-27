<?php

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

it('applies the sales-inspired visual copy and muted totals styling to payments', function () {
    $contents = file_get_contents(base_path('app/Filament/Resources/Sales/Resources/Payments/Schemas/PaymentForm.php'));

    expect($contents)->toContain('Datos del Pago')
        ->and($contents)->toContain('Resumen de Totales')
        ->and($contents)->toContain('Calculados automáticamente')
        ->and($contents)->toContain("TextInput::make('igtf_amount')")
        ->and($contents)->toContain("TextInput::make('total_amount')")
        ->and(substr_count($contents, '->disabled()'))->toBeGreaterThanOrEqual(2);
});
