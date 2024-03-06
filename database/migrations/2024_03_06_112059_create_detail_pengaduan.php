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
        Schema::create('a_detail_pengaduan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pengaduan_id');
            $table->text('picture_pre');
            $table->text('picture_post');
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
        Schema::dropIfExists('a_detail_pengaduan');
    }
};
