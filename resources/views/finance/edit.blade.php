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
</style>
<div class="container mundb-standard-container">
    <div class="paper-card">
        <p>报销 - 编辑</p>
        <input type="hidden" name="id" id="r_id" value="{{$id}}">
        <div class="form-group">
            <label for="title" class="floating">报销项目</label>
            <input type="text" name="title" class="form-control" id="title" autocomplete="off" required>
        </div>
        <div class="form-group">
            <label for="content" class="floating">备注</label>
            <textarea name="content" class="form-control" id="content" rows="5" style="resize: none;" autocomplete="off" required></textarea>
            <small class="form-text text-muted">请尽可能详细的描述您需要报销的内容</small>
        </div>
        <div class="form-group">
            <label for="money" class="floating">金额</label>
            <input type="text" name="money" class="form-control" id="money" autocomplete="new-password" required>
            <small class="form-text text-muted">200元以内只需要支票，交易额大于200必须上传交易凭证，交易额大于500必须上传申报单，不支持1000元以上的报销</small>
        </div>
        <div class="form-group">
            <label for="department" class="floating">部门与组织</label>
            <input type="text" name="department" class="form-control" id="department" autocomplete="new-password" required>
            <small class="form-text text-muted">填写完整的组织和部门的名字并以空格分隔 eg. 校大学生科学与技术协会 软件研发中心</small>
        </div>
        <div class="row" style="margin-top: 3rem;">
            <div class="text-center col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label id="invoice_tip" class="btn btn-danger" for="invoice"><i class="MDI file-pdf-box"></i> 点这里上传发票</label>
                    <input type="file" class="form-control-file" name="invoice" accept="application/pdf" id="invoice" aria-describedby="invoiceHelp" style="display: none">
                    <small id="invoiceHelp" class="form-text text-muted"> 请上传完整的pdf发票文件，纸质支票请直接送到指定地点不需要上传文件。</small>
                </div>
            </div>
            <div class="text-center col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label id="transaction_voucher_tip" class="btn btn-danger" for="transaction_voucher"><i class="MDI image"></i> 点这里上传交易凭证</label>
                    <input type="file" class="form-control-file" name="transaction_voucher" accept="image/gif, image/jpeg"  id="transaction_voucher" aria-describedby="transaction_voucherHelp" style="display: none">
                    <img id="preview_transaction_voucher" class="img-fluid" src="" class="img-fluid hidden"><small id="preview_tag" class="form-text text-muted" style="display: none">预览</small><br>
                    <small id="transaction_voucherHelp" class="form-text text-muted"> 请上传清晰的jpg或png图片文件</small>
                </div>
            </div>
            <div class="text-center col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label id="declaration_tip" class="btn btn-danger" for="declaration"><i class="MDI file-word-box"></i> 点这里上传申报单</label>
                    <input type="file" class="form-control-file" name="declaration" accept="application/vnd.openxmlformats-officedocument.wordprocessingml.document" id="declaration" aria-describedby="declarationHelp" style="display: none">
                    <small id="declarationHelp" class="form-text text-muted"> 请上传docx文件</small>
                </div>
            </div>
        </div>
        <div class="text-right">
            <button id="cancel" type="button" class="btn btn-secondary" onclick="window.location='/finance/details/{{$id}}'">返回</button>
            <button id="submit" type="button" class="btn btn-primary">确认编辑</button>
        </div>
    </div>
