<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Offer;


class company extends Model
{
    /** @use HasFactory<\Database\Factories\companyFactory> */
    use HasFactory;

    public function offers(){
        return $this->hasMany(Offer::class);
    }

    protected $fillable = [
        'nom',
    ];
    
}
