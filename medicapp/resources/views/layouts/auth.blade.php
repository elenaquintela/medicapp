<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'MedicApp' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0C1222] text-white min-h-screen flex flex-col">

    @include('components.auth-header')

    <div class="flex flex-1 min-h-screen">
        @include('components.sidebar')
        <main class="flex-1 p-6 overflow-y-auto">
            @yield('content')
        </main>
    </div>
    
    @include('components.footer')

    @stack('scripts')
</body>
</html>
