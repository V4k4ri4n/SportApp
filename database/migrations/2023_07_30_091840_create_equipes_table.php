<?php

use App\Models\Pays;
use App\Models\Ligue;
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
        Schema::create('equipes', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('api_equipe_id');
            $table->string('nom',250);
            $table->char('code', 3)->nullable();
            $table->string('pays',150);
            $table->string('fondation',4)->nullable();
            $table->boolean('national')->default(false);
            $table->string('logo',250)->nullable();
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
        Schema::dropIfExists('equipes');
    }
};
