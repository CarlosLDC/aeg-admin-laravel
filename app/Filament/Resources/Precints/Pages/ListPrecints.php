<?php

namespace App\Filament\Resources\Precints\Pages;

use App\Enums\ColorPrecint;
use App\Enums\EstatusPrecint;
use App\Filament\Resources\Precints\PrecintResource;
use App\Models\Precint;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ListPrecints extends ListRecords
{
    protected static string $resource = PrecintResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('bulkCreate')
                ->label('Crear por lotes')
                ->icon('heroicon-o-queue-list')
                ->modalHeading('Crear precintos por lotes')
                ->modalDescription('Genera múltiples precintos indicando prefijo y rango numérico.')
                ->form([
                    Grid::make(2)
                        ->schema([
                            Select::make('color')
                                ->label('Color')
                                ->required()
                                ->options(ColorPrecint::class)
                                ->default(ColorPrecint::Blanco->value),
                            TextInput::make('prefix')
                                ->label('Prefijo (3 letras)')
                                ->required()
                                ->length(3)
                                ->rule('regex:/^[A-Za-z]{3}$/')
                                ->dehydrateStateUsing(fn (string $state): string => strtoupper($state))
                                ->live(debounce: 400)
                                ->placeholder('ABC'),
                            TextInput::make('start_number')
                                ->label('Número inicial')
                                ->required()
                                ->numeric()
                                ->integer()
                                ->minValue(0)
                                ->live(debounce: 400)
                                ->maxValue(9_999_999),
                            TextInput::make('end_number')
                                ->label('Número final')
                                ->required()
                                ->numeric()
                                ->integer()
                                ->minValue(0)
                                ->maxValue(9_999_999)
                                ->live(debounce: 400)
                                ->gte('start_number'),
                        ]),
                    Placeholder::make('serial_preview')
                        ->label('Previsualización de seriales')
                        ->content(fn (Get $get): string => self::buildSerialPreview($get))
                        ->columnSpanFull(),
                ])
                ->action(function (array $data): void {
                    $prefix = strtoupper($data['prefix']);
                    $startNumber = (int) $data['start_number'];
                    $endNumber = (int) $data['end_number'];
                    $totalPrecints = ($endNumber - $startNumber) + 1;
                    $maxBatchSize = 500;

                    if ($totalPrecints > $maxBatchSize) {
                        throw ValidationException::withMessages([
                            'end_number' => "El rango excede el máximo permitido de {$maxBatchSize} registros por lote.",
                        ]);
                    }

                    $serials = [];

                    for ($number = $startNumber; $number <= $endNumber; $number++) {
                        $serials[] = $prefix.str_pad((string) $number, 7, '0', STR_PAD_LEFT);
                    }

                    $existingSerials = Precint::query()
                        ->whereIn('serial', $serials)
                        ->pluck('serial')
                        ->all();

                    $serialsToCreate = array_values(array_diff($serials, $existingSerials));
                    $omittedCount = count($existingSerials);

                    if ($serialsToCreate === []) {
                        Notification::make()
                            ->warning()
                            ->title('No se crearon precintos.')
                            ->body('Todos los seriales del rango ya existen en la base de datos.')
                            ->send();

                        return;
                    }

                    $now = now();
                    $rows = array_map(static fn (string $serial): array => [
                        'serial' => $serial,
                        'color' => $data['color'],
                        'estatus' => EstatusPrecint::Disponible->value,
                        'created_at' => $now,
                    ], $serialsToCreate);

                    DB::transaction(static function () use ($rows): void {
                        Precint::query()->insert($rows);
                    });

                    $createdCount = count($serialsToCreate);

                    if ($omittedCount > 0) {
                        $preview = implode(', ', array_slice($existingSerials, 0, 5));
                        $suffix = $omittedCount > 5 ? '...' : '';

                        Notification::make()
                            ->warning()
                            ->title("Se crearon {$createdCount} precintos y se omitieron {$omittedCount} repetidos.")
                            ->body("Seriales omitidos: {$preview}{$suffix}")
                            ->send();

                        return;
                    }

                    Notification::make()
                        ->success()
                        ->title("Se crearon {$createdCount} precintos.")
                        ->send();
                }),
        ];
    }

    private static function buildSerialPreview(Get $get): string
    {
        $prefix = strtoupper((string) ($get('prefix') ?? ''));
        $startRaw = $get('start_number');
        $endRaw = $get('end_number');

        if (($prefix === '') || (! preg_match('/^[A-Z]{3}$/', $prefix)) || ! is_numeric($startRaw) || ! is_numeric($endRaw)) {
            return 'Completa prefijo y rango para ver los seriales a crear.';
        }

        $startNumber = (int) $startRaw;
        $endNumber = (int) $endRaw;

        if ($endNumber < $startNumber) {
            return 'El número final debe ser mayor o igual al inicial.';
        }

        $total = ($endNumber - $startNumber) + 1;

        if ($total > 500) {
            return 'El rango supera el máximo permitido de 500 registros por lote.';
        }

        $serials = [];

        for ($number = $startNumber; $number <= $endNumber; $number++) {
            $serials[] = $prefix.str_pad((string) $number, 7, '0', STR_PAD_LEFT);
        }

        $existingSerials = Precint::query()
            ->whereIn('serial', $serials)
            ->pluck('serial')
            ->all();

        $serialsToCreate = array_values(array_diff($serials, $existingSerials));

        if ($serialsToCreate === []) {
            return 'No se crearán seriales nuevos: todos ya existen.';
        }

        $firstSerial = $serialsToCreate[0];
        $lastSerial = $serialsToCreate[array_key_last($serialsToCreate)];

        return "Se creará desde {$firstSerial} hasta {$lastSerial}.";
    }
}
