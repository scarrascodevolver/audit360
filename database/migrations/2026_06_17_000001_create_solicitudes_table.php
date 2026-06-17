<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id();
            // El cliente deja al menos uno de los dos (lo valida el FormRequest).
            $table->string('telefono', 20)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('estado', 20)->default('nueva');
            $table->timestamp('consentimiento_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solicitudes');
    }
};
