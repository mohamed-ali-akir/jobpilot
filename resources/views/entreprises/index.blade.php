@extends('layouts.app')

@section('title', 'Entreprises')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <flux:heading size="xl" level="1">Entreprises</flux:heading>
        <flux:button variant="primary" icon="plus" :href="route('entreprises.create')">Ajouter une entreprise</flux:button>
    </div>

    <flux:table>
        <flux:table.columns>
            <flux:table.column>Nom</flux:table.column>
            <flux:table.column>Offres</flux:table.column>
            <flux:table.column align="end">Actions</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @forelse ($companies as $company)
                <flux:table.row>
                    <flux:table.cell>
                        <a href="{{ route('entreprises.show', $company) }}" class="font-medium hover:underline">{{ $company->nom }}</a>
                    </flux:table.cell>
                    <flux:table.cell>{{ $company->offers_count }}</flux:table.cell>
                    <flux:table.cell align="end">
                        <div class="flex justify-end gap-2">
                            <flux:button size="sm" icon="pencil-square" :href="route('entreprises.edit', $company)">Modifier</flux:button>
                            <form action="{{ route('entreprises.destroy', $company) }}" method="POST"
                                  onsubmit="return confirm('Confirmer la suppression de cette entreprise ?')">
                                @csrf
                                @method('DELETE')
                                <flux:button size="sm" variant="danger" icon="trash" type="submit">Supprimer</flux:button>
                            </form>
                        </div>
                    </flux:table.cell>
                </flux:table.row>
            @empty
                <flux:table.row>
                    <flux:table.cell colspan="3">Aucune entreprise pour le moment.</flux:table.cell>
                </flux:table.row>
            @endforelse
        </flux:table.rows>
    </flux:table>
@endsection
