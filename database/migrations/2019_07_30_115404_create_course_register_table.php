<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCourseRegisterTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('course_register', function(Blueprint $table)
		{
			$table->integer('rid', true);
			$table->integer('uid')->nullable();
			$table->integer('cid')->nullable()->comment('course id');
			$table->string('desc')->nullable();
			$table->integer('status')->nullable()->comment('1 pending 2 passed -1 canceled');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('course_register');
	}

}
