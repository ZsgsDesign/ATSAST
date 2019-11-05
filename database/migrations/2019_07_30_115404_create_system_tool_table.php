<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSystemToolTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('system_tool', function(Blueprint $table)
		{
			$table->integer('stid', true);
			$table->string('icon')->nullable();
			$table->string('url')->nullable();
			$table->string('name')->nullable();
			$table->string('desc')->nullable();
			$table->string('version')->nullable();
			$table->boolean('status')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('system_tool');
	}

}
