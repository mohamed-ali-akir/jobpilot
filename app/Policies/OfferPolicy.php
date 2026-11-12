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

    // Postuler : être candidat et ne pas avoir déjà postulé à cette offre
    public function apply(User $user, Offer $offer): bool
    {
        return $user->isCandidat() && ! $user->aPostule($offer);
    }

    // Retirer sa candidature : être candidat et avoir postulé à cette offre
    public function withdraw(User $user, Offer $offer): bool
    {
        return $user->isCandidat() && $user->aPostule($offer);
    }
}
