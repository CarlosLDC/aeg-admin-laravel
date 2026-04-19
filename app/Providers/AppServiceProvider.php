<?php

namespace App\Providers;

use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Field;
use Filament\Infolists\Components\Entry;
use Filament\Tables\Columns\Column;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        DeleteAction::configureUsing(function (DeleteAction $action): void {
            $action->failureNotificationTitle('No se puede eliminar este registro porque tiene información relacionada.');

            $action->using(function (Model $record): bool {
                try {
                    $result = $record->delete();

                    if (is_null($result)) {
                        return true;
                    }

                    return $result;
                } catch (QueryException) {
                    return false;
                }
            });
        });

        DeleteBulkAction::configureUsing(function (DeleteBulkAction $action): void {
            $action->failureNotificationTitle('No se pudieron eliminar uno o más registros porque tienen información relacionada.');
        });

        Field::configureUsing(function (Field $field): void {
            $field->translateLabel();
        });

        Column::configureUsing(function (Column $column): void {
            $column->translateLabel();
        });

        Entry::configureUsing(function (Entry $entry): void {
            $entry->translateLabel();
        });
    }
}
