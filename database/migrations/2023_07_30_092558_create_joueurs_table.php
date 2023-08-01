<?php

use App\Models\Pays;
use App\Models\Ligue;
use App\Models\Equipe;
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
        Schema::create('joueurs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('api_joueur_id');
            $table->string('nom_complet',250);
            $table->string('prenom',250);
            $table->string('nom',250);
            $table->unsignedInteger('age')->nullable();
            $table->date('date_naissance')->nullable();
            $table->string('ville_naissance',70)->nullable();
            $table->string('pays_naissance',70)->nullable();
            $table->string('nationalite',70);
            $table->string('taille',15)->nullable();
            $table->string('poids',15)->nullable();
            $table->boolean('blesse')->default('false');
            $table->string("photo",250)->nullable();
            $table->foreignIdFor(Equipe::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Ligue::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Pays::class)->constrained()->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('joueurs');
    }
};
