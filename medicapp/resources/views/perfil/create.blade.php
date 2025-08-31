@extends($layout)

@section('title', 'Nuevo perfil – MedicApp')

@section('content')
<main class="flex-grow flex items-center justify-center px-4 py-6">
    <div class="w-full max-w-sm sm:max-w-md lg:max-w-2xl">
        <h2 class="text-2xl sm:text-3xl font-bold text-center mb-6 sm:mb-10">Datos del paciente</h2>
        @if ($errors->any())
            <div class="mb-4 sm:mb-6 p-3 sm:p-4 rounded bg-red-100 text-red-800 text-sm">
                <ul class="list-disc ml-4 sm:ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('perfil.store') }}" class="space-y-4 sm:space-y-6">
            @csrf
            <div>
                <label for="nombre_paciente" class="block mb-1 text-base sm:text-lg">Nombre</label>
                <input id="nombre_paciente" name="nombre_paciente" type="text" required
                       value="{{ old('nombre_paciente') }}"
                       class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded text-[#0C1222] text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label for="fecha_nacimiento" class="block mb-1 text-base sm:text-lg">Fecha de nacimiento</label>
                <input id="fecha_nacimiento" name="fecha_nacimiento" type="date" required
                       min="1900-01-01" max="{{ \Carbon\Carbon::now()->toDateString() }}"
                       value="{{ old('fecha_nacimiento') }}"
                       class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded text-[#0C1222] text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label for="sexo" class="block mb-1 text-base sm:text-lg">Género</label>
                <select id="sexo" name="sexo" required
                        class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded text-[#0C1222] text-sm sm:text-base bg-white focus:outline-none focus:ring-2 focus:ring-blue-400">
                    @php $sexoOld = old('sexo'); @endphp
                    <option value="F" {{ $sexoOld==='F' ? 'selected' : '' }}>Mujer</option>
                    <option value="M" {{ $sexoOld==='M' ? 'selected' : '' }}>Hombre</option>
                    <option value="NB" {{ $sexoOld==='NB' ? 'selected' : '' }}>No binario</option>
                    <option value="O" {{ $sexoOld==='O' ? 'selected' : '' }}>Otro</option>
                </select>
            </div>
            <div>
                <label for="causa" class="block mb-1 text-base sm:text-lg">Causa de tratamiento</label>
                <input id="causa" name="causa" type="text" required maxlength="150"
                       value="{{ old('causa') }}"
                       class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded text-[#0C1222] text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div class="text-center mt-6 sm:mt-8">
                <button type="submit"
                        class="bg-yellow-300 text-[#0C1222] font-bold text-base sm:text-lg px-6 sm:px-10 py-2 sm:py-3 rounded-full hover:bg-yellow-200 transition w-full sm:w-auto">
                    Crear perfil
                </button>
            </div>
        </form>
    </div>
</main>
@endsection
