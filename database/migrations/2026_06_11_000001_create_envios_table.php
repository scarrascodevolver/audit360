<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('envios', function (Blueprint $table) {
            $table->id();
            $table->string('comunidad', 150)->nullable();
            $table->string('telefono', 20);
            $table->string('email', 150);
            $table->string('estado', 20)->default('nuevo');
            $table->timestamp('consentimiento_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('envios');
    }
};
