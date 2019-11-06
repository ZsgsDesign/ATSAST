@extends('layouts.app')

@section('template')

<style>
    nav.navbar, #nav-container{
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
</style>
<div class="atsast-course-header">
    <img src="{{$ATSAST_DOMAIN}}/static/img/bg.jpg" class="atsast-focus-img">
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
            <h5><i class="MDI file-document"></i> 课程详情</h5>
            <div>
                <div class="form-group">
                    <label for="name" class="bmd-label-floating">课程名称</label>
                    <input type="text" class="form-control" name="course_name" id="course_name" value="{{$course->course_name}}" required disabled>
                    <span class="bmd-help">课程名称不应该过长。</span>
                </div>
                <div class="form-group">
                    <label for="organization" class="bmd-label-floating">课程开设单位</label>
                    <input type="text" class="form-control" name="course_organization" id="course_organization" value="{{$course->organization->course_name}}" required disabled>
                </div>
                <div class="form-group">
                    <label for="course_email" class="bmd-label-floating">负责讲师(如有多个用;分隔)</label>
                    <input type="email" class="form-control" name="course_email" value="{{join(';',$course->instructor_emails) }}" id="course_email" required>
                </div>
                <div class="form-group">
                    <label for="major" class="bmd-label-floating">课程主要涉及</label>
                    <select class="form-control" id="course_major" name="course_major" required disabled>
                        <option>amazonwebservices</option>
                        <option>android</option>
                        <option>angularjs</option>
                        <option>apache</option>
                        <option>appcelerator</option>
                        <option>apple</option>
                        <option>atom</option>
                        <option>babel</option>
                        <option>backbonejs</option>
                        <option>behance</option>
                        <option>bitbucket</option>
                        <option>bootstrap</option>
                        <option>bower</option>
                        <option>c</option>
                        <option>cakephp</option>
                        <option>ceylon</option>
                        <option>chrome</option>
                        <option>codeigniter</option>
                        <option>coffeescript</option>
                        <option>confluence</option>
                        <option>couchdb</option>
                        <option>cplusplus</option>
                        <option>csharp</option>
                        <option>css3</option>
                        <option>cucumber</option>
                        <option>d3js</option>
                        <option>debian</option>
                        <option>devicon</option>
                        <option>django</option>
                        <option>docker</option>
                        <option>doctrine</option>
                        <option>dot-net</option>
                        <option>drupal</option>
                        <option>electron</option>
                        <option>elm</option>
                        <option>ember</option>
                        <option>erlang</option>
                        <option>express</option>
                        <option>facebook</option>
                        <option>firefox</option>
                        <option>foundation</option>
                        <option>gatling</option>
                        <option>gimp</option>
                        <option>git</option>
                        <option>github</option>
                        <option>gitlab</option>
                        <option>go</option>
                        <option>google</option>
                        <option>gradle</option>
                        <option>grunt</option>
                        <option>gulp</option>
                        <option>handlebars</option>
                        <option>heroku</option>
                        <option>html5</option>
                        <option>ie10</option>
                        <option>illustrator</option>
                        <option>inkscape</option>
                        <option>intellij</option>
                        <option>ionic</option>
                        <option>jasmine</option>
                        <option>java</option>
                        <option>javascript</option>
                        <option>jeet</option>
                        <option>jetbrains</option>
                        <option>jquery</option>
                        <option>krakenjs</option>
                        <option>laravel</option>
                        <option>less</option>
                        <option>linkedin</option>
                        <option>linux</option>
                        <option>meteor</option>
                        <option>mocha</option>
                        <option>mongodb</option>
                        <option>moodle</option>
                        <option>mysql</option>
                        <option>nginx</option>
                        <option>nodejs</option>
                        <option>nodewebkit</option>
                        <option>npm</option>
                        <option>oracle</option>
                        <option>photoshop</option>
                        <option>php</option>
                        <option>phpstorm</option>
                        <option>postgresql</option>
                        <option>protractor</option>
                        <option>pycharm</option>
                        <option>python</option>
                        <option>rails</option>
                        <option>react</option>
                        <option>redhat</option>
                        <option>redis</option>
                        <option>ruby</option>
                        <option>rubymine</option>
                        <option>safari</option>
                        <option>sass</option>
                        <option>sequelize</option>
                        <option>sketch</option>
                        <option>slack</option>
                        <option>sourcetree</option>
                        <option>ssh</option>
                        <option>stylus</option>
                        <option>swift</option>
                        <option>symfony</option>
                        <option>tomcat</option>
                        <option>travis</option>
                        <option>trello</option>
                        <option>twitter</option>
                        <option>typescript</option>
                        <option>ubuntu</option>
                        <option>vagrant</option>
                        <option>vim</option>
                        <option>visualstudio</option>
                        <option>vuejs</option>
                        <option>webpack</option>
                        <option>webstorm</option>
                        <option>windows8</option>
                        <option>wordpress</option>
                        <option>yarn</option>
                        <option>yii</option>
                        <option>zend</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="course_suitable" class="bmd-label-floating">课程适合人群</label>
                    <input type="text" class="form-control" name="course_suitable" id="course_suitable" value="对于 方向感兴趣，愿意做一些 的新生。" required>
                </div>
                <div class="form-group">
                    <label for="course_color" class="bmd-label-floating">课程颜色</label>
                    <input type="text" class="form-control" name="course_color" id="course_color" value="green wemd-lighten-1" required>
                </div>
                <div class="form-group">
                    <label for="desc" class="bmd-label-floating">课程简介</label>
                    <textarea class="form-control" id="course_desc" name="course_desc" rows="10" required>{{$course->course_desc}}</textarea>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="course_type" value="1" {{$course->course_type == 1 ? 'checked' : ''}} required>线上课程
                    </label>
                    </div>
                    <div class="radio">
                    <label>
                        <input type="radio" name="course_type" value="2" {{$course->course_type == 2 ? 'checked' : ''}} required>线下课程
                    </label>
                </div>
            </div>
            <div class="text-right">
                <button class="btn btn-default" onclick="location.href='{{route('course.manage',['cid'=>$course->cid])}}'">返回管理中心</button>
                <button type="submit" class="btn btn-outline-primary" onclick="update()">更新信息</button>
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
    window.addEventListener("load",function() {
        $("#major").val("{{$course->course_logo}}");
    },false);

    function update(){
        alert('这太复杂了，先不写了呜呜呜');
        return;
        $.ajax({
            type: 'POST',
            url: '/ajax/course/edit',
            data: {
                name:$("#course_name").val(),
                email:$("#course_email").val(),
                organization:$("#course_organization").val(),
                major:$("#course_major").val(),
                desc:$("#course_desc").val(),
                color:$("#course_color").val(),
                suitable:$("#course_suitable").val(),
                type:parseInt($('input[name="course_type"]:checked').val()),
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, success: function(ret){
                console.log(ret);
                alert(ret.desc);
                setTimeout(function(){
                    location.href="{{$ATSAST_DOMAIN}}/course/"+ret.data;
                }, 1000);
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

    function alert(desc) {
        var title = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : "提示";
        $('#modeal_desc').html(desc);
        $('#modeal_title').html(title);
        $('#modal').modal();
    }
</script>

@endsection
