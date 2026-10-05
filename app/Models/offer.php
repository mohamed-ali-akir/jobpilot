<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\company;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class offer extends Model
{
    use HasFactory;

    public function company(){
        return $this->belongsTo(company::class, 'companies_id');
    }

    protected $fillable = [
        'name',
        'companies_id',
        'date_debut',
        'salaire',
        'address',
    ];
}
