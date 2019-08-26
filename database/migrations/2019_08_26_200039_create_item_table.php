<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item', function (Blueprint $table) {
            $table->integer('iid', true);
            $table->integer('scode')->nullable();
			$table->string('name')->nullable();
            $table->integer('count')->nullable();
            $table->integer('owner')->nullable();
            $table->string('dec')->nullable();
            $table->dateTime('create_time')->nullable();
            $table->string('pic')->nullable();
            $table->string('location')->nullable();
            $table->integer('order_count')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item');
    }
}
