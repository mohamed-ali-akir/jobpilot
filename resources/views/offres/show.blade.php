@extends('layouts.app')

@section('title', $offer->name)

@section('content')
    <div class="max-w-3xl">
        <flux:button variant="ghost" icon="arrow-left" :href="route('offres.index')" class="mb-4">Retour à la liste</flux:button>

        <x-offre-card :offer="$offer">
            <flux:button size="sm" icon="pencil-square" :href="route('offres.edit', $offer)">Modifier</flux:button>
            <flux:button size="sm" icon="building-office" :href="route('entreprises.show', $offer->company)">Voir l'entreprise</flux:button>
        </x-offre-card>

        <flux:heading size="lg" class="mb-3 mt-8">Candidats ({{ $offer->candidats->count() }})</flux:heading>

        @forelse ($offer->candidats as $candidat)
            <div class="flex items-center justify-between border-b border-zinc-200 py-2 dark:border-zinc-700">
                <a href="{{ route('candidats.show', $candidat) }}" class="hover:underline">{{ $candidat->full_name }}</a>
                <flux:text size="sm">a postulé le {{ $candidat->pivot->created_at->format('d/m/Y') }}</flux:text>
            </div>
        @empty
            <flux:text>Aucun candidat n'a encore postulé.</flux:text>
        @endforelse
    </div>
@endsection
