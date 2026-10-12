@extends('layouts.app')

@section('title', $company->nom)

@section('content')
    <flux:button variant="ghost" icon="arrow-left" :href="route('entreprises.index')" class="mb-4">Retour à la liste</flux:button>

    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <flux:heading size="xl" level="1">{{ $company->nom }}</flux:heading>
            <flux:text>{{ $company->offers->count() }} offre(s) publiée(s)</flux:text>
        </div>
        <flux:button icon="pencil-square" :href="route('entreprises.edit', $company)">Modifier</flux:button>
    </div>

    {{-- Relation hasMany : $company->offers --}}
    <div class="grid gap-4 md:grid-cols-2">
        @forelse ($company->offers as $offer)
            <x-offre-card :offer="$offer">
                <flux:button size="sm" icon="eye" :href="route('offres.show', $offer)">Voir l'offre</flux:button>
            </x-offre-card>
        @empty
            <flux:text>Cette entreprise n'a pas encore d'offre.</flux:text>
        @endforelse
    </div>
@endsection
