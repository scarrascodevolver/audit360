<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contenidos', function (Blueprint $table) {
            // Nombre legible del texto, lo que ve el cliente en el panel.
            $table->string('etiqueta', 150)->nullable()->after('clave');
        });
    }

    public function down(): void
    {
        Schema::table('contenidos', function (Blueprint $table) {
            $table->dropColumn('etiqueta');
        });
    }
};
