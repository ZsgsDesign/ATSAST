<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSyllabusFeedbackTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('syllabus_feedback', function(Blueprint $table)
		{
			$table->integer('cfid', true);
			$table->integer('cid')->nullable();
			$table->integer('syid')->nullable();
			$table->integer('uid')->nullable();
			$table->integer('rank')->nullable();
			$table->text('desc', 65535)->nullable();
			$table->dateTime('feedback_time')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('syllabus_feedback');
	}

}
