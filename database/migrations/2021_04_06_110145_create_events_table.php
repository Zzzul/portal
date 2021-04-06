<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->constrained('categories');
            $table->unsignedBigInteger('user_id')->constrained('users')->comment = 'Penyelenggara';
            $table->dateTime('mulai');
            $table->dateTime('selesai');
            $table->string('lokasi', 50);
            $table->integer('harga');
            $table->integer('max_peserta');
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
        Schema::dropIfExists('events');
    }
}
