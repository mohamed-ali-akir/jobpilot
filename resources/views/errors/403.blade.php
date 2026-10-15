<x-layouts::auth title="Accès refusé">
    <div class="flex flex-col items-center gap-4 text-center">
        <flux:heading size="xl">Accès refusé</flux:heading>
        <flux:text>Vous n'avez pas les droits nécessaires pour cette action.</flux:text>
        <flux:button variant="primary" :href="route('offres.index')">Retour aux offres</flux:button>
    </div>
</x-layouts::auth>