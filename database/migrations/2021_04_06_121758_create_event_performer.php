<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventPerformer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_performer', function (Blueprint $table) {
            $table->foreignId('event_id')->constrained('events');
            $table->foreignId('performer_id')->constrained('performers');
            $table->primary(['event_id', 'performer_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_performer');
    }
}
