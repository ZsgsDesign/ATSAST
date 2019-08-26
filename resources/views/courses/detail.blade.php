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

    instructor {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        padding: 0.25rem;
        margin-bottom: 1rem;
    }

    instructor img {
        width: 5rem;
        height: 5rem;
        border-radius: 2000px;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 30px;
    }

    instructor > a{
        flex-shrink: 0;
        flex-grow: 0;
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
        color: #3f51b5;
    }

        syllabus action.atsast-finished > i {
        color: #009800;
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
    badge{
        display: inline-block;
        padding: 0.25rem 0.75em;
        font-weight: 700;
        line-height: 1.5;
        text-align: center;
        vertical-align: baseline;
        border-radius: 0.125rem;
        background-color: #f5f5f5;
        margin: 1rem;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 30px;
        border-radius: 4px;
        transition: .2s ease-out .0s;
        color: #7a8e97;
        background: #fff;
        position: relative;
        border: 1px solid rgba(0, 0, 0, 0.15);
    }

    .atsast-empty{
        display:flex;
        justify-content: center;
        align-items: center;
        height: 10rem;
    }

    #nav-container {
        margin-bottom: 0px !important;
    }
</style>
<div class="atsast-course-header">
    <img src="/static/img/bg.jpg" class="atsast-focus-img">
    <div class="container">
        <div class="atsast-course-avatar wemd-{{$result->course_color}}">
            <i class="devicon-{{$result->course_logo}}-plain"></i>
        </div>
        <p class="d-none d-lg-block">{{$result->creator_name}} ·@if($result->course_type==1) 线上课程@else 线下课程@endif</p>
        <h1 class="d-none d-lg-block">{{$result->course_name}}</h1>
        @if(Auth::check())<a href="/course/{{$cid}}/register"><button type="button" class="btn btn-@if($register_status)success @else info @endif btn-lg btn-raised d-none d-lg-inline-block" @if($register_status)disabled @endif ><i class="MDI @if($register_status)check-circle-outline @else checkbox-marked-circle-outline @endif"></i>@if($register_status) 已报名@else 报名@endif</button></a>@endif
    </div>
</div>
<div class="container mundb-standard-container">
    <div class="d-block d-lg-none atsast-title">
        <h1>{{$result->course_name}}</h1>
        <p>{{$result->creator_name}} ·@if($result->course_type==1) 线上课程@else 线下课程@endif</p>
        @if(Auth::check())<a href="/course/{{$cid}}/register"><button type="button" class="btn btn-@if($register_status)success @else info @endif btn-raised d-inline-block d-lg-none" @if($register_status)disabled @endif ><i class="MDI @if($register_status)check-circle-outline @else checkbox-marked-circle-outline @endif"></i> @if($register_status) 已报名@else 报名@endif</button></a>@endif
    </div>
    <section class="mb-5">

        <p>
            <strong>关于此课程：</strong>{{$result->course_desc}}
        </p>
        <p>
            <strong>此课程适用人群：</strong>{{$result->course_suitable}}
        </p>

        <hr class="atsast-line">

        <p>
            <strong>课程提供：</strong>{{$result->creator_name}}
        </p>

        <img class="atsast-course-creator" src="{{$result->creator_logo}}">

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
                    <a href="/user/{{ $r->uid }}"><img src="{{ $r->avatar }}"></a>
                    <div>
                        <p><strong>{{ $r->course_title }}：</strong>@if($r->real_name){{$r->real_name}}@else{{$r->SID}}@endif</p>
                        <small>{{ $r->title }}</small>
                    </div>
                </instructor>
            </div>
            @endforeach
            @endif
        </div>
        <small>课程信息</small>
        <table class="table table-borderless table-hover">
            <tbody>
                @foreach($detail as $r)
                <tr>
                    <th scope="row"><i class="MDI {{ $r->icon }}"></i> {{ $r->item_name }}</th>
                    <td>{{ $r->item_value }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>


    </section>
    <section class="mb-5">
        <h2>授课大纲 - 你能学习到的</h2>
        <p>syllabus</p>
        <hr class="atsast-line">
        @if(empty($syllabus))
        <div class="atsast-empty">
            <badge>本课程暂未提供授课大纲</badge>
        </div>
        @else
        @foreach($syllabus as $r)
        <syllabus>
            <info class="d-block d-lg-inline-block"><i class="MDI clock"></i> {{ $r->time }}</info>
            <info class="d-block d-lg-inline-block"><i class="MDI near-me"></i> {{ $r->location }}</info>
            
            <h3>{{ $r->title }}</h3>
            <p>{{ $r->desc }}</p>
            @if(Auth::check() && $register_status)
                @if($r->signed)
                    @if($r->signid)
                        <button type="button" class="btn" disabled><action class="d-block d-lg-inline-block atsast-finished"><i class="MDI account-check"></i> 已签到</action></button>
                    @else
                        <a href="sign/{{ $r->syid }}"><button type="button" class="btn"><action class="d-block d-lg-inline-block"><i class="MDI account-check"></i> 签到</action></button></a>
                    @endif
                @endif
                @if($r->script)<a href="script/{{ $r->syid }}"><button type="button" class="btn"><action class="d-block d-lg-inline-block"><i class="MDI script"></i> 授课笔记</action></button></a>@endif
                @if($r->homework)<a href="homework/{{ $r->syid }}"><button type="button" class="btn"><action class="d-block d-lg-inline-block"><i class="MDI pen"></i> 查看作业</action></button></a>@endif
                @if($r->feedback)<a href="feedback/{{ $r->syid }}"><button type="button" class="btn"><action class="d-block d-lg-inline-block"><i class="MDI comment-text-outline"></i> 课程反馈</action></button></a>@endif
                @if($r->video)<a href="{{ $r->video }}" target="_blank"><button type="button" class="btn"><action class="d-block d-lg-inline-block"><i class="MDI video"></i> 视频地址</action></button></a>@endif
            @elseif(Auth::check())
            <a href="register"><button type="button" class="btn"><action class="d-block d-lg-inline-block"><i class="MDI checkbox-marked-circle-outline"></i> 请先报名本课程</action></button></a>
            @else
            <a href="/login"><button type="button" class="btn"><action class="d-block d-lg-inline-block"><i class="MDI account-circle"></i> 请在登录后查看课时详情</action></button></a>
            @endif
        </syllabus>
        <hr class="atsast-line">
        @endforeach
        @endif
    </section>
</div>

@endsection