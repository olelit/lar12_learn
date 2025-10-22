<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Upload Documents' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-blue-600 min-h-screen flex items-center justify-center">

<div class="w-full max-w-md">
    <livewire:file-uploader-for-csv-convert/>
</div>

@livewireScripts

<script>
    document.addEventListener('livewire:load', () => {
        if (window.Livewire && Livewire.uploads) {
            Livewire.uploads = [];
        }
    });
</script>

</body>
</html>
