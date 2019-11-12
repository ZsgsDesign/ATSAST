@extends('layouts.app')

@section('template')

<style>
    paper-card {
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
    paper-card.img-card{
        padding:0;
        overflow: hidden;
        cursor: pointer;
    }

    paper-card.img-card > img{
        width:100%;
        height:10rem;
        object-fit: cover;
    }
    paper-card.img-card > div{
        text-align: center;
        padding: 1rem;
    }

    paper-card.album-selected {
        box-shadow: rgba(0, 0, 0, 0.35) 0px 0px 40px!important;
        transform: scale(1.02);
    }
    paper-card:hover {
        box-shadow: rgba(0, 0, 0, 0.15) 0px 0px 40px;
    }
    h5{
        margin-bottom:1rem;
    }
    .form-control:disabled, .form-control[disabled]{
        background-color: transparent;
    }
    .atsast-img-container{
        width: 100%;
        padding:2rem;
    }
    .atsast-img-container > img{
        width: 100%;
    }
    .atsast-upload{
        display: none;
    }

    #avatar{
        box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 30px;
        border-radius: 4px;
    }

    contest-card{
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


    contest-card > .atsast-img-container{
        overflow: hidden;
        height:15rem;
        width:35rem;
        position: absolute;
        top:-2.5rem;
        right:-2.5rem;
    }

    contest-card:hover{
        box-shadow: rgba(0, 0, 0, 0.15) 0px 0px 40px;
    }

    contest-card > .atsast-img-container-small{
        width:100%;
        height:15rem;
    }

    contest-card > .atsast-img-container-small > img{
        height:100%;
        width:100%;
        object-fit: cover;
    }

    contest-card > .atsast-img-container::after{
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

    contest-card > .atsast-content-container{
        /* display: flex;
        align-items: center; */
        height:100%;
        flex-shrink: 1;
        flex-grow: 1;
        padding:1rem;
        z-index: 1;
    }

    contest-card > .atsast-img-container > img{
        height:100%;
        width:100%;
        object-fit: cover;
    }

    .atsast-empty{
        justify-content: center;
        align-items: center;
        height: 10rem;
    }

    badge-tip{
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
    .atsast-basic-info > span{
        padding-right:1rem;
    }

</style>

<div class="container mundb-standard-container">
    <h1 class="mb-3"><i class="MDI view-dashboard"></i> 我管理的活动</h1>
    <hr class="atsast-line mb-5">
    <paper-card class="mb-5">
        <div class="row @if(empty($contests)) atsast-empty @endif">
            @if(empty($contests))
                <badge-tip>这里将会展示所有我管理的活动</badge-tip>
            @else
                @foreach($contests as $contest)
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <contest-card>
                        <div class="atsast-img-container-small">
                            <img src="{{$ATSAST_DOMAIN.$contest->image}}">
                        </div>
                        <div class="atsast-content-container">
                            <h3 class="mundb-text-truncate-1">{{$contest->name}}</h3>
                            <p class="mundb-text-truncate-1">{{$contest->organization->name}} · {{$contest->type == 1 ? '线上' : '线下'}}活动</p>
                            <p class="mundb-text-truncate-1 atsast-basic-info"> <i class="MDI clock"></i> {{$contest->parse_date}} </p>
                            <a href="{{$ATSAST_DOMAIN.route('contest.detail',['cid' => $contest->contest_id], null)}}"><button class="btn btn-outline-info"><i class="MDI information-outline"></i> 活动信息</button></a>
                            <a href="{{$ATSAST_DOMAIN.route('contest.manage.export',['cid' => $contest->contest_id], null)}}>"><button class="btn btn-outline-warning"><i class="MDI eye"></i> 导出报名信息</button></a>
                        </div>
                    </contest-card>
                </div>
                @endforeach
            @endif
        </div>
    </paper-card>
</div>

@endsection
