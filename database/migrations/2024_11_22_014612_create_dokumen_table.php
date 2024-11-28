<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDokumenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dokumen', function (Blueprint $table) {
            $table->increments('id_dokumen');
            $table->string('nama_dok', 100);
            $table->date('tanggal');
            $table->string('lokasi_dok', 255);
            $table->unsignedInteger('id_realisasi')->nullable(); // Disesuaikan dengan realisasi
            $table->unsignedInteger('id_anggaran')->nullable(); // Disesuaikan dengan anggaran
            $table->timestamps();
        
            $table->foreign('id_realisasi')->references('id_realisasi')->on('realisasi');
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
        Schema::dropIfExists('dokumen');
    }
}
