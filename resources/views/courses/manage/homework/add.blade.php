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

    instructor>img {
        width: 5rem;
        height: 5rem;
        border-radius: 2000px;
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

    syllabus i{
        font-size: 2rem;
        vertical-align: middle;
        color: #8a6219;
        font-weight: 100;
    }

    .atsast-action{
        margin-top:1rem;
        text-align: right;
    }

    .atsast-action small{
        padding-right:1rem;
    }

    [id^="code_submit_section"]{
        transition: .2s ease-out .0s;
        opacity: 0;
    }

    [id^="markdown_container"]{
        transition: .2s ease-out .0s;
        opacity: 0;
    }

    user-card{
        display: flex;
        align-items: center;
        max-width: 100%;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 30px;
        border-radius: 4px;
        transition: .2s ease-out .0s;
        color: #7a8e97;
        background: #fff;
        padding: 1rem;
        position: relative;
        border: 1px solid rgba(0, 0, 0, 0.15);
    }

    user-card a:hover{
        text-decoration: none;
    }

    user-card:hover {
        box-shadow: rgba(0, 0, 0, 0.15) 0px 0px 40px;
    }

    user-card > div:first-of-type{
        display: flex;
        align-items: center;
        padding-right:1rem;
        width:5rem;
        height:5rem;
        flex-shrink: 0;
        flex-grow: 0;
    }

    user-card img{
        display: block;
        width:100%;
    }

    user-card > div:last-of-type{
        flex-shrink: 1;
        flex-grow: 1;
    }

    user-card p{
        margin:0;
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
    }

    instructor>div {
        padding-left: 1rem;
        flex-shrink: 1;
        flex-grow: 1;
    }

    instructor p {
        margin: 0;
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

    #vscode_container{
        opacity: 0;
        transition: .2s ease-out .0s;
    }
    card h2{
        margin-bottom:1.5rem;
    }
    tips{
        display: block;
        font-size: .75rem;
        color: rgba(0,0,0,.26);
        margin-bottom: .5rem;
    }
    [name^="homework_ddl"],
    [name^="homework_support_lang"]{
        height: calc(2.4375rem + 2px);
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
    hr.atsast-divider{
        left: -1rem;
        position: relative;
        width: calc(100% + 2rem);
        box-shadow: rgba(0, 0, 0, 0.75) 0px 0px 30px;
    }
    .atsast-toast {
        margin-bottom:5rem;
    }
    #snackbar-container{
        pointer-events: none;
    }

    #snackbar-container *{
        pointer-events: all;
    }
</style>
<link rel="stylesheet" href="<{$ATSAST_CDN}>/css/github.min.css">
<link rel="stylesheet" data-name="vs/editor/editor.main" href="<{$ATSAST_CDN}>/vscode/vs/editor/editor.main.css">
<div class="atsast-course-header">
    <img src="https://static.1cf.co/img/atsast/bg.jpg" class="atsast-focus-img">
    <div class="container">
        <div class="atsast-course-avatar wemd-<{$result['course_color']}>">
            <i class="devicon-<{$result['course_logo']}>-plain"></i>
        </div>
        <p class="d-none d-lg-block"><{$result['creator_name']}>·<{if $result['course_type']==1}>线上<{else}>线下<{/if}>课程</p>
        <h1 class="d-none d-lg-block"><{$result['course_name']}></h1>
    </div>
