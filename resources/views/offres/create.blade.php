@extends('layouts.app')

@section('title', 'Nouvelle offre')

@section('content')
    <div class="max-w-xl">
        <flux:button variant="ghost" icon="arrow-left" :href="route('offres.index')" class="mb-4">Retour à la liste</flux:button>

        <flux:heading size="xl" level="1" class="mb-6">Nouvelle offre</flux:heading>

        <form action="{{ route('offres.store') }}" method="POST" class="flex flex-col gap-5">
            @csrf
            @include('offres._form', ['offer' => null])

            <div class="flex gap-2">
                <flux:button variant="primary" type="submit">Ajouter</flux:button>
                <flux:button :href="route('offres.index')">Annuler</flux:button>
            </div>
        </form>
    </div>
@endsection
