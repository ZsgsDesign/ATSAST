@extends('layouts.app')

@section('template')

<style>
    .atsast-toast {
        margin-bottom:5rem;
    }
    #snackbar-container{
        pointer-events: none;
    }

    #snackbar-container *{
        pointer-events: all;
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
        cursor: pointer;
    }

    contest-card > .atsast-img-container{
        overflow: hidden;
        width:35rem;
        position: absolute;
        top:-2.5rem;
        right:-2.5rem;
        bottom: -2.5rem;
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
        user-select: none;
    }

    contest-card:hover {
        box-shadow: rgba(0, 0, 0, 0.15) 0px 0px 40px;
    }

    @media (min-width: 992px){
        contest > .atsast-content-container {
            width: calc(100% - 35rem);
        }
    }
</style>
<link rel="stylesheet" href="{{$ATSAST_DOMAIN}}/static/library/simplemde/dist/simplemde.min.css">
<div class="container mundb-standard-container">
    <section class="mb-5">
        <h5>新增</h5>
        <div class="form-group">
            <label for="course_name" class="bmd-label-floating">比赛名称</label>
            <input type="text" class="form-control" name="name" value="" id="name" autocomplete="off" required>
        </div>
        <label style="display: block" for="image">
            <contest-card>
                <div class="d-block d-lg-none atsast-img-container-small">
                    <img src="">
                </div>
                <div class="d-none d-lg-block atsast-img-container">
                    <img src="">
                </div>
                <div class="atsast-content-container">
                    <h3 class="mundb-text-truncate-2">点击选择图片</h3>
                    <p class="mundb-text-truncate-1">组织 ·活动类型</p>
                    <p class="mundb-text-truncate-1"><i class="MDI clock"></i> 活动日期 </p>
                    <a href="#"><button class="btn btn-outline-info" onclick="alert('就算你点了也别想和我发生点什么')">别点我</button></a>
                </div>
            </contest-card>
        </label>
        <input style="display: none" type="file" name="image" id="image">
        <div class="form-group">
            <label for="organization" class="bmd-label-floating">举办单位 (如:校大学生科学与技术协会)</label>
            <input type="text" class="form-control" name="organization" value="" id="organization" autocomplete="off" required>
        </div>
        <div class="row">
            <div class="col col-sm-12 col-md-6">
                <div class="form-group">
                    <label for="start_date" class="bmd-label-floating">举办时间 - 开始 (2019-11-23)</label>
                    <input type="text" class="form-control" name="start_date" value="" id="start_date" required>
                </div>
            </div>
            <div class="col col-sm-12 col-md-6">
                <div class="form-group">
                    <label for="end_date" class="bmd-label-floating">举办时间 - 结束 (2019-11-25)</label>
                    <input type="text" class="form-control" name="end_date" value="" id="end_date" required>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="due_register" class="bmd-label-floating">报名截止时间 (2019-11-22 23:59:59)</label>
            <input type="text" class="form-control" name="due_register" value="" id="due_register" required>
        </div>
        <label for="course_desc" class="bmd-label-floating" style="top: 1rem;left: 0;font-size: .75rem;">比赛简介</label>
        <markdown-editor class="mt-3 mb-3">
            <textarea id="markdown_editor"></textarea>
        </markdown-editor>
        <div class="row">
            <div class="col col-sm-12 col-md-6">
                <div class="form-group">
                    <label for="contest_organization" class="bmd-label-floating">最少参与人数</label>
                    <input type="text" class="form-control" name="minp" value="1" id="minp" required>
                </div>
            </div>
            <div class="col col-sm-12 col-md-6">
                <div class="form-group">
                    <label for="contest_organization" class="bmd-label-floating">最多参与人数</label>
                    <input type="text" class="form-control" name="maxp" value="1" id="maxp" required>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="register_info" class="bmd-label-floating">报名需要提供信息(逗号分隔,*开头必填,学号SID,姓名real_name,手机号phone,QQ号QQ)</label>
            <input type="text" class="form-control" name="register_info" id="register_info" value="*SID,*real_name,*phone" required>
        </div>
        <div class="form-group">
            <label for="tips" class="bmd-label-floating">报名提示(会在提交报名信息前显示)</label>
            <input type="text" class="form-control" name="tips" value="" id="tips" required>
        </div>
        <div class="radio">
            <label>
                <input type="radio" name="contest_type" id="contest_type_1" value="1" checked required>线上活动
            </label>
            </div>
            <div class="radio">
            <label>
                <input type="radio" name="contest_type" id="contest_type_2" value="2" required>线下活动
            </label>
        </div>
        <div class="text-right">
            <button class="btn btn-default">取消</button>
            <button class="btn btn-outline-primary" onclick="addContest()">举办活动</button>
        </div>
    </section>
</div>
<script type="text/javascript" src="{{$ATSAST_DOMAIN}}/static/library/simplemde/dist/simplemde.min.js"></script>
<script type="text/javascript" src="{{$ATSAST_DOMAIN}}/static/library/marked/marked.min.js"></script>
<script type="text/javascript" src="{{$ATSAST_DOMAIN}}/static/library/dompurify/dist/purify.min.js"></script>
<script>
    var simplemde = new SimpleMDE({
        autosave: {
            enabled: true,
            uniqueId: "contest_add_{{Auth::user()->id}}",
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
    var ajaxing = false;
    function addContest(){
        if(ajaxing)  return;
        var image = $('input#image').get(0).files[0];
        if(image == undefined){
            alert('请给活动选择一个好看的图片(x');
            return;
        }
        if(image.size/1024/1024 > 10) {
            alert('上传的图片不能大于10M噢');
            return;
        }
        var data = new FormData();
        data.append('name',$("#name").val());
        data.append('organization_name',$("#organization").val());
        data.append('start_date',$("#start_date").val());
        data.append('end_date',$("#end_date").val());
        data.append('due_register',$("#due_register").val());
        data.append('desc',simplemde.value());
        data.append('image',image);
        data.append('minp',$("#minp").val());
        data.append('maxp',$("#maxp").val());
        data.append('register_info',$("#register_info").val());
        data.append('tips',$("#tips").val());
        data.append('type',$('input[name="contest_type"]:checked').val());
        ajaxing = true;
        $.ajax({
            type: 'POST',
            url: '{{$ATSAST_DOMAIN}}/ajax/contest/add',
            data: data,
            dataType: 'json',
            processData : false,
            contentType : false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, success: function(ret){
                console.log(ret);
                alert(ret.desc);
                if(ret.ret == 200){
                    setTimeout(function(){
                        location.href="{{$ATSAST_DOMAIN}}/contest/"+ret.data;
                    }, 1000);
                }
                ajaxing = false;
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
                console.log('Ajax error while posting to addCourse!');
                ajaxing=false;
            }
        });
    }
    window.addEventListener("load",function() {
        $('input#image').on('change',function(){
            var file = $(this).get(0).files[0];

            var reader = new FileReader();
            reader.onload = function(e){
                $('.atsast-img-container img').attr('src',e.target.result);
                $('.atsast-img-container-small img').attr('src',e.target.result);
                $('h3.mundb-text-truncate-2').text(file.name);
            };
            reader.readAsDataURL(file);
        });
    });

</script>

@endsection
