@extends($layout)

@section('title', 'Nuevo perfil – MedicApp')

@section('content')
<main class="flex-grow flex items-center justify-center">
    <div class="w-full max-w-2xl px-8">
        <h2 class="text-3xl font-bold text-center mb-10">Datos del paciente</h2>

        {{-- Errores de validación --}}
        @if ($errors->any())
            <div class="mb-6 p-4 rounded bg-red-100 text-red-800">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('perfil.store') }}" class="space-y-6">
            @csrf

            <!-- Nombre del perfil -->
            <div>
                <label for="nombre_paciente" class="block mb-1 text-lg">Nombre</label>
                <input id="nombre_paciente" name="nombre_paciente" type="text" required
                       value="{{ old('nombre_paciente') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded text-[#0C1222] focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Fecha de nacimiento -->
            <div>
                <label for="fecha_nacimiento" class="block mb-1 text-lg">Fecha de nacimiento</label>
                <input id="fecha_nacimiento" name="fecha_nacimiento" type="date" required
                       min="1900-01-01" max="{{ \Carbon\Carbon::now()->toDateString() }}"
                       value="{{ old('fecha_nacimiento') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded text-[#0C1222] focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Género -->
            <div>
                <label for="sexo" class="block mb-1 text-lg">Género</label>
                <select id="sexo" name="sexo" required
                        class="w-full px-4 py-3 border border-gray-300 rounded text-[#0C1222] bg-white focus:outline-none focus:ring-2 focus:ring-blue-400">
                    @php $sexoOld = old('sexo'); @endphp
                    <option value="F" {{ $sexoOld==='F' ? 'selected' : '' }}>Mujer</option>
                    <option value="M" {{ $sexoOld==='M' ? 'selected' : '' }}>Hombre</option>
                    <option value="NB" {{ $sexoOld==='NB' ? 'selected' : '' }}>No binario</option>
                    <option value="O" {{ $sexoOld==='O' ? 'selected' : '' }}>Otro</option>
                </select>
            </div>

            <!-- Causa del tratamiento -->
            <div>
                <label for="causa" class="block mb-1 text-lg">Causa de tratamiento</label>
                <input id="causa" name="causa" type="text" required maxlength="150"
                       value="{{ old('causa') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded text-[#0C1222] focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Botón -->
            <div class="text-center mt-8">
                <button type="submit"
                        class="bg-yellow-300 text-[#0C1222] font-bold text-lg px-10 py-3 rounded-full hover:bg-yellow-200 transition">
                    Crear perfil
                </button>
            </div>
        </form>
    </div>
</main>
@endsection
