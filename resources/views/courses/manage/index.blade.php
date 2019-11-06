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
    .atsast-course-header button.btn.btn-lg,
    .atsast-course-header .dropdown {
        padding:.5rem 1.5rem;
        font-weight: 100;
        position: absolute;
        bottom: 0.675rem;
        right: 15px;
        color: #fff;
    }

    instructor {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        padding: 0.25rem;
        margin-bottom: 1rem;
    }

    instructor>img {
        width: 5rem;
        height: 5rem;
        border-radius: 2000px;
        flex-shrink: 0;
        flex-grow: 0;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 30px;
    }

    instructor>icon.btn {
        display: flex;
        width: 5rem;
        height: 5rem;
        border-radius: 2000px;
        border: 1px dashed rgba(0, 0, 0, 0.25);
        flex-shrink: 0;
        flex-grow: 0;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 30px;
        color: #7a8e97;
        font-size: 2.5rem;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        transition: .2s ease-out .0s;
    }

    instructor>icon.btn:hover {
        box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 40px;
        font-size: 3rem;
    }

    instructor>div {
        padding-left: 1rem;
        flex-shrink: 1;
        flex-grow: 1;
    }

    instructor p {
        margin: 0;
    }

    hr.atsast-line {
        margin-top: 1.5rem;
        margin-bottom: 1.5rem;
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

    .atsast-basic-info {
        border: 1px solid #ddd;
        width: 100%;
        border-collapse: collapse;
        background-color: transparent;
    }

    instructor small,
    th{
        font-weight: 100;
        color: #8a6219;
    }

    td{
        font-weight: 100;
    }

    tbody i.MDI{
        transform: scale(1.5);
        display: inline-block;
        padding-right: 0.5rem;
    }

    .atsast-tooltip{
        text-align: center;
    }

    .btn-raised[disabled]{
        pointer-events: none;
    }

    syllabus{
        display: block;
    }

    syllabus > h3{
        padding:1rem 0;
        font-weight: 100;
    }

    syllabus > info {
        padding-right:1rem;
        color: #6e767f;
        font-weight: 900;
    }

    syllabus action {
        /* padding-right:1rem; */
        color: #6e767f;
        font-weight: 900;
        line-height: 1;
    }

    syllabus action > i {
        color: inherit;
    }

    .text-lalala {
        color: #3f51b5;
    }

    syllabus i{
        font-size: 2rem;
        vertical-align: middle;
        color: #8a6219;
        font-weight: 100;
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

    th{
        white-space: nowrap;
    }

    .atsast-important-button{
        box-shadow: rgba(255, 87, 34, 0.1) 0px 0px 30px;
        border-radius: 4px;
        transition: .2s ease-out .0s;
        color: #7a8e97;
        background: #fff;
        position: relative;
        margin-top: 1rem;
        margin-bottom: 1rem;
    }

    .form-control:disabled, .form-control[disabled]{
        background-color: transparent;
    }

    #nav-container {
        margin-bottom: 0px !important;
    }
</style>
<div class="atsast-course-header">
    <img src="{{$ATSAST_DOMAIN}}/static/img/bg.jpg" class="atsast-focus-img">
    <div class="container">
        <div class="atsast-course-avatar wemd-{{$result['course_color']}}">
            <i class="devicon-{{$result['course_logo']}}-plain"></i>
        </div>
        <p class="d-none d-lg-block">{{$result['creator_name']}} ·@if($result['course_type']==1) 线上课程@else 线下课程@endif</p>
        <h1 class="d-none d-lg-block">{{$result['course_name']}}</h1>
        <div class="dropdown d-none d-lg-inline-block">
            <button class="btn btn-outline-light btn-lg dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                操作
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item text-secondary" href="{{$ATSAST_DOMAIN}}/course/{{$cid}}/edit"><i class="MDI pencil"></i> 编辑</a>
                <a class="dropdown-item text-secondary" href="{{$ATSAST_DOMAIN}}/course/{{$cid}}/view_register"><i class="MDI check-circle-outline"></i> 查看报名情况</a>
            </div>
        </div>
    </div>
</div>
<div class="container mundb-standard-container">
    <div class="d-block d-lg-none atsast-title">
        <h1>{{$result['course_name']}}</h1>
        <p>{{$result['creator_name']}} ·@if($result['course_type']==1) 线上课程@else 线下课程@endif</p>
        <div class="dropdown d-inline-block d-lg-none">
            <button class="btn btn-outline-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                操作
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item text-secondary" href="{{$ATSAST_DOMAIN}}/course/{{$cid}}/edit"><i class="MDI pencil"></i> 编辑</a>
                <a class="dropdown-item text-secondary" href="{{$ATSAST_DOMAIN}}/course/{{$cid}}/view_register"><i class="MDI check-circle-outline"></i> 查看报名情况</a>
            </div>
        </div>
    </div>
    <section class="mb-5">

        <p>
            <strong>关于此课程：</strong>{{$result['course_desc']}}
        </p>
        <p>
            <strong>此课程适用人群：</strong>{{$result['course_suitable']}}
        </p>

        <hr class="atsast-line">

        <p>
            <strong>课程提供：</strong>{{$result['creator_name']}}
        </p>

        <img class="atsast-course-creator" src="{{$ATSAST_DOMAIN.$result['creator_logo']}}">

        <hr class="atsast-line">

        <div class="row mb-3">
            @if(!$instructor)
            <div class="col-sm-12">
                <p class="atsast-tooltip"><span class="badge badge-secondary">暂无讲师信息</span></p>
            </div>
            @else
            @foreach($instructor as $r)
            <div class="col-lg-4 col-md-6 col-sm-12">
                <instructor>
                    <img src="{{ $ATSAST_DOMAIN.$r['avatar'] }}">
                    <div>
                        <p><strong>{{ $r['course_title'] }}：</strong>@if($r["real_name"]){{$r["real_name"]}}@else{{$r["SID"]}}@endif</p>
                        <small>{{ $r['title'] }}</small>
                        @if($access_right["clearance"]==4)<p><small style="cursor: pointer;" class="wemd-red-text" data-iid="{{ $r['iid'] }}" onclick="deleteInstructor(this)">删除</small></p>@endif
                    </div>
                </instructor>
            </div>
            @endforeach
            @if($access_right["clearance"]==4)
            <div class="col-lg-4 col-md-6 col-sm-12">
                <instructor>
                    <icon class="btn" onclick="add_instructor()">
                        <i class="MDI plus"></i>
                    </icon>
                    <div>
                        <p><strong>新增讲师</strong></p>
                        <small>输入邮箱新增讲师到这里</small>
                    </div>
                </instructor>
            </div>
            @endif
            @endif
        </div>
        <small>课程信息</small>
        <table class="table table-borderless table-hover">
            <tbody>
                @foreach($detail as $r)
                <tr>
                    <th scope="row"><i class="MDI {{ $r['icon'] }}"></i> {{ $r['item_name'] }}</th>
                    <td>{{ $r['item_value'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>


    </section>
    <section  id="accordion" class="mb-5">
        <h2>授课大纲 - 你能学习到的</h2>
        <p>syllabus</p>
        <hr class="atsast-line">
        @foreach($syllabus as $r)
        <syllabus>
            <div>
                <info class="d-block d-lg-inline-block"><i class="MDI clock"></i> {{ $r['time'] }}</info>
                <info class="d-block d-lg-inline-block"><i class="MDI near-me"></i> {{ $r['location'] }}</info>

                <h3>{{ $r['title'] }}</h3>
                <p>{{ $r['desc'] }}</p>
                <button type="button" data-toggle="collapse" class="btn btn-info" data-target="#collapse{{$r['syid']}}" aria-expanded="false" aria-controls="collapse{{$r['syid']}}"><action class="d-block d-lg-inline-block text-info"><i class="MDI menu"></i> 所有操作</action></button>
            </div>
            <div id="collapse{{$r['syid']}}" class="collapse" aria-labelledby="heading{{$r['syid']}}" data-parent="#accordion">
                <hr class="atsast-line">
                <a href="view_sign/{{ $r['syid'] }}"><button type="button" class="btn"><action class="d-block d-lg-inline-block text-primary"><i class="MDI account-circle"></i> 查看签到情况</action></button></a>
                <a href="view_homework/{{ $r['syid'] }}"><button type="button" class="btn"><action class="d-block d-lg-inline-block text-primary"><i class="MDI pen"></i> 查看作业提交</action></button></a>
                <a href="view_feedback/{{ $r['syid'] }}"><button type="button" class="btn"><action class="d-block d-lg-inline-block text-primary"><i class="MDI comment-text-outline"></i> 查看课堂反馈</action></button></a>
                <a href="edit_syllabus/{{ $r['syid'] }}"><button type="button" class="btn"><action class="d-block d-lg-inline-block text-lalala"><i class="MDI file-document"></i> 编辑课时信息</action></button></a>
                <a href="edit_sign/{{ $r['syid'] }}"><button type="button" class="btn"><action class="d-block d-lg-inline-block text-lalala"><i class="MDI account-circle"></i> 设置签到信息</action></button></a>
                <a href="edit_script/{{ $r['syid'] }}"><button type="button" class="btn"><action class="d-block d-lg-inline-block text-lalala"><i class="MDI script"></i> 设置授课笔记</action></button></a>
                <a href="edit_homework/{{ $r['syid'] }}"><button type="button" class="btn"><action class="d-block d-lg-inline-block text-lalala"><i class="MDI pen"></i> 设置作业信息</action></button></a>
                <a href="edit_feedback/{{ $r['syid'] }}"><button type="button" class="btn"><action class="d-block d-lg-inline-block text-lalala"><i class="MDI comment-text-outline"></i> 设置课堂反馈</action></button></a>
                <a href="edit_video/{{ $r['syid'] }}"><button type="button" class="btn"><action class="d-block d-lg-inline-block text-lalala"><i class="MDI video"></i> 设置视频信息</action></button></a>
            </div>
        </>
        <hr class="atsast-line">
        @endforeach
        <div class="text-center">
            <button type="button" class="btn btn-outline-warning atsast-important-button" onclick="location.href='{{$ATSAST_DOMAIN}}/course/{{$cid}}/add_syllabus'"><action class="d-block d-lg-inline-block text-warning"><i class="MDI plus"></i> 新增课时</action></button>
        </div>
    </section>
</div>

<div id="add_instructor" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="add_instructor_title">添加讲师</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="add_instructor_email" class="bmd-label-floating">邮箱</label>
                <input type="email" class="form-control" name="add_instructor_email" id="add_instructor_email">
            </div>
            <div class="form-group">
                <label for="add_instructor_role" class="bmd-label-floating">课程角色</label>
                <input type="text" class="form-control" name="add_instructor_role" value="讲师" id="add_instructor_role" disabled>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
            <button type="button" class="btn btn-primary" onclick="addInstructor()" data-dismiss="modal">添加讲师</button>
        </div>
        </div>
    </div>
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

    var canAdd=false;

    function add_instructor(){
        $('#add_instructor').modal();
        canAdd=true;
    }

    function addInstructor(){
        if(canAdd) canAdd=false;
        else return;
        var email=$("#add_instructor_email").val();
        $("#add_instructor_email").val("");
        $("#add_instructor_role").val("讲师");
        $.ajax({
            type: 'POST',
            url: '{{$ATSAST_DOMAIN}}/ajax/course/addInstructor',
            data: {
                cid:{{$cid}},
                email:email,
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, success: function(ret){
                console.log(ret);
                alert(ret.desc);
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
                console.log('Ajax error while posting to addInstructor!');
                ajaxing=false;
            }
        });
    }

    function deleteInstructor(ele){
        var iid=$(ele).attr("data-iid");
        $.ajax({
            type: 'POST',
            url: '{{$ATSAST_DOMAIN}}/ajax/course/removeInstructor',
            data: {
                cid:{{$cid}},
                iid:iid
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, success: function(ret){
                console.log(ret);
                alert(ret.desc);
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
                console.log('Ajax error while posting to removeInstructor!');
                ajaxing=false;
            }
        });
    }
</script>

@endsection
