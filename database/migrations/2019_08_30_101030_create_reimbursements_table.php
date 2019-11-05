<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReimbursementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reimbursements', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id');
            $table->integer('organization_id');                          //组织id
            $table->string('title');                                     //标题
            $table->string('content')->nullable();                       //内容
            $table->string('money');                                     //金额
            $table->tinyInteger('status');                               //状态 0等待审批 1被驳回 2被挂起 3已经通过
            $table->string('invoice');                                   //发票文件路径
            $table->string('transaction_voucher')->nullable();           //交易凭证
            $table->string('declaration')->nullable();                   //申报单
            $table->string('accepted_at')->nullable();                   //通过时间
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reimbursements');
    }
}
