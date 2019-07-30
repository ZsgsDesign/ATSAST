<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBugTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bug', function(Blueprint $table)
		{
			$table->integer('bid', true);
			$table->string('title')->nullable();
			$table->string('version')->nullable();
			$table->string('subversion')->nullable();
			$table->integer('uid')->nullable();
			$table->string('desc')->nullable();
			$table->integer('status')->nullable();
			$table->string('reply')->nullable();
			$table->dateTime('release_time');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('bug');
	}

}
