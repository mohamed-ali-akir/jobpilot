@php
    // Message du middleware role (en français) ; celui des Policies est en anglais par défaut, on le remplace
    $message = $exception->getMessage();
    if ($message === '' || $message === 'This action is unauthorized.') {
        $message = "Vous n'avez pas les droits nécessaires pour cette action.";
    }
@endphp

<x-layouts::auth title="Accès refusé">
    <div class="flex flex-col items-center gap-4 text-center">
        <flux:heading size="xl">Accès refusé</flux:heading>
        <flux:text>{{ $message }}</flux:text>
        <flux:button variant="primary" :href="route('offres.index')">Retour aux offres</flux:button>
    </div>
</x-layouts::auth>
