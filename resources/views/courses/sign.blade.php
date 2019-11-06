@extends('layouts.app')

@section('template')

<style>
    .atsast-middle-container{
        display: flex;
        justify-content: center;
        align-items: center;
        flex-shrink: 0;
        flex-grow: 1;
    }
    .card-img-top{
        height:15rem;
        width:100%;
        font-size:6rem;
        display: flex;
        justify-content: center;
        align-items: center;
        color:rgba(255,255,255,0.75);
    }
    .card{
        margin-bottom:30px;
    }
    label{
        left: 0;
    }
    form{
        margin-bottom: 0;
    }
    button{
        margin-top:1rem;
    }
</style>
@if($sign_status==0)
<div class="container mundb-standard-container atsast-middle-container">
    <div class="row atsast-middle-container">
        <div class="col-md-8 col-sm-12">
            <div class="card">
                <div class="card-img-top bg-info">
                    <i class="MDI key-variant"></i>
                </div>
                <div class="card-body text-center">
                    <h5 class="card-title">填写签到码</h5>
                    <p class="card-text">{{ $syllabus->title }}</p>
                    <div class="form-group">
                        <label for="password" class="bmd-label-floating">签到码</label>
                        <input type="password" name="password" class="form-control" id="password" required>
                        <div class="invalid-feedback">请填写签到码</div>
                    </div>
                    <div class="text-right">
                        <button type="button" class="btn btn-danger" onclick="sign()">签到</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    let ajaxing = false;
    function sign() {
        var password = $('#password').val();
        if(ajaxing)return;
        ajaxing=true;
        $.ajax({
            type: 'POST',
            url: '{{$ATSAST_DOMAIN}}/ajax/course/sign',
            data: {
                signed: password,
                cid: {{$cid}},
                syid: {{$syid}},
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, success: function(ret){
                if (ret.data==1) {
                    $('.card-img-top').removeClass('bg-info');
                    $('.card-img-top').addClass('bg-success');
                    $('.MDI').removeClass('key-variant');
                    $('.MDI').addClass('check');
                    $('.card-title').html("签到成功");
                    $('.card-text').html("签到成功");
                    $('.form-group').remove();
                    $('.text-right').remove();
                    $('.card-body').append(`<a href="{{$ATSAST_DOMAIN}}/course/{{$cid}}/detail" class="btn btn-primary">点击返回</a>`);
                    setTimeout(function(){
                        location.href="{{$ATSAST_DOMAIN}}/course/{{$cid}}/detail";
                    }, 1000);
                } else if(ret.data==0) {
                    $('.card-img-top').removeClass('bg-info');
                    $('.card-img-top').addClass('bg-danger');
                    $('.MDI').removeClass('key-variant');
                    $('.MDI').addClass('alert');
                    $('.card-title').html("签到失败");
                    $('.card-text').html("已经签到过了哦，请返回。");
                    $('.form-group').remove();
                    $('.text-right').remove();
                    $('.card-body').append(`<a href="{{$ATSAST_DOMAIN}}/course/{{$cid}}/detail" class="btn btn-primary">点击返回</a>`);
                    setTimeout(function(){
                        location.href="{{$ATSAST_DOMAIN}}/course/{{$cid}}/detail";
                    }, 1000);
                } else {
                    $('.card-img-top').removeClass('bg-info');
                    $('.card-img-top').addClass('bg-danger');
                    $('.MDI').removeClass('key-variant');
                    $('.MDI').addClass('alert');
                    $('.card-title').html("签到失败");
                    $('.card-text').html("签到码错误，请返回。");
                    $('.form-group').remove();
                    $('.text-right').remove();
                    $('.card-body').append(`<a href="{{$ATSAST_DOMAIN}}/course/{{$cid}}/detail" class="btn btn-primary">点击返回</a>`);
                    setTimeout(function(){
                        location.href="{{$ATSAST_DOMAIN}}/course/{{$cid}}/detail";
                    }, 1000);
                }
                ajaxing=false;
            }, error: function(xhr, type){
                console.log(xhr);
                switch(xhr.status) {
                    case 422:
                        alert(xhr.responseJSON.errors[Object.keys(xhr.responseJSON.errors)[0]][0], xhr.responseJSON.message);
                        break;
                    case 429:
                        alert(`Submit too often, try ${xhr.getResponseHeader('Retry-After')} seconds later.`);
                        break;
                    default:
                        alert("Server Connection Error");
                }
                console.log('Ajax error while posting to sign!');
                ajaxing=false;
            }
        });
    }
</script>
@else
<div class="container mundb-standard-container atsast-middle-container">
    <div class="row atsast-middle-container">
        <div class="col-md-8 col-sm-12">
            <div class="card">
                <div class="card-img-top @if($sign_status>0) bg-success @else bg-danger @endif">
                    <i class="MDI @if($sign_status>0) check @else alert @endif"></i>
                </div>
                <div class="card-body text-center">
                    <h5 class="card-title">@if($sign_status>0) 签到成功 @else 签到失败 @endif</h5>
                    <p class="card-text">@if($sign_status==1) 签到成功@elseif($sign_status==-1) 已经签到过了哦@else 签到码错误@endif，请返回。 </p>
                    <a href="{{$ATSAST_DOMAIN}}/course/{{$cid}}/detail" class="btn btn-primary">点击返回</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    setTimeout(function(){
        location.href="{{$ATSAST_DOMAIN}}/course/{{$cid}}/detail";
    }, 1000);
</script>
@endif
@endsection
