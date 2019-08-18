@extends('layouts.app')

@section('template')

<div class="container mundb-standard-container">
    <section class="mb-5">
        <h5>汇报BUG</h5>
        <div>
            <div class="form-group">
                <label for="title" class="bmd-label-floating">BUG简述</label>
                <input type="text" class="form-control" name="title" id="title" required>
            </div>
            <div class="form-group">
                <label for="desc" class="bmd-label-floating">BUG详细信息</label>
                <textarea class="form-control" name="desc" id="desc" rows="5" required></textarea>
                </div>
            <div class="text-right">
                <button type="submit" id="submit" class="btn btn-outline-primary" onclick="submit_bugs()">提交BUG</button>
            </div>
        </div>
    </section>
</div>
<div id="modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modeal_title"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p id="modeal_desc"></p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">确定</button>
        </div>
        </div>
    </div>
</div>
<script>
    function alert(desc) {
        var title = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : "提示";
        $('#modeal_desc').html(desc);
        $('#modeal_title').html(title);
        $('#modal').modal();
    }

    function submit_bugs(){
        $("#submit").css("pointer-events","none");

        $.ajax({
            type: 'POST',
            url: '/ajax/system/SubmitBugs',
            data: {
                title:$("#title").val(),
                desc:$("#desc").val()
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, success: function(ret){
                console.log(ret);
                if(ret.ret==200){
                    alert("我们已收到您的反馈！","成功！");
                }else{
                    alert(ret.desc,"糟糕！");
                }
                generate_processing = false;
            }, error: function(xhr, type){
                console.log('Ajax 错误！');

                switch(xhr.status) {
                    case 429:
                        alert(`Submit too often, try ${xhr.getResponseHeader('Retry-After')} seconds later.`);
                        $("#verdict_text").text("Submit Frequency Exceed");
                        $("#verdict_info").removeClass();
                        $("#verdict_info").addClass("wemd-black-text");
                        break;
                    case 422:
                        alert(xhr.responseJSON.errors[Object.keys(xhr.responseJSON.errors)[0]][0], xhr.responseJSON.message);
                        break;
                    default:
                        alert("有点不对劲儿","糟糕！");
                }
            }
        });
    }
</script>

@endsection