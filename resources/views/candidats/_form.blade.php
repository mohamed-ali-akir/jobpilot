{{-- Champs communs aux formulaires create et edit ($candidat est null en création) --}}
@php($selected = old('offers', $candidat?->offers->pluck('id')->all() ?? []))

<div class="grid gap-5 sm:grid-cols-2">
    <flux:input name="firstname" label="Prénom" :value="old('firstname', $candidat?->firstname)" required />
    <flux:input name="lastname" label="Nom" :value="old('lastname', $candidat?->lastname)" required />
</div>

{{-- Relation many-to-many : cases à cocher enregistrées dans la table pivot candidat_offer --}}
<fieldset class="flex flex-col gap-2">
    <legend class="mb-2 text-sm font-medium">Offres auxquelles le candidat postule</legend>
    @forelse ($offers as $offer)
        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="offers[]" value="{{ $offer->id }}" class="size-4 rounded"
                   @checked(in_array($offer->id, $selected))>
            {{ $offer->name }} — {{ $offer->company->nom }} ({{ $offer->type_contrat }}, {{ $offer->address }})
        </label>
    @empty
        <flux:text size="sm">Aucune offre disponible.</flux:text>
    @endforelse
    @error('offers.*')
        <flux:text size="sm" class="text-red-600">{{ $message }}</flux:text>
    @enderror
</fieldset>
