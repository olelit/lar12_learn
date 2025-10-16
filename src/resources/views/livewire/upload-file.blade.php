<div class="bg-white shadow-lg rounded-lg p-8">
    <h1 class="text-2xl font-bold mb-4 text-gray-800">Upload your documents</h1>

    <p class="text-sm text-gray-500 mb-6">
        Supported formats: <span class="font-semibold">NUMBERS, XLSX, XLS</span>
    </p>

    @if (session()->has('message'))
        <div class="mb-4 p-2 bg-green-100 text-green-800 rounded">
            {{ session('message') }}
        </div>
    @endif

    {{-- Форма загрузки --}}
    <form wire:submit.prevent="upload" class="flex flex-col gap-4">
        <input type="file" wire:model="file" class="border border-gray-300 rounded p-2">

        @error('file')
        <span class="text-red-600 text-sm">{{ $message }}</span>
        @enderror

        {{-- Кнопка загрузки --}}
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            Upload
        </button>
    </form>

    <div wire:loading wire:target="file" class="text-gray-500 text-sm mt-2">
        Uploading...
    </div>
</div>
