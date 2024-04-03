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
        Schema::create('a_oncall_schedule', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('nama_oncall')->comment('nama siapa yang oncall');
            $table->text('handphone_oncall');
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
        Schema::dropIfExists('a_oncall_schedule');
    }
};
