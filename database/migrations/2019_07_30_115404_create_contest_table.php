<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContestTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contest', function(Blueprint $table)
		{
			$table->integer('contest_id', true);
			$table->string('name')->nullable();
			$table->string('creator')->nullable();
			$table->text('desc', 65535)->nullable();
			$table->boolean('type')->nullable();
			$table->date('start_date')->nullable();
			$table->date('end_date')->nullable();
			$table->boolean('status')->nullable();
			$table->dateTime('due_register')->nullable();
			$table->string('image')->nullable();
			$table->text('require_register', 65535)->nullable();
			$table->integer('default_register_status')->nullable();
			$table->integer('min_participants');
			$table->integer('max_participants');
			$table->string('tips');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contest');
	}

}
