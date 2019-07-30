<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSyllabusSignTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('syllabus_sign', function(Blueprint $table)
		{
			$table->integer('signid', true);
			$table->integer('cid');
			$table->integer('syid')->nullable();
			$table->integer('uid')->nullable();
			$table->dateTime('stime')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('syllabus_sign');
	}

}
