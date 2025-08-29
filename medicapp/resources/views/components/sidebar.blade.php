@php
    $rol = Auth::user()->rol_global;
@endphp

<div x-data="{ menuAbierto: false, mobileMenuOpen: false }" 
     x-init="
        // Para móvil, usar mobileMenuOpen; para desktop, usar menuAbierto
        window.addEventListener('resize', () => {
            if (window.innerWidth < 1024) {
                mobileMenuOpen = false;
            }
        })
     "
     class="relative flex flex-col min-h-screen">
    
    <!-- Toggle button desktop - igual que antes -->
    <button @click="menuAbierto = !menuAbierto"
            class="hidden lg:block absolute -right-3 top-20 z-10 bg-yellow-300 text-[#0C1222] rounded-full w-8 h-16 flex items-center justify-center shadow hover:bg-yellow-200 transition">
        <svg :class="{ 'rotate-180': menuAbierto }" class="w-6 h-6 transition-transform" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M6.293 14.707a1 1 0 010-1.414L10.586 9 6.293 4.707a1 1 0 011.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd" />
        </svg>
    </button>

    <!-- Toggle button móvil -->
    <button @click="mobileMenuOpen = !mobileMenuOpen"
            class="lg:hidden absolute -right-3 top-16 sm:top-20 z-20 bg-yellow-300 text-[#0C1222] rounded-full w-6 h-12 sm:w-8 sm:h-16 flex items-center justify-center shadow hover:bg-yellow-200 transition">
        <svg :class="{ 'rotate-180': mobileMenuOpen }" class="w-4 h-4 sm:w-6 sm:h-6 transition-transform" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M6.293 14.707a1 1 0 010-1.414L10.586 9 6.293 4.707a1 1 0 011.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd" />
        </svg>
    </button>

    <!-- Overlay para móvil -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="mobileMenuOpen = false"
         class="fixed inset-0 bg-black bg-opacity-50 z-10 lg:hidden"
         style="display: none;">
    </div>

    <!-- Sidebar -->
    <aside class="bg-yellow-200 text-[#0C1222] transition-all duration-300 overflow-hidden flex flex-col
                 lg:relative lg:h-full lg:p-6 lg:space-y-4
                 fixed top-0 left-0 z-15 w-64 h-full p-4 space-y-3 shadow-xl
                 lg:shadow-none"
           :class="{
               // Desktop behavior (pantallas grandes)
               'lg:w-56': menuAbierto,
               'lg:w-12': !menuAbierto,
               // Mobile behavior (pantallas pequeñas)
               'translate-x-0': mobileMenuOpen,
               '-translate-x-full': !mobileMenuOpen
           }">

        <!-- Navegación para desktop -->
        <nav class="hidden lg:flex flex-col space-y-4 font-bold text-lg">
            <a href="{{ route('dashboard') }}" class="hover:text-orange-600 whitespace-nowrap" x-show="menuAbierto">Inicio</a>
            <a href="{{ route('tratamiento.index') }}" class="hover:text-orange-600 whitespace-nowrap" x-show="menuAbierto">Tratamientos</a>
            <a href="{{ route('cita.index') }}" class="hover:text-orange-600 whitespace-nowrap" x-show="menuAbierto">Citas</a>
            <a href="{{ route('perfil.index') }}" class="hover:text-orange-600 whitespace-nowrap" x-show="menuAbierto">Perfiles</a>

            @if ($rol === 'premium')
                <a href="{{ route('informe.index') }}" class="hover:text-orange-600 whitespace-nowrap" x-show="menuAbierto">Informes</a>
            @else
                <span class="text-gray-400 cursor-not-allowed whitespace-nowrap" x-show="menuAbierto">Informes</span>
            @endif

            <a href="{{ route('account.edit') }}" class="hover:text-orange-600 whitespace-nowrap" x-show="menuAbierto">Ajustes</a>
            <form method="POST" action="{{ route('logout') }}" x-show="menuAbierto" class="mt-8">
                @csrf
                <button type="submit" class="text-red-600 hover:underline whitespace-nowrap">SALIR</button>
            </form>
        </nav>

        <!-- Navegación para móvil -->
        <nav class="flex flex-col lg:hidden space-y-3 sm:space-y-4 font-bold text-base sm:text-lg mt-16">
            <a href="{{ route('dashboard') }}" 
               class="hover:text-orange-600 transition-colors p-2 rounded-lg hover:bg-yellow-300">
                <span class="flex items-center space-x-3">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-9 9a1 1 0 001.414 1.414L2 12.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-4.586l.293.293a1 1 0 001.414-1.414l-9-9z"/>
                    </svg>
                    <span>Inicio</span>
                </span>
            </a>
            
            <a href="{{ route('tratamiento.index') }}" 
               class="hover:text-orange-600 transition-colors p-2 rounded-lg hover:bg-yellow-300">
                <span class="flex items-center space-x-3">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span>Tratamientos</span>
                </span>
            </a>
            
            <a href="{{ route('cita.index') }}" 
               class="hover:text-orange-600 transition-colors p-2 rounded-lg hover:bg-yellow-300">
                <span class="flex items-center space-x-3">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                    </svg>
                    <span>Citas</span>
                </span>
            </a>
            
            <a href="{{ route('perfil.index') }}" 
               class="hover:text-orange-600 transition-colors p-2 rounded-lg hover:bg-yellow-300">
                <span class="flex items-center space-x-3">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                    </svg>
                    <span>Perfiles</span>
                </span>
            </a>

            @if ($rol === 'premium')
                <a href="{{ route('informe.index') }}" 
                   class="hover:text-orange-600 transition-colors p-2 rounded-lg hover:bg-yellow-300">
                    <span class="flex items-center space-x-3">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h4a1 1 0 010 2H6.414l2.293 2.293a1 1 0 01.293.707V10a1 1 0 01-2 0V9.414L4.707 7.121A1 1 0 014 6.414V4.586A1 1 0 013 4zm9 1a1 1 0 010-2h4a1 1 0 011 1v4a1 1 0 01-2 0V5.414l-3.293 3.293a1 1 0 01-1.414-1.414L13.586 4H12z" clip-rule="evenodd"/>
                        </svg>
                        <span>Informes</span>
                    </span>
                </a>
            @else
                <span class="text-gray-400 cursor-not-allowed p-2 flex items-center space-x-3">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h4a1 1 0 010 2H6.414l2.293 2.293a1 1 0 01.293.707V10a1 1 0 01-2 0V9.414L4.707 7.121A1 1 0 014 6.414V4.586A1 1 0 013 4zm9 1a1 1 0 010-2h4a1 1 0 011 1v4a1 1 0 01-2 0V5.414l-3.293 3.293a1 1 0 01-1.414-1.414L13.586 4H12z" clip-rule="evenodd"/>
                    </svg>
                    <span>Informes</span>
                </span>
            @endif

            <a href="{{ route('account.edit') }}" 
               class="hover:text-orange-600 transition-colors p-2 rounded-lg hover:bg-yellow-300">
                <span class="flex items-center space-x-3">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                    </svg>
                    <span>Ajustes</span>
                </span>
            </a>
            
            <form method="POST" action="{{ route('logout') }}" class="mt-6 sm:mt-8">
                @csrf
                <button type="submit" 
                        class="text-red-600 hover:text-red-800 transition-colors p-2 rounded-lg hover:bg-red-100 w-full text-left flex items-center space-x-3">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"/>
                    </svg>
                    <span>SALIR</span>
                </button>
            </form>
        </nav>
    </aside>
</div>
