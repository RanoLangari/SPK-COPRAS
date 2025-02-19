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
        Schema::create('alternatif', function (Blueprint $table) {
            $table->id();
            $table->string('nama_alternatif');
            $table->enum('kategori', ['Pinjaman Umum', 'Pinjaman Produktif', 'Pinjaman Konsumtif', 'Pinjaman lunak']);
            $table->timestamps();
            $table->string('periode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alternatif');
    }
};
