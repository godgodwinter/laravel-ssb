<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemainTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemain', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama');
            $table->string('jk')->nullable();
            $table->string('alamat')->nullable();
            $table->string('telp')->nullable();
            $table->string('tgllahir')->nullable();
            $table->string('tgldaftar')->nullable();
            $table->string('photo')->nullable();
            $table->string('ket')->nullable();
            $table->string('users_id')->nullable();
            $table->string('tahunpenilaian_id')->nullable();
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
        Schema::dropIfExists('pemain');
    }
}
