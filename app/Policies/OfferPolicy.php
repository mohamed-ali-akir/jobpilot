<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\Offer;
use App\Models\User;

class OfferPolicy
{
    // Voir la liste : tout le monde, même un invité
    public function viewAny(?User $user): bool
    {
        return true;
    }

    // Voir le détail d'une offre : tout le monde
    public function view(?User $user, Offer $offer): bool
    {
        return true;
    }

    // Créer : éditeur ou admin
    public function create(User $user): bool
    {
        return $user->hasRole(Role::Editeur, Role::Admin);
    }

    // Modifier : l'admin modifie tout, l'éditeur seulement SES offres
    public function update(User $user, Offer $offer): bool
    {
        return $user->isAdmin()
            || ($user->isEditeur() && $offer->user()->is($user));
    }

    // Supprimer : admin uniquement
    public function delete(User $user, Offer $offer): bool
    {
        return $user->isAdmin();
    }
}
