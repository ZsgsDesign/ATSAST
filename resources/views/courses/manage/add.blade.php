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
</style>
<div class="container mundb-standard-container">
    <section class="mb-5">
        <h5>新增</h5>
        <div class="form-group">
            <label for="course_name" class="bmd-label-floating">课程名称</label>
            <input type="text" class="form-control" name="course_name" value=" 组2019-2020" id="course_name" required>
            <span class="bmd-help">课程名称不应该过长。</span>
        </div>
        <div class="form-group">
            <label for="course_organization" class="bmd-label-floating">课程开设单位</label>
            <input type="text" class="form-control" name="course_organization" value="校大学生科学与技术协会" id="course_organization" required>
        </div>
        <div class="form-group">
            <label for="course_email" class="bmd-label-floating">负责讲师</label>
            <input type="email" class="form-control" name="course_email" value="@njupt.edu.cn" id="course_email" required>
        </div>
        <div class="form-group">
            <label for="course_major" class="bmd-label-floating">课程主要涉及</label>
            <select class="form-control" id="course_major" name="course_major" required>
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
            <label for="course_desc" class="bmd-label-floating">课程简介</label>
            <textarea class="form-control" id="course_desc" name="course_desc" rows="10" required>校科协 组2019年至2020年授课，着重使用 进行教学，教授 基础知识。</textarea>
        </div>
        <div class="radio">
            <label>
                <input type="radio" name="course_type" id="course_type_1" value="1" checked required>线上课程
            </label>
            </div>
            <div class="radio">
            <label>
                <input type="radio" name="course_type" id="course_type_2" value="2" required>线下课程
            </label>
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox" id="necessary" required> 符合课程开设相关必要因素
            </label>
        </div>
        <div class="text-right">
            <button class="btn btn-default">取消</button>
            <button class="btn btn-outline-primary" onclick="addCourse()">开设课程</button>
        </div>
    </section>
</div>
<script>
    function addCourse(){
        if(!$("#necessary")[0].checked){
            return $.snackbar({content: "请勾选 符合课程开设相关必要因素 ",style:"toast text-center atsast-toast"});
        }
        $.ajax({
            type: 'POST',
            url: '{{$ATSAST_DOMAIN}}/ajax/course/addCourse',
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
</script>

@endsection
