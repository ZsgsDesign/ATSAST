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
                        <form action="#" method="POST">
                            <div class="form-group">
                                <label for="password" class="bmd-label-floating">签到码</label>
                                <input type="password" name="password" class="form-control" id="password" required>
                                <div class="invalid-feedback">请填写签到码</div>
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-danger">签到</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>
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
                        <a href="/course/{{$cid}}/detail" class="btn btn-primary">点击返回</a>
                    </div>
                </div>
            </div>
        </div>
</div>
<script>
    setTimeout(function(){
        location.href="/course/{{$cid}}/detail";
    }, 1000);
</script>
@endif

@endsection