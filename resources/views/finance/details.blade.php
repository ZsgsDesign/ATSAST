@extends('layouts.app')

@section('template')
<style>
    .paper-card {
        display: block;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 30px;
        border-radius: 4px;
        transition: .2s ease-out .0s;
        color: #7a8e97;
        background: #fff;
        padding: 1rem;
        position: relative;
        border: 1px solid rgba(0, 0, 0, 0.15);
        margin-bottom: 2rem;
    }

    .floating{
        top: 1rem!important;
        left: 0!important;
        font-size: 0.75rem!important;
    }

    .material i {
        font-size: 7.5rem;
    }

    .alert i.MDI {
        font-size: 1.025rem;
        margin-right: 0.75rem;
    }
</style>
<div class="container mundb-standard-container">
    <div class="paper-card">
        <p>报销 - 查看</p>
        <input type="hidden" name="id" id="r_id" value="{{$id}}">
        @if($status == 0)
        <div class="alert alert-info" role="alert">
            <i class="MDI clock"></i>该报销项目等待审批中
        </div>
        @elseif($status == 1)
        <div class="alert alert-danger" role="alert">
            <i class="MDI alert-circle-outline"></i>该报销项目被驳回，请进行修改以再次审批
        </div>
        @elseif($status == 3)
        <div class="alert alert-success" role="alert">
            <i class="MDI check"></i>该报销项目已通过
        </div>
        @else
        <div class="alert alert-warning" role="alert">
            <i class="MDI information-outline"></i>该报销项目被冻结
        </div>
        @endif
        <div class="text-right">
            @if($is_approver && $status == 0)
            <button id="approval" type="button" class="btn btn-primary">审批</button>
            @endif
            @if($is_admin && in_array($status,[0,1]))
            <button id="hang" type="button" class="btn btn-danger">挂起</button>
            @endif
            @if($is_admin && $status == 2)
            <button id="unhang" type="button" class="btn btn-danger">解除挂起</button>
            @endif
        </div>
        <div class="btn btn-primary" style="display:block" data-target="#reim-logs" data-toggle="collapse" aria-expanded="false" aria-controls="my-collapse">
            <small>该项目总过经过 {{count($logs)}} 次状态更新,点击可查看/收起</small>
        </div>
        <div id="reim-logs" class="collapse table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>操作者</th>
                        <th>操作类别</th>
                        <th>操作前状态</th>
                        <th>操作时间</th>
                        <th>操作备注</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                    <tr>
                        <td>{{$log->username()}}</td>
                        <td>{{$opr_type[$log->opr_type] ?? '未知'}}</td>
                        <td>{{$status_parse[$log->before_status]}}</td>
                        <td>{{$log->created_at}}</td>
                        <td>{{$log->remarks}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="form-group">
            <label for="title" class="floating">报销项目</label>
            <input style="background-color:#0000" type="text" name="title" class="form-control" disabled="disabled" id="title" autocomplete="off" required>
        </div>
        <div class="form-group">
            <label for="content" class="floating">备注</label>
            <textarea style="background-color:#0000" name="content" class="form-control" disabled="disabled" id="content" rows="5" style="resize: none;" autocomplete="off" required></textarea>
        </div>
        <div class="form-group">
            <label for="money" class="floating">金额</label>
            <input style="background-color:#0000" type="text" name="money" class="form-control" disabled="disabled" id="money" autocomplete="new-password" required>
        </div>
        <div class="form-group">
            <label for="department" class="floating">部门与组织</label>
            <input style="background-color:#0000" type="text" name="department" class="form-control" disabled="disabled" id="department" autocomplete="new-password" required>
        </div>
        <div class="row material" style="margin-top: 3rem;">
            <div id="invoice" style="display: none" class="text-center col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <a class="btn btn-primary" href="" download="发票.pdf" role="button"><i class="MDI download"></i><br>点我下载发票文件</a>
            </div>
            <div id="invoice-null" style="display: none" class="text-center col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <p class="btn btn-primary"><i class="MDI refresh"></i><br>发票正在送往或已经送达指定地点</p>
            </div>
            <div id="transaction-voucher" style="display: none" class="text-center col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <img class="img-fluid" src="" class="img-fluid">
                交易凭证<br><small><a class="btn btn-danger" href="" target="_blank" role="button">点击可查看大图</a></small>
            </div>
            <div id="declaration" style="display: none" class="text-center col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <a class="btn btn-primary" href="" download="申报单.docx" role="button"><i class="MDI download"></i><br>点我下载申报单</a>
            </div>
        </div>
        <div class="text-right">
            <button id="cancel" type="button" class="btn btn-secondary" onclick="window.location='/finance'">返回</button>
            @if($is_admin && $status != 2 || $status == 0 || $status == 1)
            <button id="edit" type="button" class="btn btn-danger" onclick="window.location='/finance/edit/{{$id}}'">编辑</button>
            @endif
        </div>
    </div>
    @if(($is_approver || $is_admin) && $status == 0)
    <div id="approval-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-muted">报销审批</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-check text-center" style="padding: 0 2rem;">
                        <div class="radio" style="margin-bottom: 1rem">
                            <label class="form-check-label text-muted">
                                <input class="form-check-input" type="radio" name="result" id="result-1" value="1"  required> 批准
                            </label>
                        </div>
                        <div class="radio">
                            <label class="form-check-label text-danger">
                                <input class="form-check-input" type="radio" name="result" id="result-0" value="0"  required> 驳回
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="remarks">备注</label>
                            <textarea id="remarks" class="form-control" name="remarks" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <small class="text-danger"></small>
                    <button type="button" data-dismiss="modal" class="btn btn-secondary" >再仔细看看</button>
                    <button id="submit-approval" type="button" class="btn btn-danger">确认</button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
<script>
var ajaxing = false;
window.addEventListener("load",function() {
    var id = $('#r_id').val();
    ajaxing = true;
    $.ajax({
        url : '/ajax/finance/details',
        type : 'POST',
        data : {
            id : id
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success : function(result){
            ajaxing = false;
            if(result.ret == 200){
                result = result.data;
                $('#title').val(result['title']);
                $('#content').val(result['content']);
                $('#money').val(result['money']);
                $('#department').val(result['organization'] + ' ' + result['department']);
                if(result['invoice'] != null){
                    $('#invoice').show();
                    $('#invoice a').attr('href',result);
                }else{
                    $('#invoice-null').show();
                }
                if(result['transaction_voucher'] != null){
                    $('#transaction-voucher').show();
                    $('#transaction-voucher img').attr('src',result['transaction_voucher']);
                    $('#transaction-voucher a').attr('href',result['transaction_voucher']);
                }
                if(result['declaration'] != null){
                    $('#declaration').show();
                    $('#declaration a').attr('href',result['declaration']);
                }
                if(result['status'] != 1 && result['status'] != 0){
                    $('#edit').remove();
                }
            }else{
                window.location = '/finance';
            }

        }
    });

    @if(($is_approver || $is_admin) && $status == 0)
    $('#approval').on('click',() => {
        $('#approval-modal').modal();
    });

    $('#submit-approval').on('click',() => {
        if(ajaxing) return;
        var result = $('input[name="result"]:checked').val();
        if(result != 0 && result != 1){
            $('div.modal-footer small').text('请选择批准或是驳回').fadeIn(400);
            return;
        }
        var remarks = $('#remarks').val();
        if(remarks.length == 0){
            $('div.modal-footer small').text('请填写备注').fadeIn(400);
            return;
        }
        ajaxing = true;
        $.ajax({
            url : '/ajax/finance/approval',
            type : 'POST',
            data : {
                id : id,
                result : result,
                remarks : remarks
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success : function(result){
                ajaxing = false;
                if(result.ret == 200){
                    window.location.reload();
                }else{
                    $('div.modal-footer small').text(result.desc).fadeIn(400);
                }
            }
        });
    });
    @endif
});
</script>
@endsection
