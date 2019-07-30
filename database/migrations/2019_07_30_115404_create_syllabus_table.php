<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSyllabusTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('syllabus', function(Blueprint $table)
		{
			$table->integer('syid', true);
			$table->integer('cid')->nullable();
			$table->string('title')->nullable();
			$table->string('time')->nullable();
			$table->string('location')->nullable();
			$table->string('desc')->nullable();
			$table->string('signed', 6)->nullable();
			$table->boolean('script');
			$table->boolean('homework');
			$table->boolean('feedback');
			$table->string('video');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('syllabus');
	}

}
