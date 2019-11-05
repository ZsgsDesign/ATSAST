<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCourseDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('course_details', function(Blueprint $table)
		{
			$table->integer('cdid', true);
			$table->integer('cid')->nullable();
			$table->string('icon')->nullable();
			$table->string('item_name')->nullable();
			$table->string('item_value')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('course_details');
	}

}
