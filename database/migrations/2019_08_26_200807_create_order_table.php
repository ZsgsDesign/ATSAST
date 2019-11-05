<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->integer('oid', true);
            $table->integer('scode')->nullable();
            $table->integer('item_id')->nullable();
            $table->dateTime('create_time')->nullable();
            $table->integer('renter_id')->nullable();
            $table->integer('count')->nullable();
            $table->dateTime('rent_time')->nullable();
            $table->dateTime('return_time')->nullable();
            $table->integer('renter_checked')->nullable();
            $table->integer('owner_checked')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order');
    }
}
