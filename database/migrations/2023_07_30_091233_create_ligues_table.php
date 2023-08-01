<?php

use App\Models\Pays;
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
        Schema::create('ligues', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('api_ligue_id');
            $table->string('nom',100);
            $table->string('type', 50)->nullable();
            $table->string('logo', 250)->nullable();
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
        Schema::dropIfExists('ligues');
    }
};
