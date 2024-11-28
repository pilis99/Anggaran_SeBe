<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnggaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anggaran', function (Blueprint $table) {
            $table->increments('id_anggaran');
            $table->string('nama_anggaran', 100);
            $table->enum('tipe_anggaran', ['Penerimaan', 'Pengeluaran']);
            $table->date('tanggal');
            $table->decimal('jumlah', 15, 2);
            $table->unsignedInteger('id_rekening')->nullable(); // Disesuaikan dengan rekening
            $table->unsignedInteger('id_divisi')->nullable(); // Disesuaikan dengan divisi
            $table->timestamps();
        
            $table->foreign('id_rekening')->references('id_rekening')->on('rekening');
            $table->foreign('id_divisi')->references('id_divisi')->on('divisi');
        });
        

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anggaran');
    }
}
