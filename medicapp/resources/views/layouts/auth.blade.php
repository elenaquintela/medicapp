<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'MedicApp' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>
<body class="bg-[#0C1222] text-white min-h-dvh flex flex-col">

    @include('components.auth-header')

    <div class="flex flex-1 min-h-0">
        @include('components.sidebar')

        <main class="flex-1 min-w-0 overflow-y-auto">
            <div class="w-full px-4 sm:px-6 lg:px-10 py-6">
                @yield('content')
            </div>
        </main>
    </div>

    @include('components.footer')

    @stack('scripts')
</body>
</html>
