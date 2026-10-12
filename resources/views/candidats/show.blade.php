@extends('layouts.app')

@section('title', $candidat->full_name)

@section('content')
    <flux:button variant="ghost" icon="arrow-left" :href="route('candidats.index')" class="mb-4">Retour à la liste</flux:button>

    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <flux:heading size="xl" level="1">{{ $candidat->full_name }}</flux:heading>
            <flux:text>{{ $candidat->offers->count() }} candidature(s)</flux:text>
        </div>
        <flux:button icon="pencil-square" :href="route('candidats.edit', $candidat)">Modifier</flux:button>
    </div>

    {{-- Relation many-to-many : $candidat->offers --}}
    <div class="grid gap-4 md:grid-cols-2">
        @forelse ($candidat->offers as $offer)
            <x-offre-card :offer="$offer">
                <flux:text size="sm" class="me-auto">Postulé le {{ $offer->pivot->created_at->format('d/m/Y') }}</flux:text>
                <flux:button size="sm" icon="eye" :href="route('offres.show', $offer)">Voir l'offre</flux:button>
            </x-offre-card>
        @empty
            <flux:text>Ce candidat n'a postulé à aucune offre.</flux:text>
        @endforelse
    </div>
@endsection