</div>
<script>
window.addEventListener("load",function() {
    var id = $('#r_id').val();
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
            if(result.ret == 200){
                result = result.data;
                $('#title').val(result['title']);
                $('#content').val(result['content']);
                $('#money').val(result['money']);
                $('#department').val(result['organization'] + ' ' + result['department']);
                if(result['invoice'] != null){
                    $('#invoiceHelp').text('已上传');
                    $('#invoice_tip').removeClass('btn-danger').addClass('btn-success');
                }
                if(result['transaction_voucher'] != null){
                    $('#transaction_voucherHelp').text('已上传');
                    $('#transaction_voucher_tip').removeClass('btn-danger').addClass('btn-success');
                    $('#preview_transaction_voucher').attr('src',result['transaction_voucher']).slideDown();
                    $('#preview_tag').fadeIn();
                }
                if(result['declaration'] != null){
                    $('#declarationHelp').text('已上传');
                    $('#declaration_tip').removeClass('btn-danger').addClass('btn-success');
                }
            }else{
                window.location = '/finance';
            }
        }
    });

    $('#transaction_voucher').change(function() {
        var file = this.files[0];
        var filename = $('#transaction_voucher').val().split('\\').pop();
        var extension = filename.split('.').pop();
        if(extension != 'jpg' && extension != 'png' ){
            $('#transaction_voucherHelp').text('只允许上传jpg和png类型的图片文件!');
            $('#transaction_voucher_tip').removeClass('btn-success').addClass('btn-danger');
            $('#preview_transaction_voucher').fadeOut();
            $('#preview_tag').fadeOut();
        }else{
            $('#transaction_voucherHelp').text('已选择: '+filename);
            $('#transaction_voucher_tip').removeClass('btn-danger').addClass('btn-success');
            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => {
                $('#preview_transaction_voucher').attr('src',reader.result).slideDown();
                $('#preview_tag').fadeIn();
            }
        }

    });

    $('#declaration').change(function() {
        var filename = $('#declaration').val().split('\\').pop();
        var extension = filename.split('.').pop();
        if(extension != 'docx'){
            $('#declarationHelp').text('只允许上传docx类型的文件!');
            $('#declaration_tip').removeClass('btn-success').addClass('btn-danger');
        }else{
            $('#declarationHelp').text('已选择: '+filename);
            $('#declaration_tip').removeClass('btn-danger').addClass('btn-success');
        }
    });

    $('#invoice').change(function() {
        var filename = $('#invoice').val().split('\\').pop();
        var extension = filename.split('.').pop();
        if(extension != 'pdf'){
            $('#invoiceHelp').text('只允许上传pdf类型的文件!');
            $('#invoice_tip').removeClass('btn-success').addClass('btn-danger');
        }else{
            $('#invoiceHelp').text('已选择: '+filename);
            $('#invoice_tip').removeClass('btn-danger').addClass('btn-success');
        }
    });

    $('#submit').on('click',function(){
        var id = $('#r_id').val();
        var title = $('#title').val();
        var content = $('#content').val();
        var money = parseInt($('#money').val());
        var department = $('#department').val();
        var invoice = $('#invoice').get(0).files[0];
        var transaction_voucher = $('#transaction_voucher').get(0).files[0];
        var declaration = $('#declaration').get(0).files[0];

        if(title.length <= 0 || title.length >= 255) {
            alert('报销项目是必填字段且长度不应该超过255');
            return;
        }
        if(content.length <= 0 || content.length >= 255) {
            alert('备注是必填字段且长度不应该超过255');
            return;
        }
        if(isNaN(money) || money == 0) {
            alert('报销金额请填入合理的数字');
            return;
        }
        if(money >= 1000) {
            alert('不支持处理1000元及以上的交易');
            return;
        }
        if(department.split(' ').length != 2) {
            alert('请填入完整的组织和部门');
            return;
        }

        var data = new FormData();
        data.append('id',id);
        data.append('title',title);
        data.append('content',content);
        data.append('money',money);
        data.append('organization',department.split(' ')[0]);
        data.append('department',department.split(' ')[1]);
        if(invoice != undefined)              data.append('invoice',invoice);
        if(transaction_voucher != undefined)  data.append('transaction_voucher',transaction_voucher);
        if(declaration != undefined)          data.append('declaration',declaration);

        $.ajax({
            url : '/ajax/finance/edit',
            type : 'POST',
            data : data,
            processData : false,
            contentType : false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success : function(result){
                if(result.ret == 200) {
                    window.location = '/finance/details/' + id;
                }else{
                    alert(result.desc);
                }
            }
        });
    });
});
</script>
@endsection
