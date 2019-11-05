<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name')->nullable();
			$table->string('real_name')->nullable();
			$table->string('avatar')->nullable();
			$table->integer('gender')->nullable()->default(0);
			$table->string('title')->nullable();
			$table->string('email')->nullable();
			$table->string('password')->nullable();
			$table->string('OPENID')->nullable();
			$table->string('SID')->nullable();
			$table->boolean('verify_status')->nullable()->default(0);
			$table->string('album');
			$table->integer('cloud_size');
			$table->integer('clearance')->nullable()->default(0);
			$table->dateTime('rtime')->nullable();
			$table->string('ip')->nullable();
			$table->boolean('insecure')->nullable();
			$table->string('cur_version');
			$table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
