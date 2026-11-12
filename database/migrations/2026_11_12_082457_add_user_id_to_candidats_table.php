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
        Schema::table('candidats', function (Blueprint $table) {
            // nullable : les candidats saisis par un éditeur n'ont pas de compte
            // unique : un compte = une seule fiche candidat
            // cascadeOnDelete : supprimer le compte supprime la fiche et ses candidatures
            $table->foreignId('user_id')->nullable()->unique()->after('id')
                ->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidats', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropUnique(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
