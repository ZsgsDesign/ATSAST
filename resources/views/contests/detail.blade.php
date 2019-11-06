@extends('layouts.app')

@section('template')

<style>

    contest,card,.carousel{
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

    card{
        padding:1rem;
    }

    contest > .atsast-img-container{
        overflow: hidden;
        height:15rem;
        width:35rem;
        position: absolute;
        top:-2.5rem;
        right:-2.5rem;
    }

    contest:hover,
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
    }

    card:hover {
        box-shadow: rgba(0, 0, 0, 0.15) 0px 0px 40px;
    }

    h5{
        margin-bottom:1rem;
    }


    .carousel-caption{
        padding: 0;
        bottom: 0;
        top: 0;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .carousel-item > img{
        height: 25rem;
        object-fit: cover;
    }

    .carousel-fade .carousel-item {
        opacity: 0;
        transition-duration: .6s;
        transition-property: opacity
    }

    .carousel-fade .carousel-item-next.carousel-item-left,.carousel-fade .carousel-item-prev.carousel-item-right,.carousel-fade .carousel-item.active {
        opacity: 1
    }

    .carousel-fade .active.carousel-item-left,.carousel-fade .active.carousel-item-right {
        opacity: 0
    }

    .carousel-fade .active.carousel-item-left,.carousel-fade .active.carousel-item-prev,.carousel-fade .carousel-item-next,.carousel-fade .carousel-item-prev,.carousel-fade .carousel-item.active {
        -webkit-transform: translateX(0);
        transform: translateX(0)
    }

    @supports ((-webkit-transform-style: preserve-3d) or (transform-style:preserve-3d)) {
        .carousel-fade .active.carousel-item-left,.carousel-fade .active.carousel-item-prev,.carousel-fade .carousel-item-next,.carousel-fade .carousel-item-prev,.carousel-fade .carousel-item.active {
            -webkit-transform:translate3d(0,0,0);
            transform: translate3d(0,0,0)
        }
    }
</style>
<div class="container mundb-standard-container">
    <section class="mb-5">
        <div class="row">
            <div class="col-md-4 col-sm-12">
                <contest>
                    <div class="atsast-img-container-small">
                        <img src="{{$ATSAST_DOMAIN.$contest->image}}">
                    </div>
                    <div class="atsast-content-container">
                        <h3 class="mundb-text-truncate-2">{{$contest->name}}</h3>
                        <p class="mundb-text-truncate-1">{{$contest->organization->name}} ·@if($contest->type==1) 线上活动@else 线下活动@endif</p>
                        <p class="mundb-text-truncate-1"><i class="MDI clock"></i> {{$contest->parse_date}} </p>
                        @if(Auth::check())@if(empty($contest->userRegister(Auth::user()->id)))<a href="{{$ATSAST_DOMAIN}}/contest/{{$contest->contest_id}}/register"><button class="btn btn-outline-info">立即报名</button></a>@else<a href="{{$ATSAST_DOMAIN}}/contest/{{$contest->contest_id}}/register"><button class="btn btn-outline-warning"><i class="MDI pencil"></i> 查看报名信息</button></a>@endif @else<a href="{{$ATSAST_DOMAIN}}/login"><button class="btn btn-outline-secondary"><i class="MDI account-circle"></i> 请先登录再报名</button></a>@endif
                    </div>
                </contest>
            </div>
            <div class="col-md-8 col-sm-12">
                <div id="mixed" class="carousel slide carousel-fade" data-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($details as $detail)
                            @if($detail->type==1)
                            <div class="carousel-item">
                                <img class="d-block w-100" src="{{$ATSAST_DOMAIN.$detail->content}}">
                            </div>
                            @endif
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#mixed" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">前</span>
                    </a>
                    <a class="carousel-control-next" href="#mixed" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">后</span>
                    </a>
                </div>
                <card>
                    <h5><i class="MDI information"></i> 基本信息</h5>
                    @foreach($details as $detail)
                        @if($detail->type==0)
                        <div class="mb-1" id="markdown_container_{{$detail->cdid}}">

                        </div>
                        @endif
                    @endforeach
                </card>
            </div>
        </div>
    </section>
</div>
<script src="{{$ATSAST_DOMAIN}}/static/js/purify.min.js"></script>
<script>
    var jsCnt2=0;
    function loadJsAsync2(url){
        var body = document.getElementsByTagName('body')[0];
        var jsNode = document.createElement('script');

        jsNode.setAttribute('type', 'text/javascript');
        jsNode.setAttribute('src', url);
        body.appendChild(jsNode);

        jsNode.onload = function() {
            jsCnt2++;
            if(jsCnt2==2){
                marked.setOptions({
                    renderer: new marked.Renderer(),
                    gfm: true,
                    tables: true,
                    breaks: false,
                    pedantic: false,
                    sanitize: false,
                    smartLists: true,
                    smartypants: false,
                    highlight: function (code) {
                        return hljs.highlightAuto(code).value;
                    }
                });
                @foreach($details as $detail)
                    @if($detail->type==0)
                    $("#markdown_container_{{ $detail->cdid }}").html(marked(decodeURIComponent("{!! rawurlencode($detail->slash_content) !!}"),{
                        sanitize:true,
                        sanitizer:DOMPurify.sanitize,
                        highlight: function (code) {
                            return hljs.highlightAuto(code).value;
                        }
                    }));
                    $("#markdown_container_{{ $detail->cdid }}").css("opacity","1");
                    @endif
                @endforeach
                //hljs.initHighlighting();
                // 链式调用VSCODE
                // loadJsAsync("{{$ATSAST_DOMAIN}}/static/vscode/vs/loader.js");
            }
        }
    }
    window.addEventListener("load",function() {
        loadJsAsync2("{{$ATSAST_DOMAIN}}/static/js/marked.min.js");
        loadJsAsync2("{{$ATSAST_DOMAIN}}/static/js/highlight.min.js");
        $('.carousel').carousel();
        $('.carousel-item:first-of-type').addClass("active");
    }, false);
</script>

@endsection
