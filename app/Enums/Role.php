<?php

namespace App\Enums;

enum Role: string
{
    case Visiteur = 'visiteur';
    case Editeur = 'editeur';
    case Admin = 'admin';

    // Libellé lisible pour l'affichage
    public function label(): string
    {
        return match ($this) {
            self::Visiteur => 'Visiteur',
            self::Editeur => 'Éditeur',
            self::Admin => 'Administrateur',
        };
    }
}
