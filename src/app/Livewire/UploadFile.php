<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Http\UploadedFile;

class UploadFile extends Component
{
    use WithFileUploads;

    public ?UploadedFile $file = null;

    protected array $rules = [
        'file' => ['required', 'file', 'mimes:numbers,xlsx,xls'],
    ];

    public function upload(): void
    {
        $this->validate();

        $path = $this->file->store('uploads');
    }

    public function render()
    {
        return view('livewire.upload-file');
    }
}
