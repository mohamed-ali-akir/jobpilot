@extends('layouts.app')

@section('title', 'Nouveau candidat')

@section('content')
    <div class="max-w-2xl">
        <flux:button variant="ghost" icon="arrow-left" :href="route('candidats.index')" class="mb-4">Retour à la liste</flux:button>

        <flux:heading size="xl" level="1" class="mb-6">Nouveau candidat</flux:heading>

        <form action="{{ route('candidats.store') }}" method="POST" class="flex flex-col gap-5">
            @csrf
            @include('candidats._form', ['candidat' => null])

            <div class="flex gap-2">
                <flux:button variant="primary" type="submit">Ajouter</flux:button>
                <flux:button :href="route('candidats.index')">Annuler</flux:button>
            </div>
        </form>
    </div>
@endsection
