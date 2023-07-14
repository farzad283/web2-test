<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Laravel Livewire App</title>
    
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @livewireStyles
</head>
<body>
    <div class="bg-blue-500">@livewire('header')</div>
    @livewire('many-bottles') 
    @livewireScripts
    <div class="bg-blue-500">@livewire('footer') </div>
</body>
</html>