</div>
</div>
<div class="container mundb-standard-container">
    <div class="d-block d-lg-none atsast-title">
        <h1><{$result['course_name']}></h1>
        <p><{$result['creator_name']}>·<{if $result['course_type']==1}>线上<{else}>线下<{/if}>课程</p>
    </div>

    <div class="mb-5">
        <card class="mb-3">
            <h5><i class="MDI file-document"></i> 课时详情</h5>
            <div>
                <h2><{$syllabus_info['title']}></h2>
                <p><{$syllabus_info['desc']}></p>
                <p>            <span class="d-block d-lg-inline-block"><i class="MDI clock"></i> <{ $syllabus_info['time'] }></span>
                    <span class="d-block d-lg-inline-block"><i class="MDI near-me"></i> <{ $syllabus_info['location'] }></span></p>
            </div>
            <div class="text-right">
                <button class="btn btn-default" onclick="location.href='<{$ATSAST_DOMAIN}>/course/<{$cid}>/detail'">查看课时详情</button>
                <button type="submit" class="btn btn-outline-primary" onclick="location.href='<{$ATSAST_DOMAIN}>/course/<{$cid}>/manage'">返回管理中心</button>
            </div>
        </card>
        <card class="mb-3">
            <h5><i class="MDI pen"></i> 新建作业内容</h5>


            <div class="mb-4">
                <div class="row">
                    <div class="col-lg-4 col-12">
                        <div class="form-group">
                            <label for="homework_type" class="bmd-label-floating">形式</label>
                            <select class="form-control" id="homework_type" name="homework_type" required>
                                <option value="0">文本内容</option>
                                <option value="1">VSCode代码编辑器</option>
                                <option value="2">可视化Markdown</option>
                                <option value="3">文件提交</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-12">
                        <div class="form-group">
                            <label for="homework_ddl" class="bmd-label-floating">截止日期</label>
                            <input type="text" class="form-control" name="homework_ddl" value="2018-11-07 12:34:56" id="homework_ddl" required>
                        </div>
                    </div>
                    <div class="col-lg-4 col-12">
                        <div class="form-group">
                            <label for="homework_support_lang" class="bmd-label-floating">格式</label>
                            <input type="text" class="form-control" name="homework_support_lang" id="homework_support_lang" required>
                        </div>
                    </div>
                </div>
                <tips>内容</tips>
                <div id="vscode_container">
                    <div id="vscode" style="width:100%;height:30rem;border:1px solid grey"></div>
                </div>
            </div>
            <div class="text-right">
                <button type="submit" class="btn btn-outline-info" onclick="addHomework()">新建作业内容</button>
            </div>
        </card>
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

    var editor,jsCnt=0;

    window.addEventListener("load",function() {
        loadJsAsync("<{$ATSAST_CDN}>/vscode/vs/loader.js");
        $("#homework_type").val("0");
    },false);

    function loadJsAsync(url){
        var body = document.getElementsByTagName('body')[0];
        var jsNode = document.createElement('script');

        jsNode.setAttribute('type', 'text/javascript');
        jsNode.setAttribute('src', url);
        body.appendChild(jsNode);

        jsNode.onload = function() {
            jsCnt++;
            if(jsCnt==1){
                require.config({ paths: { 'vs': '<{$ATSAST_CDN}>/vscode/vs' }});

                // Before loading vs/editor/editor.main, define a global MonacoEnvironment that overwrites
                // the default worker url location (used when creating WebWorkers). The problem here is that
                // HTML5 does not allow cross-domain web workers, so we need to proxy the instantiation of
                // a web worker through a same-domain script

                window.MonacoEnvironment = {
                getWorkerUrl: function(workerId, label) {
                    return `data:text/javascript;charset=utf-8,${encodeURIComponent(`
                    self.MonacoEnvironment = {
                        baseUrl: '<{$ATSAST_CDN}>/vscode/'
                    };
                    importScripts('<{$ATSAST_CDN}>/vscode/vs/base/worker/workerMain.js');`
                    )}`;
                }
                };

                require(["vs/editor/editor.main"], function () {
                    editor = monaco.editor.create(document.getElementById('vscode'), {
                        value: "",
                        language: "markdown"
                    });
                    $("#vscode_container").css("opacity",1);
                });
            }
        }

    }

    function addHomework(){
        editor.updateOptions({ readOnly: true });
        $.post("<{$ATSAST_DOMAIN}>/ajax/addHomework",{
            cid:<{$cid}>,
            syid:<{$syid}>,
            type:$("#homework_type").val(),
            support_lang:$("#homework_support_lang").val(),
            due_submit:$("#homework_ddl").val(),
            homework_content:editor.getValue(),
        },function(result){
            result=JSON.parse(result);
            $.snackbar({content: result.desc,style:"toast text-center atsast-toast"});
            editor.updateOptions({ readOnly: false });
            setTimeout(function(){
                location.href="<{$ATSAST_DOMAIN}>/course/<{$cid}>/edit_homework/<{$syid}>";
            },1000);
        });
    }

    function alert(desc) {
        var title = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : "提示";
        $('#modeal_desc').html(desc);
        $('#modeal_title').html(title);
        $('#modal').modal();
    }
</script>

@endsection
