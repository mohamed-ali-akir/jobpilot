{{--
    Layout global de JobPilot.
    Deux façons de l'utiliser :
      1. Comme un layout classique (vu en séance 2) :
            @extends('layouts.app')
            @section('title', 'Offres')
            @section('content') ... @endsection
      2. Comme un composant (pages du starter kit) :
            <x-layouts::app :title="..."> ... </x-layouts::app>
--}}
<x-layouts::app.sidebar :title="$title ?? ($__env->yieldContent('title') ?: null)">
    <flux:main>
        {{-- Messages flash (séance 5) : affichés sur toutes les pages --}}
        @if (session('success'))
            <flux:callout variant="success" icon="check-circle" heading="{{ session('success') }}" class="mb-6" />
        @endif

        @if (session('error'))
            <flux:callout variant="danger" icon="x-circle" heading="{{ session('error') }}" class="mb-6" />
        @endif

        {{ $slot ?? '' }}

        @yield('content')
    </flux:main>
</x-layouts::app.sidebar>
