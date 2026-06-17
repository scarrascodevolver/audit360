<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // En el flujo nuevo el cliente se identifica con teléfono O email
        // (al menos uno; lo valida el FormRequest), así que ambos son opcionales.
        Schema::table('envios', function (Blueprint $table) {
            $table->string('telefono', 20)->nullable()->change();
            $table->string('email', 150)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('envios', function (Blueprint $table) {
            $table->string('telefono', 20)->nullable(false)->change();
            $table->string('email', 150)->nullable(false)->change();
        });
    }
};
