<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCoursesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('courses', function(Blueprint $table)
		{
			$table->integer('cid', true);
			$table->string('course_name')->nullable();
			$table->string('course_creator')->nullable();
			$table->string('course_logo', 50)->nullable();
			$table->text('course_desc', 65535)->nullable();
			$table->integer('course_type')->nullable()->comment('0无，1线上2线下');
			$table->string('course_color')->nullable();
			$table->string('course_suitable')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('courses');
	}

}
