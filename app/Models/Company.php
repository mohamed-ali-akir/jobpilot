<?php

namespace App\Models;

use Database\Factories\CompanyFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    /** @use HasFactory<CompanyFactory> */
    use HasFactory;

    protected $fillable = [
        'nom',
    ];

    /**
     * Une entreprise publie plusieurs offres (relation 1-n).
     */
    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class);
    }
}
