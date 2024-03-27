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
        Schema::create('a_indikator_mutu', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_indikator');
            $table->integer('target');
            $table->uuid('kategori_pengaduan_id');
            $table->string('n');
            $table->string('d');
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
        Schema::dropIfExists('a_indikator_mutu');
    }
};
