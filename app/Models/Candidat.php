<?php

namespace App\Models;

use Database\Factories\CandidatFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Candidat extends Model
{
    /** @use HasFactory<CandidatFactory> */
    use HasFactory;

    protected $fillable = [
        'firstname',
        'lastname',
    ];

    /**
     * Les offres auxquelles le candidat a postulé (relation n-n via la table candidat_offer).
     */
    public function offers(): BelongsToMany
    {
        return $this->belongsToMany(Offer::class)->withTimestamps();
    }

    /**
     * Nom complet, pratique pour l'affichage : $candidat->full_name
     */
    public function getFullNameAttribute(): string
    {
        return $this->firstname.' '.$this->lastname;
    }
}
