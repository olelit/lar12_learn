<div class="w-full max-w-md mx-auto bg-white shadow-lg rounded-lg p-8 flex flex-col items-center">

    <!-- Информационная зона -->
    <div class="w-full mb-6 p-4 bg-blue-50 border border-blue-200 rounded text-center text-sm text-gray-700">
        Supported formats: <strong>.csv, .txt, .xls, .xlsx, .numbers</strong><br>
        You can also use our Telegram bot:
        <a href="https://t.me/evrth_to_csv_bot" target="_blank" class="text-blue-600 font-medium hover:underline">
            @evrth_to_csv_bot
        </a>
    </div>

    <h1 class="text-2xl font-bold mb-6 text-gray-800 text-center">
        CSV Converter
    </h1>

    @if(session()->has('message'))
        <div class="mb-4 p-2 bg-green-100 text-green-800 rounded text-center">
            {{ session('message') }}
        </div>
    @endif

    <div
        x-data="{ isDragging: false }"
        x-on:dragover.prevent="isDragging = true"
        x-on:dragleave.prevent="isDragging = false"
        x-on:drop.prevent="isDragging = false"
        class="w-full"
    >
        <label
            for="file-upload"
            :class="isDragging ? 'border-blue-700 bg-blue-50' : 'border-blue-500'"
            class="flex flex-col items-center justify-center w-full h-40 border-4 border-solid rounded-lg cursor-pointer transition shadow-md hover:shadow-lg text-center">

            <!-- Иконка -->
            <svg class="w-10 h-10 mb-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M12 12v8m0-8l-3 3m3-3l3 3"></path>
            </svg>

            <span class="text-gray-700 text-sm font-medium">
                Click or drag file here to upload
            </span>

            <input
                id="file-upload"
                type="file"
                wire:model="file"
                class="hidden"
                accept=".csv,.txt,.xls,.xlsx,.numbers"
            >
        </label>
    </div>

    @error('file')
    <span class="text-red-600 text-sm mt-2">{{ $message }}</span>
    @enderror

    @if($file)
        <div wire:loading wire:target="file" class="flex items-center mt-4">
            <svg class="animate-spin h-5 w-5 mr-2 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
            <span class="text-gray-500 text-sm">Uploading...</span>
        </div>
    @endif

    @if(!empty($downloadPath))
        <button
            wire:click="downloadConverted"
            class="mt-6 bg-blue-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
            Download Converted File
        </button>
    @endif
</div>
