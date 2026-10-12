@extends('layouts.app')

@section('title', 'Modifier l\'entreprise')

@section('content')
    <div class="max-w-xl">
        <flux:button variant="ghost" icon="arrow-left" :href="route('entreprises.index')" class="mb-4">Retour à la liste</flux:button>

        <flux:heading size="xl" level="1" class="mb-6">Modifier « {{ $company->nom }} »</flux:heading>

        <form action="{{ route('entreprises.update', $company) }}" method="POST" class="flex flex-col gap-5">
            @csrf
            @method('PUT')
            <flux:input name="nom" label="Nom de l'entreprise" :value="old('nom', $company->nom)" required />

            <div class="flex gap-2">
                <flux:button variant="primary" type="submit">Enregistrer</flux:button>
                <flux:button :href="route('entreprises.index')">Annuler</flux:button>
            </div>
        </form>
    </div>
@endsection
