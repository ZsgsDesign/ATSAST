@extends('layouts.app')

@section('template')

<style>
    nav.navbar,#nav-container {
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

    markdown-editor{
        display: block;
    }

    markdown-editor .CodeMirror {
        height: 20rem;
    }

    markdown-editor ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    markdown-editor ::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, 0.2);
    }

    markdown-editor .editor-toolbar.disabled-for-preview a:not(.no-disable){
        opacity: 0.5;
    }
</style>
<link rel="stylesheet" href="/static/library/simplemde/dist/simplemde.min.css">

<div class="atsast-course-header">
    <img src="/static/img/bg.jpg" class="atsast-focus-img">
    <div class="container">
        <div class="atsast-course-avatar wemd-{{$course->course_color}}">
            <i class="devicon-{{$course->course_logo}}-plain"></i>
        </div>
        <p class="d-none d-lg-block">{{$course->organization->name}}·{{$course->course_type == 1 ? '线上' : '线下'}}课程</p>
        <h1 class="d-none d-lg-block">{{$course->course_name}}</h1>
    </div>
</div>
</div>
<div class="container mundb-standard-container">
    <div class="d-block d-lg-none atsast-title">
        <h1>{{$course->course_name}}</h1>
        <p>{{$course->organization->name}}·{{$course->course_type == 1 ? '线上' : '线下'}}课程</p>
    </div>

    <div class="mb-5">
        <card class="mb-3">
            <h5><i class="MDI file-document"></i> 课时详情</h5>
            <div>
                <h2>{{$syllabus->title}}</h2>
                <p>{{$syllabus->desc}}</p>
                <p>
                    <span class="d-block d-lg-inline-block"><i class="MDI clock"></i> {{ $syllabus->time }}</span>
                    <span class="d-block d-lg-inline-block"><i class="MDI near-me"></i> {{ $syllabus->location }}</span>
                </p>
            </div>
            <div class="text-right">
                <button class="btn btn-default" onclick="location.href='{{route('course.detail',['cid' => $course->cid])}}">查看课时详情</button>
                <button type="submit" class="btn btn-outline-primary" onclick="location.href='{{route('course.manage',['cid' => $course->cid])}}'">返回管理中心</button>
            </div>
        </card>
        <card class="mb-3">
            <h5><i class="MDI script"></i> 编辑授课笔记</h5>
            <div>
                <markdown-editor class="mt-3 mb-3">
                    <textarea id="markdown_editor"></textarea>
                </markdown-editor>
                <div class="form-group" style="padding-top: 2.75rem;">
                    <label for="script_status" class="bmd-label-floating">授课笔记功能</label>

                    <div class="radio">
                        <label>
                            <input type="radio" name="script_status" id="script_status_1" value="1" {{$syllabus->script !== '0' ? 'checked' : ''}} required>开启
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="script_status" id="script_status_0" value="0" {{$syllabus->script === '0' ? 'checked' : ''}} required>关闭
                        </label>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <button class="btn btn-default" onclick="location.reload()">放弃更改</button>
                <button type="submit" class="btn btn-outline-primary" onclick="updateScript()">更新</button>
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

<script type="text/javascript" src="/static/library/simplemde/dist/simplemde.min.js"></script>
<script type="text/javascript" src="/static/library/marked/marked.min.js"></script>
<script type="text/javascript" src="/static/library/dompurify/dist/purify.min.js"></script>
<script>
    var simplemde = new SimpleMDE({
        autosave: {
            enabled: true,
            uniqueId: "script_edit_{{$syllabus->syid}}",
            delay: 1000,
        },
        element: document.querySelector('#markdown_editor'),
        hideIcons: ["guide", "heading","side-by-side","fullscreen"],
        spellChecker: false,
        tabSize: 4,
        renderingConfig: {
            codeSyntaxHighlighting: true
        },
        previewRender: function (plainText) {
            return marked(plainText, {
                sanitize: true,
                sanitizer: DOMPurify.sanitize,
                highlight: function (code) {
                    return hljs.highlightAuto(code).value;
                }
            });
        },
        status:false,
        toolbar: [{
                name: "bold",
                action: SimpleMDE.toggleBold,
                className: "MDI format-bold",
                title: "Bold",
            },
            {
                name: "italic",
                action: SimpleMDE.toggleItalic,
                className: "MDI format-italic",
                title: "Italic",
            },
            "|",
            {
                name: "quote",
                action: SimpleMDE.toggleBlockquote,
                className: "MDI format-quote",
                title: "Quote",
            },
            {
                name: "unordered-list",
                action: SimpleMDE.toggleUnorderedList,
                className: "MDI format-list-bulleted",
                title: "Generic List",
            },
            {
                name: "ordered-list",
                action: SimpleMDE.toggleOrderedList,
                className: "MDI format-list-numbers",
                title: "Numbered List",
            },
            "|",
            {
                name: "code",
                action: SimpleMDE.toggleCodeBlock,
                className: "MDI code-tags",
                title: "Create Code",
            },
            {
                name: "link",
                action: SimpleMDE.drawLink,
                className: "MDI link-variant",
                title: "Insert Link",
            },
            {
                name: "image",
                action: SimpleMDE.drawImage,
                className: "MDI image-area",
                title: "Insert Image",
            },
            "|",
            {
                name: "preview",
                action: SimpleMDE.togglePreview,
                className: "MDI eye no-disable",
                title: "Toggle Preview",
            },
        ],
    });

    function updateScript(){
        $.ajax({
            type: 'POST',
            url: '/ajax/course/editScript',
            data: {
                cid: {{$course->cid}},
                syid:{{$syllabus->syid}},
                script_status:parseInt($('input[name="script_status"]:checked').val()),
                script:simplemde.value()
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, success: function(ret){
                alert(ret.desc);
            }
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
