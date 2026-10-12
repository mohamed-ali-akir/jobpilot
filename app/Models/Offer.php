<?php

namespace App\Models;

use Database\Factories\OfferFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Offer extends Model
{
    /** @use HasFactory<OfferFactory> */
    use HasFactory;

    /**
     * Types de contrat proposés dans les formulaires.
     */
    public const TYPES_CONTRAT = ['CDI', 'CDD', 'Alternance', 'Stage', 'Intérim'];

    protected $fillable = [
        'name',
        'company_id',
        'type_contrat',
        'date_debut',
        'salaire',
        'address',
    ];

    protected function casts(): array
    {
        return [
            'date_debut' => 'date',
        ];
    }

    /**
     * Une offre appartient à une entreprise (inverse du hasMany).
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Les candidats ayant postulé à cette offre (relation n-n).
     */
    public function candidats(): BelongsToMany
    {
        return $this->belongsToMany(Candidat::class)->withTimestamps();
    }
}
