<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContestRequireInfoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contest_require_info', function(Blueprint $table)
		{
			$table->integer('Id', true);
			$table->string('name')->nullable()->unique('name');
			$table->string('type')->nullable();
			$table->string('placeholder')->nullable();
			$table->string('help')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contest_require_info');
	}

}
