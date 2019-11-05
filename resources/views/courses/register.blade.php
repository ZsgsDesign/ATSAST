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
</style>
<div class="container mundb-standard-container atsast-middle-container">
        <div class="row atsast-middle-container">
            <div class="col-md-8 col-sm-12">
                <div class="card">
                    <div class="card-img-top @if($register_status) bg-success @else bg-danger @endif">
                        <i class="MDI @if($register_status) check @else alert @endif"></i>
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title">@if($register_status) 报名成功 @else 报名失败 @endif</h5>
                        <p class="card-text">@if($register_status) 报名成功，请返回页面查看。@else 报名失败，请返回页面查看。@endif</p>
                        <a href="/course/<{$cid}>/detail" class="btn btn-primary">点击返回</a>
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

@endsection