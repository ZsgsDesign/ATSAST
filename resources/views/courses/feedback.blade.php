@extends('layouts.app')

@section('template')

<style>
    nav.navbar {
        margin-bottom: 0 !important;
    }

    .mundb-standard-container {
        margin-top: 5rem;
    }

    .atsast-course-creator {
        height: 5rem;
    }

    .atsast-focus-img {
        width: 100%;
        height: 15rem;
        object-fit: cover;
        filter: brightness(0.75);
        -webkit-filter: brightness(0.75);
        user-select: none;
        pointer-events: none;
    }

    .atsast-course-header {
        position: relative;
    }

    .atsast-course-header .container {
        position: relative;
    }

    .atsast-course-avatar {
        position: absolute;
        bottom: -2.5rem;
        width: 10rem;
        height: 10rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 6rem;
        /* background: #009988; */
        color: #fff;
        border-radius: 1rem;
        box-shadow: 0 2px 2px 0 rgba(0, 0, 0, .14), 0 3px 1px -2px rgba(0, 0, 0, .2), 0 1px 5px 0 rgba(0, 0, 0, .12);
    }

    .atsast-course-header h1 {
        font-weight: 100;
        position: absolute;
        bottom: 0;
        left: calc(11rem + 15px);
        line-height: 1.5;
        color: #fff;
    }

    .atsast-course-header p {
        font-weight: 100;
        position: absolute;
        bottom: 3.75rem;
        left: calc(11rem + 15px);
        line-height: 1.2;
        color: #fff;
    }
    .atsast-course-header button.btn.btn-lg {
        padding:.5rem 1.5rem;
        font-weight: 100;
        position: absolute;
        bottom: 0.675rem;
        right: 15px;
        color: #fff;
    }

    card {
        display: block;
        border-radius: 4px;
        transition: .2s ease-out .0s;
        color: #7a8e97;
        background: #fff;
        padding: 1rem;
        position: relative;
        border: 1px solid rgba(0, 0, 0, 0.15);
        margin-bottom: 0.5rem;
        text-align: center;
        cursor: pointer;
    }

    card:hover{
        box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 40px;
    }

    card.wemd-red-text{
        border: 1px solid rgba(244, 67, 54, 0.15);
    }

    card.wemd-green-text{
        border: 1px solid rgba(76, 175, 80, 0.15);
    }

    card.wemd-red-text:hover{
        box-shadow: rgba(244, 67, 54, 0.2) 0px 0px 40px;
    }

    card.wemd-green-text:hover{
        box-shadow: rgba(76, 175, 80, 0.2) 0px 0px 40px;
    }

    card.wemd-red-text.selected{
        box-shadow: rgba(244, 67, 54, 0.2) 0px 0px 30px;
        background-color: rgba(229, 115, 115, 0.75);
        color:#fff!important;
    }

    card.wemd-green-text.selected{
        box-shadow: rgba(76, 175, 80, 0.2) 0px 0px 30px;
        background-color: rgba(129, 199, 132, 0.75);
        color:#fff!important;
    }

    .atsast-title {
        text-align: center;
        padding-bottom: 1rem;
    }
    .atsast-title h1,
    .atsast-title p {
        font-weight: 100;
    }

    .atsast-title > button{
        margin:1rem 0;
    }

    @media (max-width: 991px) {
        .atsast-course-header>.container {
            max-width: 100%;
            padding: 0;
            margin: 0;
            text-align: center;
        }
        .atsast-course-avatar {
            position: absolute;
            left: calc(50vw - 5rem);
        }
    }

    #nav-container {
        margin-bottom: 0px !important;
    }
</style>
<link rel="stylesheet" href="{{$ATSAST_DOMAIN}}/static/css/github.min.css">
<link rel="stylesheet" data-name="vs/editor/editor.main" href="{{$ATSAST_DOMAIN}}/static/library/vscode/vs/editor/editor.main.css">
<div class="atsast-course-header">
    <img src="{{$ATSAST_DOMAIN}}/static/img/bg.jpg" class="atsast-focus-img">
    <div class="container">
        <div class="atsast-course-avatar {{$course->course_color}}">
            @if(strlen($course->course_logo) <= 3)
                <i>{{$course->course_logo}}</i>
            @else
                <i class="{{$course->course_logo}}"></i>
            @endif
        </div>
        <p class="d-none d-lg-block">{{$course->organization->name}} ·@if($course->course_type==1) 线上课程@else 线下课程@endif</p>
        <h1 class="d-none d-lg-block">{{$course->course_name}}</h1>
        @if(Auth::check())<a href="{{$ATSAST_DOMAIN}}/course/{{$course->cid}}/register"><button type="button" class="btn btn-@if($register_status)success @else info @endif btn-lg btn-raised d-none d-lg-inline-block" @if($register_status)disabled @endif ><i class="MDI @if($register_status)check-circle-outline @else checkbox-marked-circle-outline @endif"></i>@if($register_status) 已报名@else 报名@endif</button></a>@endif
    </div>
</div>
<div class="container mundb-standard-container">
    <div class="d-block d-lg-none atsast-title">
        <h1>{{$course->course_name}}</h1>
        <p>{{$course->organization->name}}·@if($course->course_type==1) 线上课程@else 线下课程@endif</p>
    </div>
    <section class="mb-5">
        <h2>{{$syllabus->title}} - 课堂反馈</h2>
    </section>

    <section class="mb-5">
        <div>
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <card class="wemd-red-text @if(!empty($feedback) && $feedback->rank==0) selected @endif" id="card0" onclick="selectRank(0)">
                        <h2><i class="MDI emoticon-sad"></i></h2>
                        <p>不满意</p>
                    </card>
                </div>

                <div class="col-md-6 col-sm-12">
                    <card class="wemd-green-text @if(!empty($feedback) && $feedback->rank==1) selected @endif" id="card1" onclick="selectRank(1)">
                        <h2><i class="MDI emoticon-happy"></i></h2>
                        <p>满意</p>
                    </card>
                </div>
            </div>
            <div class="form-group">
                <label for="desc" class="bmd-label-floating">对本次课程的一些意见等等</label>
                <textarea class="form-control" name="desc" id="desc" rows="5" required>@if(!empty($feedback)){{ $feedback->desc }}@endif</textarea>
            </div>
            <div class="text-right">
                <a href="{{$ATSAST_DOMAIN}}/course/{{$course->cid}}/"><button class="btn btn-default">取消</button></a>
                <button type="submit" id="submit" class="btn btn-outline-primary" onclick="submit_feedback()">@if(!empty($feedback)) 修改反馈 @else 提交反馈 @endif</button>
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
    var rankVal=@if(!empty($feedback)) {{$feedback->rank}} @else -1 @endif;

    function selectRank(val){
        rankVal=val;
        $("#card0").removeClass("selected");
        $("#card1").removeClass("selected");
        $("#card"+val).addClass("selected");
    }

    let ajaxing = false;
    function submit_feedback() {
        if(rankVal<0) return alert("请选择一个评价");
        if(ajaxing)return;
        ajaxing=true;
        $("#submit").css("pointer-events","none");
        $.ajax({
            type: 'POST',
            url: '{{$ATSAST_DOMAIN}}/ajax/course/submitFeedBack',
            data: {
                cid:{{$course->cid}},
                syid:{{$syllabus->syid}},
                rank:rankVal,
                desc:$("#desc").val()
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, success: function(ret){
                console.log(ret);
                alert(ret.desc);
                setTimeout(function(){
                    location.href="{{$ATSAST_DOMAIN}}/course/{{$course->cid}}/detail";
                }, 1000);
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

@endsection
