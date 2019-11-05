<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContestRegisterTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contest_register', function(Blueprint $table)
		{
			$table->integer('Id', true);
			$table->integer('uid')->nullable()->index('uid');
			$table->integer('contest_id')->nullable();
			$table->text('info')->nullable();
			$table->boolean('status')->nullable();
			$table->dateTime('register_time')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contest_register');
	}

}
