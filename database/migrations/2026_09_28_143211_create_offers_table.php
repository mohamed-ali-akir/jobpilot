<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            // Convention Laravel : <modele>_id -> company_id référence companies.id
            $table->foreignId('company_id')->constrained()->restrictOnDelete();
            $table->string('type_contrat'); // CDI, CDD, Alternance, Stage, Intérim
            $table->date('date_debut');
            $table->integer('salaire');
            $table->string('address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
