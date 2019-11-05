<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTempTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('temp', function(Blueprint $table)
		{
			$table->string('SID');
			$table->string('name')->nullable();
			$table->string('phone')->nullable();
			$table->string('qq')->nullable();
			$table->string('contact_email')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('temp');
	}

}
