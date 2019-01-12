<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateSwitchboardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('switchboard', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('agent_id');
            $table->integer('customer_id');
            $table->integer('incoming_call');// 1 - true 0 - false
            $table->timestamp('time_call_received')->nullable();
            $table->timestamp('time_call_answered')->nullable();
            $table->timestamp('time_call_disconnected');
            $table->string('standby_time')->nullable(); // amount of time between received to answered
            $table->string('call_time') ->nullable();// amount of time between answered to disconnected
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
        Schema::dropIfExists('switchboard');
    }
}
