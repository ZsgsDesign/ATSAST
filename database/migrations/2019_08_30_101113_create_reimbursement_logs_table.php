<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReimbursementLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reimbursement_logs', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('reimbursement_id');
            $table->integer('user_id');
            $table->tinyInteger('opr_type');           //操作类型 0审批 1修改 2管理员编辑 3挂起 4接触挂起
            $table->tinyInteger('before_status');      //操作前状态 0等待审批 1已经通过 2被驳回 3被挂起
            $table->string('remarks')->nullable();     //备注
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
        Schema::dropIfExists('reimbursement_log');
    }
}
