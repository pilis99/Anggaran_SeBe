<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengajuanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengajuan', function (Blueprint $table) {
            $table->increments('id_pengajuan');
            $table->string('nama_pengajuan', 150);
            $table->decimal('jumlah', 15, 2);
            $table->date('tanggal');
            $table->unsignedInteger('id_divisi')->nullable(); // Disesuaikan dengan divisi
            $table->unsignedInteger('id_rekening')->nullable(); // Disesuaikan dengan rekening
            $table->unsignedInteger('id_anggaran')->nullable(); // Disesuaikan dengan anggaran
            $table->enum('status', ['Pending', 'Diterima', 'Ditolak']);
            $table->timestamps();
        
            $table->foreign('id_divisi')->references('id_divisi')->on('divisi');
            $table->foreign('id_rekening')->references('id_rekening')->on('rekening');
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
        Schema::dropIfExists('pengajuan');
    }
}
