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
            $table->text('kode_laporan');
            $table->uuid('indikator_mutu_id');
            $table->uuid('pelapor_id');
            $table->uuid('kategori_pengaduan_id');
            $table->uuid('admin_id')->nullable();

            $table->text('lokasi')->nullable();
            $table->text('lantai')->nullable();
            $table->text('judul_pengaduan')->nullable();
            $table->text('dekskripsi_pelaporan')->nullable();
            $table->text('prioritas')->nullable();
            $table->text('nomor_handphone')->nullable();
            $table->text('status_pelaporan')->nullable();
            $table->text('tanggal_pelaporan')->nullable();
            $table->text('tanggal_selesai')->nullable();
            $table->timestamps();
            
            $table->softDeletes(); // deleted_at
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
