@extends('layouts.app')

@section('title', 'Mes candidatures')

@section('content')
    <flux:heading size="xl" level="1" class="mb-6">Mes candidatures</flux:heading>

    <flux:table>
        <flux:table.columns>
            <flux:table.column>Offre</flux:table.column>
            <flux:table.column>Entreprise</flux:table.column>
            <flux:table.column>Envoyée le</flux:table.column>
            <flux:table.column align="end">Actions</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @forelse ($offers as $offer)
                <flux:table.row>
                    <flux:table.cell>
                        <a href="{{ route('offres.show', $offer) }}" class="font-medium hover:underline">{{ $offer->name }}</a>
                    </flux:table.cell>
                    <flux:table.cell>{{ $offer->company->name }}</flux:table.cell>
                    <flux:table.cell>{{ $offer->pivot->created_at->format('d/m/Y') }}</flux:table.cell>
                    <flux:table.cell align="end">
                        <form action="{{ route('candidatures.destroy', $offer) }}" method="POST"
                              onsubmit="return confirm('Retirer cette candidature ?')">
                            @csrf
                            @method('DELETE')
                            <flux:button size="sm" variant="danger" icon="x-mark" type="submit">Retirer</flux:button>
                        </form>
                    </flux:table.cell>
                </flux:table.row>
            @empty
                <flux:table.row>
                    <flux:table.cell colspan="4">Tu n'as encore postulé à aucune offre.</flux:table.cell>
                </flux:table.row>
            @endforelse
        </flux:table.rows>
    </flux:table>
@endsection