{{-- Champs communs aux formulaires create et edit ($offer est null en création) --}}
<flux:input name="name" label="Titre du poste" :value="old('name', $offer?->name)" required />

<flux:select name="company_id" label="Entreprise" placeholder="Choisir une entreprise..." required>
    @foreach ($companies as $company)
        <flux:select.option :value="$company->id" :selected="old('company_id', $offer?->company_id) == $company->id">
            {{ $company->nom }}
        </flux:select.option>
    @endforeach
</flux:select>

<flux:select name="type_contrat" label="Type de contrat" placeholder="Choisir un type..." required>
    @foreach ($typesContrat as $type)
        <flux:select.option :value="$type" :selected="old('type_contrat', $offer?->type_contrat) === $type">
            {{ $type }}
        </flux:select.option>
    @endforeach
</flux:select>

<flux:input name="date_debut" type="date" label="Date de début" :value="old('date_debut', $offer?->date_debut?->format('Y-m-d'))" required />

<flux:input name="salaire" type="number" min="0" label="Salaire mensuel (€)" :value="old('salaire', $offer?->salaire)" required />

<flux:input name="address" label="Localisation" placeholder="Ex : Lyon" :value="old('address', $offer?->address)" required />
