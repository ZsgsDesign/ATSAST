<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePrivilegeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('privilege', function(Blueprint $table)
		{
			$table->integer('pid', true);
			$table->integer('uid')->nullable();
			$table->string('type')->nullable();
			$table->integer('type_value')->nullable();
			$table->integer('clearance')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('privilege');
	}

}
