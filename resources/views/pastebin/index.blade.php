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
        cursor: pointer;
    }

    h1{
        font-family: Raleway;
        font-weight: 100;
        text-align: center;
    }
    #vscode_container_outline{
        border: 1px solid #ddd;
        /* padding:2px; */
        border-radius: 2px;
        margin-bottom:2rem;
        background: #fff;
        overflow: hidden;
    }
    a.action-menu-item:hover{
        text-decoration: none;
    }
    input.form-control.pb-input {
        height: calc(2.4375rem + 2px);
    }

    .cm-fake-select{
        height: calc(2.4375rem + 2px);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .cm-scrollable-menu::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    .cm-scrollable-menu::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, 0.2);
    }

    .cm-scrollable-menu{
        height: auto;
        max-height: 40vh;
        overflow-x: hidden;
        width: 100%;
        max-width:16rem;
    }
</style>
<div class="container mundb-standard-container">
    <div style="width:100%;">
        <h5 class="pb-title mb-5 mt-5"><i class="MDI content-paste"></i> SAST PasteBin</h5>
        @if(Auth::check())
        <card class="mb-3">


            <div class="mb-4">
                <div class="row">
                    <div class="col-lg-4 col-12">
                        <div class="form-group bmd-form-group is-filled">
                            <label for="pb_lang" class="bmd-label-floating">高亮格式</label>
                            <div class="form-control cm-fake-select dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="pb_lang" name="pb_lang" required="">Plain Text</div>
                            <div class="dropdown-menu cm-scrollable-menu" id="pb_lang_option"></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-12">
                            <div class="form-group bmd-form-group is-filled">
                                <label for="pb_time" class="bmd-label-floating">保存时间</label>
                                <div class="form-control cm-fake-select dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="pb_time" name="pb_time" required="">永久</div>
                                <div class="dropdown-menu cm-scrollable-menu"  id="pb_time_option">
                                    <button class="dropdown-item" data-value="0">永久</button>
                                    <button class="dropdown-item" data-value="1">1天</button>
                                    <button class="dropdown-item" data-value="7">7天</button>
                                    <button class="dropdown-item" data-value="30">30天</button>
                                </div>
                            </div>
                        </div>
                    <div class="col-lg-4 col-12">
                        <div class="form-group bmd-form-group is-filled">
                            <label for="pb_author" class="bmd-label-floating">作者</label>
                            <input type="text" class="form-control pb-input" name="pb_author" id="pb_author" value="@if(isset(Auth::user()["real_name"])){{ Auth::user()["real_name"] }}@else{{ Auth::user()["name"] }}@endif">
                        </div>
                    </div>
                </div>
                <tips>内容</tips>
                <div id="vscode_container">
                    <div id="vscode" style="width:100%;height:30rem;border:1px solid grey"></div>
                </div>
            </div>
            <div class="text-right">
                <button type="submit" class="btn btn-outline-info" onclick="generate()">生成</button>
            </div>
        </card>
        @else
        <card class="mb-3">
            <div class="row atsast-empty">
                <badge onclick="location.href='/login'"><i class="MDI account-circle"></i> 请先登录</badge>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('additionJS')

@if(Auth::check())
<script src="{{$ATSAST_DOMAIN}}/static/library/monaco-editor/min/vs/loader.js"></script>
<script>
    var aval_lang=[];
    var generate_processing=false;
    var targ_lang="plaintext",targ_expire=0,editor;

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
        editor = monaco.editor.create(document.getElementById('vscode'), {
            value: "",
            language: "plaintext",
            theme: "vs-light",
            fontSize: 16,
            formatOnPaste: true,
            formatOnType: true,
            automaticLayout: true,
        });
        $("#vscode_container").css("opacity",1);
        var all_lang=monaco.languages.getLanguages();
        all_lang.forEach(function (lang_conf) {
            aval_lang.push(lang_conf.id);
            $("#pb_lang_option").append("<button class='dropdown-item' data-value='"+lang_conf.id+"'>"+lang_conf.aliases[0]+"</button>");
            console.log(lang_conf.id);
        });
        $('#pb_lang_option button').click(function(){
            targ_lang=$(this).attr("data-value");
            $("#pb_lang").text($(this).text());
            monaco.editor.setModelLanguage(editor.getModel(), targ_lang);
        });
        $('#pb_time_option button').click(function(){
            targ_expire=$(this).attr("data-value");
            $("#pb_time").text($(this).text());
        });
    });

    function generate(){
        if(generate_processing) return;
        else generate_processing=true;
        $.ajax({
            type: 'POST',
            url: '/ajax/pastebin/generate',
            data: {
                syntax: targ_lang,
                expiration:targ_expire,
                display_author:$("#pb_author").val(),
                content: editor.getValue()
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, success: function(ret){
                console.log(ret);
                if(ret.ret==200){
                    location.href="{{$ATSAST_DOMAIN}}/pb/"+ret.data.code;
                }else{
                    alert(ret.desc,"糟糕！");
                }
                generate_processing = false;
            }, error: function(xhr, type){
                console.log('Ajax 错误！');

                switch(xhr.status) {
                    case 429:
                        alert(`Submit too often, try ${xhr.getResponseHeader('Retry-After')} seconds later.`);
                        $("#verdict_text").text("Submit Frequency Exceed");
                        $("#verdict_info").removeClass();
                        $("#verdict_info").addClass("wemd-black-text");
                        break;
                    case 422:
                        alert(xhr.responseJSON.errors[Object.keys(xhr.responseJSON.errors)[0]][0], xhr.responseJSON.message);
                        break;
                    default:
                        alert("有点不对劲儿","糟糕！");
                }

                generate_processing = false;
            }
        });
    }
</script>
@endif

@endsection
