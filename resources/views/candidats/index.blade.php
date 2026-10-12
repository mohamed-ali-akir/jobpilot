@extends('layouts.app')

@section('title', 'Candidats')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <flux:heading size="xl" level="1">Candidats</flux:heading>
        <flux:button variant="primary" icon="plus" :href="route('candidats.create')">Ajouter un candidat</flux:button>
    </div>

    <flux:table>
        <flux:table.columns>
            <flux:table.column>Nom</flux:table.column>
            <flux:table.column>Candidatures</flux:table.column>
            <flux:table.column align="end">Actions</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @forelse ($candidats as $candidat)
                <flux:table.row>
                    <flux:table.cell>
                        <a href="{{ route('candidats.show', $candidat) }}" class="font-medium hover:underline">{{ $candidat->full_name }}</a>
                    </flux:table.cell>
                    <flux:table.cell>{{ $candidat->offers_count }}</flux:table.cell>
                    <flux:table.cell align="end">
                        <div class="flex justify-end gap-2">
                            <flux:button size="sm" icon="pencil-square" :href="route('candidats.edit', $candidat)">Modifier</flux:button>
                            <form action="{{ route('candidats.destroy', $candidat) }}" method="POST"
                                  onsubmit="return confirm('Confirmer la suppression de ce candidat ?')">
                                @csrf
                                @method('DELETE')
                                <flux:button size="sm" variant="danger" icon="trash" type="submit">Supprimer</flux:button>
                            </form>
                        </div>
                    </flux:table.cell>
                </flux:table.row>
            @empty
                <flux:table.row>
                    <flux:table.cell colspan="3">Aucun candidat pour le moment.</flux:table.cell>
                </flux:table.row>
            @endforelse
        </flux:table.rows>
    </flux:table>
@endsection
