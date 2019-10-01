@extends('layouts.app')

@section('template')

<style>
    .card-header > i{
        display: inline-block;
        transform: scale(1.5);
        opacity: 0.75;
        padding-right: 0.5rem;
    }
    .list-group-item :first-child {
        margin-right: 0rem;
    }
    .atsast-profile-focus{
        top: 0;
        left:0;
        width:100%;
        height:35rem;
        object-fit: cover;
        filter: brightness(0.75);
        -webkit-filter: brightness(0.75);
        margin-bottom:3rem;
        position: absolute;
    }
    nav.navbar {
        margin-bottom: 30px;
        top: 0;
        position: absolute;
        right: 0;
        left: 0;
        background: transparent!important;
        box-shadow: none;
    }
    .atsast-profile-container{
        display: flex;
        justify-content: center;
    }
    .atsast-left-panel{
        width:15rem;
        flex-shrink: 0;
        flex-grow: 0;
        margin-bottom: 5rem;
    }
    .atsast-title-panel{
        height:15rem;
        position: relative;
    }
    .atsast-title-panel > div{
        position: absolute;
        bottom:2rem;
        left:0;
        right:0;
        color:rgba(255,255,255,0.75);
        display:flex;
        justify-content: space-between;
    }
    .atsast-title-acton{
        flex-shrink: 0;
        flex-grow: 0;
        display: flex;
        align-items: flex-end;
    }
    .atsast-title-text{
        flex-shrink: 1;
        flex-grow: 1;
    }
    .atsast-title-text > *{
        font-weight: 100;
    }
    .atsast-title-text > p{
        margin-bottom:0;
    }
    .atsast-right-panel{
        flex-shrink: 1;
        flex-grow: 1;
        padding:1rem;
    }
    .mundb-standard-container{
        margin-top:20rem;
    }
    .atsast-user-card{
        display: block;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 30px;
        border-radius: 4px;
        transition: .2s ease-out .0s;
        color: #7a8e97;
        background: #fff;
    }

    course{
        display: flex;
        justify-content: center;
        align-items: center;
        background:#fff;
        border-radius: 2px;
        overflow: hidden;
        transition: .2s ease-out .0s;
        padding:0;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 10px;
        border: 1px solid rgba(0, 0, 0, 0.15);
        color: #7a8e97;
    }
    .atsast-courses a{
        color: #212529!important;
        text-decoration: none!important;
    }
    course:hover{
        box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 30px;
    }
    course > div:first-of-type{
        display: flex;
        width:5.5rem;
        height: 5.5rem;
        justify-content: center;
        align-items: center;
        color:rgba(255,255,255,0.75);
        font-size: 4.3rem;
        margin-right:1rem;
        flex-shrink: 0;
        flex-grow: 0;
    }
    course > div:last-of-type{
        display: flex;
        justify-content: flex-start;
        align-items: center;
        flex-shrink: 1;
        flex-grow: 1;
        margin-right:1rem;
    }
    course h6{
        margin:0;
    }course p{
        margin:0;
        padding-top:0.25rem;
    }
    .list-group-item{
        display: block;
    }
    .atsast-courses{
        padding:1rem;
    }
    .list-group-item > strong{
        display:block;
        margin-bottom: 0.5rem;
    }
    .list-group-item > p{
        margin:0;
    }
    card {
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
    card:hover {
        box-shadow: rgba(0, 0, 0, 0.15) 0px 0px 40px;
    }
    .progress{
        margin-bottom: 0.5rem;
    }

    contest{
        display: block;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 30px;
        border-radius: 4px;
        transition: .2s ease-out .0s;
        color: #7a8e97;
        background: #fff;
        position: relative;
        border: 1px solid rgba(0, 0, 0, 0.15);
        margin-bottom: 2rem;
        overflow: hidden;
        z-index: 0;
    }


    contest > .atsast-img-container{
        overflow: hidden;
        height:15rem;
        width:35rem;
        position: absolute;
        top:-2.5rem;
        right:-2.5rem;
    }

    contest:hover{
        box-shadow: rgba(0, 0, 0, 0.15) 0px 0px 40px;
    }

    contest > .atsast-img-container-small{
        width:100%;
        height:15rem;
    }

    contest > .atsast-img-container-small > img{
        height:100%;
        width:100%;
        object-fit: cover;
    }


    contest > .atsast-img-container::after{
        content: "";
        display: block;
        position: absolute;
        z-index: 1;
        top:-2.5rem;
        left:-2.5rem;
        bottom:-2.5rem;
        right:-1px;
        background:linear-gradient(to right,rgba(255,255,255,1) 10%,rgba(255,255,255,0) 100%);
    }

    contest > .atsast-content-container{
        /* display: flex;
        align-items: center; */
        height:100%;
        flex-shrink: 1;
        flex-grow: 1;
        padding:1rem;
        z-index: 1;
    }

    contest > .atsast-img-container > img{
        height:100%;
        width:100%;
        object-fit: cover;
    }

    .atsast-empty{
        justify-content: center;
        align-items: center;
        height: 10rem;
    }

    badge{
        display: inline-block;
        padding: 0.25rem 0.75em;
        font-weight: 700;
        line-height: 1.5;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.125rem;
        background-color: #f5f5f5;
    }
</style>
<img class="atsast-profile-focus" src="{{ $imgurl }}">
<div class="container mundb-standard-container">
    <div class="atsast-profile-container">
        <div class="atsast-left-panel">
            <div class="card mb-3 atsast-user-card">
                <img class="card-img-top" src="{{ $detail->avatar }}">
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>用户名</strong><p>{{ $detail->name }}</p></li>
                        <li class="list-group-item"><strong>邮箱</strong><p>{{ $detail->email }}</p></li>
                        <li class="list-group-item"><strong>学号</strong><p>{{ $detail->SID }}</p></li>
                    </ul>
                </div>
                <div class="card-body text-right">
                    <a href="/account/settings#user-info"><button class="btn btn-primary">修改基本信息</button></a>
                </div>
            </div>
        </div>
        <div class="atsast-right-panel d-none d-lg-block">
            <div class="atsast-title-panel">
                <div>
                    <div class="atsast-title-text">
                        <h1>{{ $detail->display_name }}</h1>
                        <p>{{ $detail->title }}</p>
                    </div>
                    <div class="atsast-title-acton">
                        <a href="/account/settings#cover-image"><button type="button" class="btn btn-outline-light"><i class="MDI image-filter-hdr"></i> 修改封面</button></a>
                    </div>
                </div>
            </div>
            <card class="mb-3" id="user-info">
                <h5><i class="MDI note-text"></i> 报名课程</h5>
                <div class="row @if(empty($result))atsast-empty @endif">
                @if(empty($result))
                    <badge>暂无</badge>
                @else
                    @foreach($result as $r)
                    <div class="col-lg-6 col-md-12 atsast-courses">
                        <a href="/course/{{$r->cid}}/detail">
                            <course>
                                <div class="wemd-{{$r->course_color}}">
                                    <i class="devicon-{{$r->course_logo}}-plain"></i>
                                </div>
                                <div>
                                    <div>
                                        <h6 class="mundb-text-truncate-1">{{$r->course_name}}</h6>
                                        <p class="mundb-text-truncate-2"><small>{{$r->course_desc}}</small></p>
                                    </div>
                                </div>
                            </course>
                        </a>
                    </div>
                    @endforeach
                @endif
                </div>

                <div class="text-right mt-1">
                    <button class="btn btn-info">查看更多</button>
                </div>
            </card>
            <card class="mb-5" id="user-info">
                <h5><i class="MDI airballoon"></i> 报名活动</h5>
                <div class="row @if(empty($contest_result))atsast-empty @endif">
                @if(empty($contest_result))
                    <badge>暂无</badge>
                @else
                    @foreach($contest_result as $c)
                    <div class="col-lg-6 col-md-12 atsast-courses">
                        <contest>
                            <div class="atsast-img-container-small">
                                <img src="{{$c->image}}">
                            </div>
                            <div class="atsast-content-container">
                                <h3 class="mundb-text-truncate-1">{{$c->name}}</h3>
                                <p class="mundb-text-truncate-1">{{$c->creator_name}} ·@if($c->type==1) 线上活动@else 线下活动@endif</p>
                                <p class="mundb-text-truncate-1"> {!!$c->parse_status!!} <i class="MDI clock"></i> {{$c->parse_date}} </p>
                                <a href="/contest/{{$c->contest_id}}/detail"><button class="btn btn-outline-info"><i class="MDI note"></i> 查看详情</button></a>
                                <a href="/contest/{{$c->contest_id}}/register"><button class="btn btn-outline-warning"><i class="MDI pen"></i> 查看报名信息</button></a>
                            </div>
                        </contest>
                    </div>
                    @endforeach
                @endif
                </div>

                <div class="text-right mt-1">
                    <a href="/account/contests/"><button class="btn btn-info">查看更多</button></a>
                </div>
            </card>

        </div>
    </div>
</div>

@endsection