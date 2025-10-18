<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\UploadedFile;

class FileUploaderForCsvConvert extends Component
{
    use WithFileUploads;

    public ?UploadedFile $file = null;

    protected array $rules = [
        'file' => ['required', 'file'],
    ];

    public function save(): void
    {
        $this->validate();

        // Проверяем, что файл реально пришёл
        if ($this->file) {
            $filename = $this->file->getClientOriginalName();
            Log::info("✅ CSV file uploaded: {$filename}");

            // Сохраняем файл во временное хранилище
            $path = $this->file->store('csv_uploads');
            session()->flash('message', "File uploaded successfully: {$filename} (saved to {$path})");
        } else {
            Log::warning('Upload called but file is null');
            session()->flash('message', 'No file selected.');
        }
    }

    public function render()
    {
        return view('livewire.file-uploader-for-csv-convert');
    }
}
