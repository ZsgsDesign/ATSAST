<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContestDetailTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contest_detail', function(Blueprint $table)
		{
			$table->integer('cdid', true);
			$table->integer('contest_id')->nullable();
			$table->integer('type')->nullable();
			$table->text('content', 65535)->nullable();
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
		Schema::drop('contest_detail');
	}

}
