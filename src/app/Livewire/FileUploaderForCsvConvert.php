<?php

namespace App\Livewire;

use App\Services\Web\V1\FileUploaderForCsvConvertService;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\UploadedFile;

class FileUploaderForCsvConvert extends Component
{
    use WithFileUploads;

    public ?UploadedFile $file = null;
    public ?string $downloadPath = null;
    protected array $rules = [
        'file' => ['required', 'file'],
    ];

    public function save(): void
    {
        $this->validate();

        if ($this->file) {
            $csvConvertService = app(FileUploaderForCsvConvertService::class);
            $this->downloadPath = $csvConvertService->saveAndConvert($this->file);
        } else {
            Log::warning('Upload called but file is null');
            session()->flash('message', 'No file selected.');
        }
    }

    public function downloadConverted()
    {
        if (!$this->downloadPath) {
            return;
        }

        return response()->download($this->downloadPath);
    }

    public function render()
    {
        return view('livewire.file-uploader-for-csv-convert');
    }
}
