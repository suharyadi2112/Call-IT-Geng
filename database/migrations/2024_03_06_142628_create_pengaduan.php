<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('a_pengaduan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('indikator_mutu_id');
            $table->uuid('pelapor_id');
            $table->uuid('kategori_pengaduan_id');
            
            $table->uuid('worker_id');
            $table->uuid('admin_id');

            $table->text('lokasi');
            $table->text('lantai');
            $table->text('judul_pengaduan');
            $table->text('dekskripsi_pelaporan');
            $table->text('prioritas');
            $table->text('nomor_handphone');
            $table->text('status_pelaporan');
            $table->date('tanggal_pelaporan')->nullable();
            $table->date('tanggal_selesai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('a_pengaduan');
    }
};
