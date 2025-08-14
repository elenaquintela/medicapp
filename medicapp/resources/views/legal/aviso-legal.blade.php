@extends('layouts.registro')

@section('title', 'Aviso Legal – MedicApp')

@section('content')
<main class="flex-grow flex items-center justify-center">
    <div class="w-full max-w-2xl px-8">
        <h2 class="text-3xl font-bold text-center mb-10">Aviso Legal</h2>
         @include('components.legal-back')

        
    </div>
</main>
@endsection
