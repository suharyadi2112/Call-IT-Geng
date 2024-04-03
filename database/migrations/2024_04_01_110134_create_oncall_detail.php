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
        Schema::create('a_oncall_detail', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('id_users')->nullable();
            $table->date('tanggal_oncall')->comment('tanggal kapan jadwwal oncall diberikan');
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
        Schema::dropIfExists('a_oncall_detail');
    }
};
