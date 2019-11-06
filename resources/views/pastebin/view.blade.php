@extends('layouts.app')

@section('template')

<style>
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
    card.img-card{
        padding:0;
        overflow: hidden;
        cursor: pointer;
    }

    card.img-card > img{
        width:100%;
        height:10rem;
        object-fit: cover;
    }
    card.img-card > div{
        text-align: center;
        padding: 1rem;
    }

    card.album-selected {
        box-shadow: rgba(0, 0, 0, 0.35) 0px 0px 40px!important;
        transform: scale(1.02);
    }
    card:hover {
        box-shadow: rgba(0, 0, 0, 0.15) 0px 0px 40px;
    }
    h5{
        margin-bottom:1rem;
    }
    .form-control:disabled, .form-control[disabled]{
        background-color: transparent;
    }
    input{
        height: calc(2.4375rem + 2px);
    }
    #vscode_container{
        opacity: 0;
        transition: .2s ease-out .0s;
    }
    tips{
        display: block;
        font-size: .75rem;
        color: rgba(0,0,0,.26);
        margin-bottom: .5rem;
    }
    .pb-title{
        color: #7a8e97;
        text-align:center;
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
    pre{
        margin:0!important;
    }
    p.pb-info{
        color: #7a8e97;
    }
</style>
<div class="container mundb-standard-container">
    <div style="width:100%;">
        <h5 class="pb-title mb-3 mt-5"><i class="MDI content-paste"></i> SAST PasteBin</h5>
        @if($result)
        <p class="text-center mb-5 pb-info"><i class="MDI information"></i> 由 {{ $result->display_author }} 上传@if($result->expire)，将于 {{ $result->expire }} 过期@endif</p>
        <card class="mb-5">
            <pre data-lang="{{ $result->lang }}" id="pb_content">{{ $result->content }}</pre>
        </card>
        @else
        <card class="mb-3">
            <div class="row atsast-empty">
                <badge onclick="location.href='{{$ATSAST_DOMAIN}}/login'"><i class="MDI magnify"></i> 并没有找到您要的剪切板哦</badge>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('additionJS')
<script src="{{$ATSAST_DOMAIN}}/static/library/monaco-editor/min/vs/loader.js"></script>
<script>
    require.config({ paths: { 'vs': '{{env('APP_URL')}}/static/library/monaco-editor/min/vs' }});

    window.MonacoEnvironment = {
        getWorkerUrl: function(workerId, label) {
            return `data:text/javascript;charset=utf-8,${encodeURIComponent(`
            self.MonacoEnvironment = {
                baseUrl: '{{env('APP_URL')}}/static/library/monaco-editor/min/'
            };
            importScripts('{{env('APP_URL')}}/static/library/monaco-editor/min/vs/base/worker/workerMain.js');`
            )}`;
        }
    };

    require(["vs/editor/editor.main"], function () {
        monaco.editor.colorizeElement(document.getElementById("pb_content"));
    });
</script>
@endsection
