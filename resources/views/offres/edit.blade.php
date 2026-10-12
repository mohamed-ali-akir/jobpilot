@extends('layouts.app')

@section('title', 'Modifier l\'offre')

@section('content')
    <div class="max-w-xl">
        <flux:button variant="ghost" icon="arrow-left" :href="route('offres.index')" class="mb-4">Retour à la liste</flux:button>

        <flux:heading size="xl" level="1" class="mb-6">Modifier l'offre « {{ $offer->name }} »</flux:heading>

        <form action="{{ route('offres.update', $offer) }}" method="POST" class="flex flex-col gap-5">
            @csrf
            @method('PUT')
            @include('offres._form')

            <div class="flex gap-2">
                <flux:button variant="primary" type="submit">Enregistrer</flux:button>
                <flux:button :href="route('offres.index')">Annuler</flux:button>
            </div>
        </form>
    </div>
@endsection
