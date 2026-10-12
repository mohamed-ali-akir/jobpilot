<flux:card class="flex flex-col gap-3">
    <div class="flex items-start justify-between gap-3">
        <div>
            <flux:heading size="lg">
                <a href="{{ route('offres.show', $offer) }}" class="hover:underline">{{ $offer->name }}</a>
            </flux:heading>
            <flux:text>{{ $offer->company->nom }}</flux:text>
        </div>

        {{-- Badge dynamique selon le type de contrat --}}
        <flux:badge :color="$badgeColor()" :icon="$badgeIcon()" size="sm">
            {{ $offer->type_contrat }}
        </flux:badge>
    </div>

    <div class="flex flex-wrap gap-x-5 gap-y-1 text-sm text-zinc-600 dark:text-zinc-300">
        <span class="flex items-center gap-1"><flux:icon.map-pin variant="micro" /> {{ $offer->address }}</span>
        <span class="flex items-center gap-1"><flux:icon.calendar variant="micro" /> Début le {{ $offer->date_debut->format('d/m/Y') }}</span>
        <span class="flex items-center gap-1"><flux:icon.banknotes variant="micro" /> {{ number_format($offer->salaire, 0, ',', ' ') }} € / mois</span>
    </div>

    {{-- Slot dynamique (bonus séance 2) : chaque page choisit ses boutons d'action --}}
    @if ($slot->isNotEmpty())
        <div class="flex flex-wrap items-center gap-2 border-t border-zinc-200 pt-3 dark:border-zinc-700">
            {{ $slot }}
        </div>
    @endif
</flux:card>
