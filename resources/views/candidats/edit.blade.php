@extends('layouts.app')

@section('title', 'Modifier le candidat')

@section('content')
    <div class="max-w-2xl">
        <flux:button variant="ghost" icon="arrow-left" :href="route('candidats.index')" class="mb-4">Retour à la liste</flux:button>

        <flux:heading size="xl" level="1" class="mb-6">Modifier {{ $candidat->full_name }}</flux:heading>

        <form action="{{ route('candidats.update', $candidat) }}" method="POST" class="flex flex-col gap-5">
            @csrf
            @method('PUT')
            @include('candidats._form')

            <div class="flex gap-2">
                <flux:button variant="primary" type="submit">Enregistrer</flux:button>
                <flux:button :href="route('candidats.index')">Annuler</flux:button>
            </div>
        </form>
    </div>
@endsection
