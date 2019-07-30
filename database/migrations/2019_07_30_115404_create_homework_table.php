<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHomeworkTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('homework', function(Blueprint $table)
		{
			$table->integer('hid', true);
			$table->integer('cid')->nullable();
			$table->integer('syid')->nullable();
			$table->text('homework_content', 65535)->nullable();
			$table->string('support_lang')->nullable();
			$table->dateTime('due_submit')->nullable();
			$table->integer('type')->nullable()->comment('0描述，1代码，2纯文本，3markdown，4文件');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('homework');
	}

}
