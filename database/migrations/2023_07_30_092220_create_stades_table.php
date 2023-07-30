<?php

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
        Schema::create('stades', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('stade_id');
            $table->string('nom', 250);
            $table->string('adresse',250);
            $table->string('ville', 250);
            $table->unsignedInteger('capacite');
            $table->string('surface',50)->nullable()->default('herbe');
            $table->string('image', 250)->nullable();
            $table->foreignIdFor(Equipe::class)->constrained()->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stades');
    }
};
