<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMejasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mejas', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('no_meja', 5);
            $table->enum('kursi', array(2, 4, 6, 8, 10));
            $table->enum('posisi', array('in', 'out'));
            $table->enum('status', array('ada', 'kosong'));

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
        Schema::dropIfExists('mejas');
    }
}