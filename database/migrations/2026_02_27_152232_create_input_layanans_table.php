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
        Schema::create('input_layanans', function (Blueprint $table) {
            $table->id();

            $table->date('tanggal');

            $table->foreignId('jenis_layanan_id')
                  ->constrained('jenis_layanans')
                  ->onDelete('cascade');

            $table->foreignId('instansi_id')
                  ->constrained('instansis')
                  ->onDelete('cascade');

            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->integer('jumlah_layanan');
            $table->integer('jumlah_kunjungan');

            $table->enum('status', ['pending','disetujui','ditolak'])
                  ->default('pending');

            $table->text('alasan_penolakan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('input_layanans');
    }
};
