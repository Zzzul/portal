<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAudienceEvent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audience_event', function (Blueprint $table) {
            $table->foreignId('event_id')->constrained('events');
            $table->foreignId('user_id')->constrained('users')->comment = 'Peserta';
            $table->integer('status_pembayaran')->default('0');
            $table->primary(['event_id', 'user_id']);
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
        Schema::dropIfExists('audience_event');
    }
}
