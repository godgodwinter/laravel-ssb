<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKriteriadetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kriteriadetail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama');
            $table->string('kriteria_id');
            $table->string('bobot')->nullable();
            $table->string('kode')->nullable();
            $table->string('tipe')->nullable();
            $table->string('ket')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('kriteriadetail');
    }
}
