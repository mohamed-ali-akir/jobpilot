@extends('layouts.app')

@section('title', $titre)

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <flux:heading size="xl" level="1">{{ $titre }}</flux:heading>
            <flux:text>{{ $offers->count() }} offre(s) publiée(s)</flux:text>
        </div>
        @can('create', App\Models\Offer::class)
            <flux:button variant="primary" icon="plus" :href="route('offres.create')">Ajouter une offre</flux:button>
        @endcan
    </div>

    <div class="grid gap-4 md:grid-cols-2">
        @forelse ($offers as $offer)
            <x-offre-card :offer="$offer">
                <flux:text size="sm" class="me-auto">{{ $offer->candidats_count }} candidature(s)</flux:text>
                <flux:button size="sm" icon="eye" :href="route('offres.show', $offer)">Voir</flux:button>
                @can('update', $offer)
                    <flux:button size="sm" icon="pencil-square" :href="route('offres.edit', $offer)">Modifier</flux:button>
                @endcan
                @can('delete', $offer)
                    <form action="{{ route('offres.destroy', $offer) }}" method="POST" onsubmit="return confirm('Confirmer la suppression ?')">
                        @csrf
                        @method('DELETE')
                        <flux:button size="sm" variant="danger" icon="trash" type="submit">Supprimer</flux:button>
                    </form>
                @endcan
            </x-offre-card>
        @empty
            <flux:text>Aucune offre pour le moment.</flux:text>
        @endforelse
    </div>
@endsection