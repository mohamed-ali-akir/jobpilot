@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <flux:heading size="xl" level="1" class="mb-6">Tableau de bord JobPilot</flux:heading>

    <div class="mb-8 grid gap-4 md:grid-cols-3">
        @foreach ($stats as $stat)
            <a href="{{ route($stat['route']) }}">
                <flux:card class="flex items-center gap-4 hover:bg-zinc-50 dark:hover:bg-zinc-700">
                    <flux:icon :icon="$stat['icon']" class="size-8 text-zinc-500" />
                    <div>
                        <div class="text-2xl font-semibold">{{ $stat['count'] }}</div>
                        <flux:text>{{ $stat['label'] }}</flux:text>
                    </div>
                </flux:card>
            </a>
        @endforeach
    </div>

    <flux:heading size="lg" class="mb-3">Dernières offres</flux:heading>
    <div class="grid gap-4 md:grid-cols-2">
        @forelse ($latestOffers as $offer)
            <x-offre-card :offer="$offer" />
        @empty
            <flux:text>Aucune offre pour le moment.</flux:text>
        @endforelse
    </div>
@endsection
