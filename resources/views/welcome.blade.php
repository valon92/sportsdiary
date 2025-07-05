{{-- resources/views/welcome.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Sports Diary</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="d-flex flex-column h-100">
        <div id="app" class="d-flex flex-column flex-grow-1">
            {{-- Vue.js do të vendosë këtu Navbar, Footer dhe përmbajtjen tjetër --}}
            {{-- Kjo do të ngarkohet nga App.vue --}}
        </div>
    </body>
</html>