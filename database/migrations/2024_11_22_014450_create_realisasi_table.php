<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRealisasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('realisasi', function (Blueprint $table) {
            $table->increments('id_realisasi');
            $table->string('nama', 100);
            $table->decimal('jumlah_realisasi', 15, 2);
            $table->unsignedInteger('id_anggaran')->nullable(); // Disesuaikan dengan anggaran
            $table->timestamps();
        
            $table->foreign('id_anggaran')->references('id_anggaran')->on('anggaran');
        });
        

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('realisasi');
    }
}
