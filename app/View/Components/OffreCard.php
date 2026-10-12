<?php

namespace App\View\Components;

use App\Models\Offer;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Carte d'une offre d'emploi (généré avec : php artisan make:component OffreCard).
 *
 * Utilisation : <x-offre-card :offer="$offer"> ...boutons d'action (slot)... </x-offre-card>
 */
class OffreCard extends Component
{
    public function __construct(public Offer $offer)
    {
        //
    }

    /**
     * Couleur du badge selon le type de contrat.
     */
    public function badgeColor(): string
    {
        return match ($this->offer->type_contrat) {
            'CDI' => 'green',
            'CDD' => 'blue',
            'Alternance' => 'purple',
            'Stage' => 'amber',
            'Intérim' => 'orange',
            default => 'zinc',
        };
    }

    /**
     * Icône du badge selon le type de contrat.
     */
    public function badgeIcon(): string
    {
        return match ($this->offer->type_contrat) {
            'CDI' => 'shield-check',
            'CDD' => 'clock',
            'Alternance' => 'academic-cap',
            'Stage' => 'light-bulb',
            'Intérim' => 'arrow-path',
            default => 'briefcase',
        };
    }

    public function render(): View|Closure|string
    {
        return view('components.offre-card');
    }
}
