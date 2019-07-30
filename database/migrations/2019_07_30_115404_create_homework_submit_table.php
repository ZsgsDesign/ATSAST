<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHomeworkSubmitTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('homework_submit', function(Blueprint $table)
		{
			$table->integer('hsid', true);
			$table->integer('hid');
			$table->integer('cid')->nullable();
			$table->integer('syid')->nullable();
			$table->integer('uid')->nullable();
			$table->text('submit_content')->nullable();
			$table->dateTime('submit_time')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('homework_submit');
	}

}
