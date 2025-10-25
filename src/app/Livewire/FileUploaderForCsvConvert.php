<?php

namespace App\Livewire;

use App\Services\FileHistoryService;
use App\Services\Web\V1\FileUploaderForCsvConvertService;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FileUploaderForCsvConvert extends Component
{
    use WithFileUploads;

    public ?UploadedFile $file = null;
    public ?string $downloadPath = null;

    /** @var array<string, array<string>> $rules */
    protected array $rules = [
        'file' => ['required', 'file'],
    ];

    public function updatedFile(): void
    {
        $this->validate();

        if ($this->file) {
            $csvConvertService = app(FileUploaderForCsvConvertService::class);
            $this->downloadPath = $csvConvertService->saveAndConvert($this->file);

            if (empty($this->downloadPath)) {
                session()->flash('message', 'Invalid File Uploader');
            }

        } else {
            Log::warning('Upload called but file is null');
            session()->flash('message', 'No file selected.');
        }
    }

    public function downloadConverted(): ?BinaryFileResponse
    {
        try {
            if (!$this->downloadPath) {
                return null;
            }

            /** @var FileHistoryService $fileHistoryService */
            $fileHistoryService = app(FileHistoryService::class);
            $outerName = pathinfo($this->downloadPath, PATHINFO_BASENAME);
            $historyInfo = $fileHistoryService->getFileHistByOuter($outerName);
            $filename = sprintf('%s.csv', $historyInfo->original_name);
            return response()->download($this->downloadPath, $filename);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            session()->flash('message', 'Cannot download file.');
        }

        return null;
    }

    public function render(): View
    {
        return view('livewire.file-uploader-for-csv-convert');
    }
}
