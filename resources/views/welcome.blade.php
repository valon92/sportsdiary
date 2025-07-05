{{-- resources/views/welcome.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Sports Diary</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        {{-- Kjo rresht është kyçe për të ngarkuar aplikacionin tënd Vue --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        {{-- Kjo është ID-ja ku aplikacioni yt Vue.js do të montohet --}}
        <div id="app">
            {{-- Vue.js do të vendosë këtu Navbar, Footer dhe përmbajtjen tjetër --}}
        </div>
    </body>
</html>