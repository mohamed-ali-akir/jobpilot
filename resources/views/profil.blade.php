@extends('layouts.app')
@section('title', 'Mon profil')
@section('content')
    <flux:heading size="xl" level="1">{{ $user->name }}</flux:heading>
    <flux:badge class="mt-2">{{ $user->role->label() }}</flux:badge>
    <flux:card class="mt-6 flex max-w-xl flex-col gap-2">
        <div>E-mail : <strong>{{ $user->email }}</strong></div>
        <div>Membre depuis le : <strong>{{ $user->created_at->format('d/m/Y') }}</strong></div>
        <div>Offres publiées : <strong>{{ $user->offers_count }}</strong></div>
    </flux:card>
    <flux:button class="mt-4" icon="cog" :href="route('profile.edit')">Modifier mes informations</flux:button>
@endsection