@props(['perfilesUsuario', 'perfilActivo' => null])

@php
    $usuario = Auth::user();
    $rol = $usuario->rol_global;
@endphp

<header class="bg-[#0C1222] text-white py-2 sm:py-4 px-3 sm:px-6 flex items-center justify-between shadow-md">
    <!-- Logo y nombre de la app - siempre a la izquierda -->
    <a href="{{ route('dashboard') }}" class="shrink-0 flex items-center space-x-2 sm:space-x-3 hover:opacity-90 transition">
        <img src="{{ asset('logo.png') }}" alt="Logo MedicApp" class="w-12 sm:w-16 lg:w-20 h-auto">
        <span class="text-xl sm:text-2xl lg:text-4xl font-bold text-white">MedicApp</span>
    </a>

    <!-- Controles del usuario - reorganizados para móvil -->
    <div class="flex items-center space-x-2 sm:space-x-4 lg:space-x-6">
        <!-- Dropdown de perfiles -->
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button class="bg-yellow-300 text-[#0C1222] font-semibold px-2 sm:px-4 py-1 sm:py-2 rounded-full shadow hover:bg-yellow-200 transition inline-flex items-center text-xs sm:text-sm">
                    <span class="hidden sm:inline">{{ $perfilActivo->nombre_paciente ?? 'Perfil actual' }}</span>
                    <span class="sm:hidden">{{ Str::limit($perfilActivo->nombre_paciente ?? 'Perfil', 8, '') }}</span>
                    <svg class="ml-1 sm:ml-2 w-3 h-3 sm:w-4 sm:h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5.23 7.21a.75.75 0 011.06.02L10 10.939l3.71-3.71a.75.75 0 011.08 1.04l-4.25 4.25a.75.75 0 01-1.08 0l-4.25-4.25a.75.75 0 01.02-1.06z"/>
                    </svg>
                </button>
            </x-slot>

            <x-slot name="content">
                @if (count($perfilesUsuario) <= 1)
                    <x-dropdown-link :href="route('perfil.create', ['fromDashboard' => 1])">
                        Crear nuevo perfil
                    </x-dropdown-link>
                @else
                    @foreach ($perfilesUsuario as $perfil)
                        <form method="POST" action="{{ route('perfil.seleccionar') }}">
                            @csrf
                            <input type="hidden" name="id_perfil" value="{{ $perfil->id_perfil }}">
                            <input type="hidden" name="redirect_to" value="{{ request()->fullUrl() }}">
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700">
                                {{ $perfil->nombre_paciente }}
                            </button>
                        </form>
                    @endforeach

                    <hr class="my-2 border-gray-300">

                    <x-dropdown-link :href="route('perfil.create', ['fromDashboard' => 1])">
                        Nuevo perfil
                    </x-dropdown-link>
                @endif
            </x-slot>
        </x-dropdown>

        <!-- Notificaciones -->
        <div class="relative">
            <button type="button" class="relative inline-flex items-center p-1 sm:p-2" data-bell title="Notificaciones">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 sm:w-6 sm:h-6 text-orange-400" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zm.104-14.684a1.5 1.5 0 1 0-1.208 0A5.002 5.002 0 0 0 3 6c0 1.098-.628 2.082-1.579 2.563A.5.5 0 0 0 1.5 9.5h13a.5.5 0 0 0 .079-.937A2.993 2.993 0 0 1 13 6a5.002 5.002 0 0 0-4.896-4.684z"/>
                </svg>
                <span data-bell-badge class="hidden absolute -top-1 -right-1 bg-red-500 text-white text-[9px] sm:text-[10px] leading-none px-1 sm:px-1.5 py-0.5 rounded-full">0</span>
            </button>

            <div data-bell-menu class="hidden absolute right-0 mt-2 w-72 sm:w-80 bg-[#0C1222] border border-gray-700 rounded-xl shadow-xl overflow-hidden z-50 max-h-[80vh] sm:max-h-none">
                <div class="px-3 sm:px-4 py-2 sm:py-3 border-b border-gray-700 flex items-center justify-between">
                    <span class="text-xs sm:text-sm font-semibold">Tomas</span>
                    <button type="button" data-bell-markall class="text-[10px] sm:text-xs text-blue-300 hover:text-blue-200">Marcar todas como leídas</button>
                </div>

                <div data-bell-empty class="hidden px-3 sm:px-4 py-6 sm:py-8 text-xs sm:text-sm text-gray-400 text-center">
                    No hay notificaciones que mostrar
                </div>

                <ul data-bell-list class="max-h-48 sm:max-h-64 overflow-auto divide-y divide-gray-800"></ul>

                <div data-bell-recent-header class="px-3 sm:px-4 py-2 text-[10px] sm:text-xs opacity-70 border-t border-gray-800">Recientes</div>
                <ul data-bell-list-recent class="max-h-32 sm:max-h-40 overflow-auto divide-y divide-gray-800"></ul>
            </div>
        </div>
    </div>

    <!-- Dropdown de usuario - solo visible en desktop -->
    @php
        $user = Auth::user();
        $isPremium = $user->rol_global === 'premium';
    @endphp

    <div class="hidden sm:block">
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button
                    class="inline-flex items-center px-2 sm:px-4 py-1 sm:py-2 border border-transparent rounded-full shadow transition text-xs sm:text-sm
                    {{ $isPremium ? 'bg-[#7fb0dd] text-white hover:bg-[#6aa1d0]' : 'bg-yellow-300 text-[#0C1222] hover:bg-yellow-200' }}">
                    <span class="font-bold mr-1 sm:mr-2 hidden sm:inline">{{ $user->nombre ?? $user->name }}</span>
                    <span class="font-bold mr-1 sm:hidden">{{ Str::limit($user->nombre ?? $user->name, 6, '') }}</span>
                    <span class="text-xs sm:text-sm font-semibold {{ $isPremium ? 'text-white' : 'text-[#0C1222]' }}">
                        {{ ucfirst($user->rol_global) }}
                    </span>
                    <svg class="ml-1 sm:ml-2 w-3 h-3 sm:w-4 sm:h-4 {{ $isPremium ? 'text-white' : 'text-[#0C1222]' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </x-slot>

            <x-slot name="content">
                <x-dropdown-link :href="route('account.edit')">
                    Cuenta
                </x-dropdown-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link href="{{ route('logout') }}"
                                     onclick="event.preventDefault(); this.closest('form').submit();">
                        Salir
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</header>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const bell = document.querySelector('[data-bell]');
  const badge = document.querySelector('[data-bell-badge]');
  const menu = document.querySelector('[data-bell-menu]');
  const list = document.querySelector('[data-bell-list]');
  const listRecent = document.querySelector('[data-bell-list-recent]');
  const markAllBtn = document.querySelector('[data-bell-markall]');
  const emptyBox = document.querySelector('[data-bell-empty]');
  const recentHeader = document.querySelector('[data-bell-recent-header]');

  if (!bell || !badge || !menu || !list || !listRecent) return;

  const ORIGINAL_TITLE = document.title;
  const USER_ID = {{ Auth::id() }};
  let menuOpen = false;
  let currentUnreadCount = 0;
  let currentUnseenCount = 0; 
  let currentMaxId = 0;  
  
  function getStoredValue(key, defaultValue = 0) {
    try {
      return parseInt(localStorage.getItem(key)) || defaultValue;
    } catch (e) {
      console.warn('localStorage not available, using session storage');
      return parseInt(sessionStorage.getItem(key)) || defaultValue;
    }
  }
  
  function setStoredValue(key, value) {
    try {
      localStorage.setItem(key, value.toString());
    } catch (e) {
      sessionStorage.setItem(key, value.toString());
    }
  }
  
  let lastSeenMaxId = getStoredValue(`notif_last_seen_id_${USER_ID}`);  

  function applyIndicators() {
    const hasUnseen = currentUnseenCount > 0 && !menuOpen;

    if (hasUnseen) {
      badge.textContent = currentUnseenCount;
      badge.classList.remove('hidden');
      document.title = `(${currentUnseenCount}) ${ORIGINAL_TITLE}`;
    } else {
      badge.textContent = '';
      badge.classList.add('hidden');
      document.title = ORIGINAL_TITLE;
    }
  }

  function showEmptyState() {
    if (emptyBox) emptyBox.classList.remove('hidden');
    list.innerHTML = '';
    listRecent.innerHTML = '';
    list.classList.add('hidden');
    listRecent.classList.add('hidden');
    if (recentHeader) recentHeader.classList.add('hidden');
  }

  function showLists() {
    if (emptyBox) emptyBox.classList.add('hidden');
    list.classList.remove('hidden');
    listRecent.innerHTML = '';
    listRecent.classList.add('hidden');
    if (recentHeader) recentHeader.classList.add('hidden');
  }

  function render(arr, container) {
    container.innerHTML = '';
    if (!arr || !arr.length) return;
    arr.forEach(n => {
      const li = document.createElement('li');
      li.className = 'px-3 sm:px-4 py-2 sm:py-3 hover:bg-gray-800/60';
      li.innerHTML = `
        <div class="text-xs sm:text-sm font-medium">${n.titulo}</div>
        <div class="text-[10px] sm:text-xs opacity-80">${n.msg || ''}</div>
        <div class="text-[9px] sm:text-[11px] opacity-60 mt-1">${n.hora}</div>
      `;
      container.appendChild(li);
    });
  }

  async function fetchData(markSeen = false) {
    try {
      const url = new URL('{{ route('notificaciones.index') }}', window.location.origin);
      if (markSeen) url.searchParams.set('mark_seen', '1');
      url.searchParams.set('last_seen_id', lastSeenMaxId.toString());

      const res = await fetch(url.toString(), {
        headers: { 
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        },
        cache: 'no-store'
      });
      if (!res.ok) {
        currentUnreadCount = 0;
        currentUnseenCount = 0;
        currentMaxId = 0;
        showEmptyState();
        applyIndicators();
        return { count: 0, items: [] };
      }

      const data = await res.json();
      const unread = Array.isArray(data.unread) ? data.unread : [];
      
      currentUnreadCount = data.unread_count || unread.length;
      currentUnseenCount = data.unseen_count || 0; 
      currentMaxId = data.max_id || 0;

      if (menuOpen && currentMaxId > lastSeenMaxId) {
        lastSeenMaxId = currentMaxId;
        setStoredValue(`notif_last_seen_id_${USER_ID}`, lastSeenMaxId);
        currentUnseenCount = 0;
      }

      if (currentUnreadCount === 0) {
        showEmptyState();
      } else {
        showLists();
        render(unread, list);
      }

      applyIndicators();
      return { count: currentUnreadCount, items: unread };
    } catch (e) {
      console.error('Error fetching notifications:', e);
      return { count: currentUnreadCount, items: [] };
    }
  }

  async function marcarTodasSilencioso() {
    try {
      const res = await fetch(`{{ route('notificaciones.leerTodas') }}`, {
        method: 'POST',
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        }
      });
      return res.ok;
    } catch { return false; }
  }

  bell.addEventListener('click', async () => {
    const willOpen = menu.classList.contains('hidden');
    menu.classList.toggle('hidden');
    menuOpen = willOpen;

    if (willOpen) {
      await fetchData(true); 
      lastSeenMaxId = Math.max(lastSeenMaxId, currentMaxId);
      setStoredValue(`notif_last_seen_id_${USER_ID}`, lastSeenMaxId);
      applyIndicators(); 
    } else {
      fetchData();
    }
  });

  document.addEventListener('click', (e) => {
    if (!menu.contains(e.target) && !bell.contains(e.target)) {
      if (!menu.classList.contains('hidden')) {
        menu.classList.add('hidden');
        menuOpen = false;
        fetchData();
      }
    }
  });

  if (markAllBtn) {
    markAllBtn.addEventListener('click', async () => {
      const ok = await marcarTodasSilencioso();
      if (ok) {
        currentUnreadCount = 0;
        currentUnseenCount = 0; 

        lastSeenMaxId = Math.max(lastSeenMaxId, currentMaxId);
        setStoredValue(`notif_last_seen_id_${USER_ID}`, lastSeenMaxId);
        showEmptyState();
        applyIndicators();
      }
    });
  }

  fetchData();
  const POLL_MS = 10000; 
  setInterval(fetchData, POLL_MS);
  document.addEventListener('visibilitychange', () => { if (!document.hidden) fetchData(); });
  window.addEventListener('online', fetchData);
});
</script>
@endpush
