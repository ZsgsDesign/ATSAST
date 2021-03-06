@extends('layouts.app')

@section('template')

<style>
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
        width:35rem;
        position: absolute;
        top:-2.5rem;
        right:-2.5rem;
        bottom: -2.5rem;
    }

    card:hover {
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
        user-select: none;
    }

    contest:hover {
        box-shadow: rgba(0, 0, 0, 0.15) 0px 0px 40px;
    }

    h5{
        margin-bottom:1rem;
    }

    @media (min-width: 992px){
        contest > .atsast-content-container {
            width: calc(100% - 35rem);
        }
    }
    canvas#atsast-background-canvas{
        position: fixed;
        z-index: -1;
        top:0;
    }
    contest.add span{
        font-size: 5rem;
        font-weight: bolder
    }
</style>
<div class="container mundb-standard-container">
    <section class="mb-5">
        <h1>活动</h1>
        <p>Activities</p>
        @if(Auth::check() && Auth::user()->hasAccess('contest.add'))
        <contest class="add" style="cursor: pointer;" onclick="window.location='{{$ATSAST_DOMAIN}}/contest/add'">
            <div class="text-center">
                <span>+</span>
            </div>
        </contest>
        @endif
        @foreach($contests as $contest)
        <contest>
            <div class="d-block d-lg-none atsast-img-container-small">
                <img src="{{$ATSAST_DOMAIN.$contest->image}}">
            </div>
            <div class="d-none d-lg-block atsast-img-container">
                <img src="{{$ATSAST_DOMAIN.$contest->image}}">
            </div>
            <div class="atsast-content-container">
                <h3 class="mundb-text-truncate-2">{{$contest->name}}</h3>
                <p class="mundb-text-truncate-1">{{$contest->organization->name}} ·@if($contest->type==1) 线上活动@else 线下活动@endif</p>
                <p class="mundb-text-truncate-1"><i class="MDI clock"></i> {{$contest->parse_date}} </p>
                <a href="{{$ATSAST_DOMAIN}}/contest/{{$contest->contest_id}}/detail"><button class="btn btn-outline-info">了解更多</button></a>
                @if(Auth::check() && !$contest->is_end())
                    @if(empty($contest->userRegister(Auth::user()->id)))
                        @if($contest->register_is_due())
                            <a data-toggle="tooltip" data-placement="top" title="活动报名时间已过，如有需要请联系活动管理员"><button class="btn btn-primary">立即报名</button></a>
                        @else
                            <a href="{{$ATSAST_DOMAIN}}/contest/{{$contest->contest_id}}/register"><button class="btn btn-info">立即报名</button></a>
                        @endif
                    @else
                        <a href="{{$ATSAST_DOMAIN}}/account/contests/"><button class="btn btn-success">已报名</button></a>
                    @endif
                @endif
            </div>
        </contest>
        @endforeach
        <nav aria-label="Page navigation" class="atsast-pagination mt-5">
            <ul class="pagination justify-content-center">
                {{$contests->links()}}
            </ul>
        </nav>
    </section>
</div>

@endsection
