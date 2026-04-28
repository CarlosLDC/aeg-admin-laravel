<?php

namespace App\Filament\Resources\Companies\Resources\Branches\Pages;

use App\Filament\Resources\Companies\Resources\Branches\BranchResource;
use App\Services\AI\DocumentExtractionService;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class CreateBranch extends CreateRecord
{
    protected static string $resource = BranchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('autofillFromDocument')
                ->label('Autollenar')
                ->icon('heroicon-o-sparkles')
                ->modalHeading('Autollenar formulario de Sucursal')
                ->modalDescription(null)
                ->modalSubmitActionLabel('Analizar documento')
                ->schema([
                    FileUpload::make('document')
                        ->label('Documento')
                        ->required()
                        ->disk((string) config('ai.disk', 'local'))
                        ->directory('ai/branch-documents')
                        ->acceptedFileTypes(['application/pdf'])
                        ->maxSize(10_240),
                ])
                ->action(function (array $data): void {
                    $disk = (string) config('ai.disk', 'local');
                    $documentPath = $this->resolveDocumentPath($data['document']);

                    try {
                        $extractedData = app(DocumentExtractionService::class)
                            ->extractBranchDataFromDocument($documentPath, $disk);

                        $this->form->fill($extractedData);

                        Notification::make()
                            ->success()
                            ->title('Formulario completado')
                            ->body('Revise la información extraída antes de guardar.')
                            ->send();
                    } catch (RuntimeException $exception) {
                        Notification::make()
                            ->danger()
                            ->title('No se pudo procesar el documento')
                            ->body($exception->getMessage())
                            ->send();
                    } finally {
                        Storage::disk($disk)->delete($documentPath);
                    }
                }),
        ];
    }

    /**
     * @param  string|array<int, string>|null  $document
     */
    private function resolveDocumentPath(string|array|null $document): string
    {
        $documentPath = is_array($document) ? Arr::first($document) : $document;

        if (! is_string($documentPath) || trim($documentPath) === '') {
            throw new RuntimeException('El documento cargado no tiene un formato válido.');
        }

        return $documentPath;
    }
}
