<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userr', function (Blueprint $table) {
            $table->increments('id_user');
            $table->string('nama_user', 100);
            $table->enum('role', ['admin', 'kepala_divisi', 'user']);
            $table->unsignedInteger('id_divisi')->nullable(); // Foreign key harus INT UNSIGNED
            $table->string('email', 100)->unique();
            $table->string('password', 255);
            $table->timestamps();
        
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
        Schema::dropIfExists('userr');
    }
}
