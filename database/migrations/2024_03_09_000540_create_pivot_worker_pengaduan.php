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
        Schema::create('a_pivot_worker_pengaduan', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id');
            $table->uuid('pengaduan_id');
            $table->date('tanggal_assesment')->comment('tanggal kapan assesment diberikan');
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
        Schema::dropIfExists('a_pivot_worker_pengaduan');
    }
};
