<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeStatusPembayaranToPaymentStatusAudienceEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audience_event', function (Blueprint $table) {
            $table->renameColumn('status_pembayaran', 'payment_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_status_audience_event', function (Blueprint $table) {
            //
        });
    }
}
