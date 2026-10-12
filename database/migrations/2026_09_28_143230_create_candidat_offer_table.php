<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Table pivot de la relation many-to-many :
     * un candidat postule à plusieurs offres, une offre reçoit plusieurs candidatures.
     */
    public function up(): void
    {
        Schema::create('candidat_offer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidat_id')->constrained()->cascadeOnDelete();
            $table->foreignId('offer_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            // Un candidat ne peut postuler qu'une seule fois à la même offre
            $table->unique(['candidat_id', 'offer_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidat_offer');
    }
};
