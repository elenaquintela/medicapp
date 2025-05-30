<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'MedicApp' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0C1222] text-white min-h-screen flex flex-col">

    {{-- Header arriba del todo --}}
    @include('components.auth-header')

    {{-- Contenedor principal: sidebar + contenido --}}
    <div class="flex flex-1 min-h-0">
        {{-- Sidebar a la izquierda --}}
        @include('components.sidebar')

        {{-- Contenido principal --}}
        <main class="flex-1 p-6 overflow-y-auto">
            @yield('content')
        </main>
    </div>

    {{-- Footer abajo del todo --}}
    @include('components.footer')

</body>
</html>
