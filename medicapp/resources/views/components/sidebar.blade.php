@php
    $rol = Auth::user()->rol_global;
@endphp

<!-- Menú lateral completo -->
<div x-data="{ menuAbierto: false }" class="relative flex flex-col min-h-screen">

    <!-- Botón para colapsar/desplegar -->
    <button @click="menuAbierto = !menuAbierto"
            class="absolute -right-3 top-20 z-10 bg-yellow-300 text-[#0C1222] rounded-full w-8 h-16 flex items-center justify-center shadow hover:bg-yellow-200 transition">
        <svg :class="{ 'rotate-180': menuAbierto }" class="w-6 h-6 transition-transform" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M6.293 14.707a1 1 0 010-1.414L10.586 9 6.293 4.707a1 1 0 011.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd" />
        </svg>
    </button>

    <!-- Sidebar -->
    <aside :class="menuAbierto ? 'w-56' : 'w-12'"
           class="bg-yellow-200 text-[#0C1222] transition-all duration-300 overflow-hidden p-6 space-y-4 h-full flex flex-col">

        <nav class="flex flex-col space-y-4 font-bold text-lg">
            <a href="{{ route('dashboard') }}" class="hover:text-orange-600 whitespace-nowrap" x-show="menuAbierto">Inicio</a>
            <a href="{{ route('tratamiento.index') }}" class="hover:text-orange-600 whitespace-nowrap" x-show="menuAbierto">Tratamientos</a>
            <a href="{{ route('cita.index') }}" class="hover:text-orange-600 whitespace-nowrap" x-show="menuAbierto">Citas</a>
            <a href="{{ route('perfil.index') }}" class="hover:text-orange-600 whitespace-nowrap" x-show="menuAbierto">Perfiles</a>

            @if ($rol === 'premium')
                <a href="#" class="hover:text-orange-600 whitespace-nowrap" x-show="menuAbierto">Informes</a>
            @else
                <span class="text-gray-400 cursor-not-allowed whitespace-nowrap" x-show="menuAbierto">Informes</span>
            @endif

            <a href="{{ route('account.edit') }}" class="hover:text-orange-600 whitespace-nowrap" x-show="menuAbierto">Ajustes</a>
            <form method="POST" action="{{ route('logout') }}" x-show="menuAbierto" class="mt-8">
                @csrf
                <button type="submit" class="text-red-600 hover:underline whitespace-nowrap">SALIR</button>
            </form>
        </nav>
    </aside>
</div>
