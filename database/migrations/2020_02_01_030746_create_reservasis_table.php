<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservasis', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('meja_id')->index('meja_id_foreign');
            $table->integer('harga_id')->index('harga_id_foreign');
            $table->integer('user_id')->index('user_id_foreign');
            $table->date('tanggal_booking');
            $table->enum('status', array('selesai', 'batal', 'reservasi'));

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
        Schema::dropIfExists('reservasis');
    }
}