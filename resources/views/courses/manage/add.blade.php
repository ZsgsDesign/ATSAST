@extends('layouts.app')

@section('template')

<style>

</style>
<div class="container mundb-standard-container">
    <section class="mb-5">
        <h5>新增</h5>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12"></div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <a class="attsast-course">
                    <div class="btn card text-white wemd-red mb-3 text-center">
                        <div class="card-body">
                            <i class="devicon-amazonwebservices-plain"></i>
                            <h5 class="card-title mundb-text-truncate-1">课程名</h5>
                            <p class="card-text mundb-text-truncate-1">课程描述</p>
                        </div>
                    </div>
                </a>
                <div class="text-muted text-center">
                    <small>样式预览</small>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12"></div>
        </div>
        <div id="logo-row" class="row">
            <div class="col col-sm-12 col-md-4">
                <div class="form-group">
                    <label for="logo-class" class="bmd-label-floating">课程logo(使用devicon图标库/MDI图标库/三个以内字母)</label>
                    <select class="form-control" id="logo-class" required>
                        <option for="devicon-choose" selected>devicon</option>
                        <option for="MDI-choose">MDI</option>
                        <option for="letter-choose">英文字母(十分不推荐)</option>
                    </select>
                </div>
            </div>
            <div class="col col-sm-12 col-md-8">
                <div id="devicon-choose">
                    <div class="form-group">
                        <label for="devicon-select" class="bmd-label-floating">选择一个即可</label>
                        <select class="form-control" id="devicon-select" required>
                            <option selected>amazonwebservices</option>
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
                </div>
                <div id="MDI-choose" style="display:none">
                    <div class="form-group">
                        <label for="MDI-input" class="bmd-label-floating">由于太多了请直接输入MDI图标的名字,例如 owl</label>
                        <input type="text" class="form-control" id="MDI-input" value="owl" required>
                    </div>
                </div>
                <div id="letter-choose" style="display:none">
                    <div class="form-group">
                        <label for="letter-input" class="bmd-label-floating">不要超过三个哦</label>
                        <input type="text" class="form-control" id="letter-input" maxlength="3" value="AAA" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="course_color" class="bmd-label-floating">课程颜色(建议使用深色)(使用wemd颜色)</label>
            <div class="row" id="color-choose">
                <div class="col col-sm-12 col-md-6">
                    <select class="form-control" id="course_color"required>
                            <option checked>red</option>
                            <option>materialize-red</option>
                            <option>pink</option>
                            <option>purple</option>
                            <option>deep-purple</option>
                            <option>indigo</option>
                            <option>blue</option>
                            <option>light-blue</option>
                            <option>cyan</option>
                            <option>teal</option>
                            <option>green</option>
                            <option>light-green</option>
                            <option>lime</option>
                            <option>yellow</option>
                            <option>amber</option>
                            <option>orange</option>
                            <option>deep-orange</option>
                            <option>brown</option>
                            <option>blue-grey</option>
                            <option>grey</option>
                    </select>
                </div>
                <div class="col col-sm-12 col-md-6">
                    <select class="form-control" id="course_color_deputy"required>
                            <option checked>standard</option>
                            <option>lighten-5</option>
                            <option>lighten-4</option>
                            <option>lighten-3</option>
                            <option>lighten-2</option>
                            <option>lighten-1</option>
                            <option>darken-1</option>
                            <option>darken-2</option>
                            <option>darken-3</option>
                            <option>darken-4</option>
                            <option>accent-1</option>
                            <option>accent-2</option>
                            <option>accent-3</option>
                            <option>accent-4</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="course_name" class="bmd-label-floating">课程名称(后端组 2019-2020)</label>
            <input type="text" class="form-control" name="course_name" value="" id="course_name" required>
        </div>
        <div class="form-group">
            <label for="course_desc" class="bmd-label-floating">课程简介</label>
            <textarea class="form-control" id="course_desc" name="course_desc" rows="10" required></textarea>
        </div>
        <div class="form-group">
            <label for="course_organization" class="bmd-label-floating">课程主开设单位(组织全名如:大学生科学技术协会)</label>
            <input type="text" class="form-control" name="course_organization" value="" id="course_organization" required>
        </div>
        <div class="form-group">
            <label for="course_email" class="bmd-label-floating">负责讲师(填写讲师的邮箱,必须在ATSAST注册账号,多个讲师以;分隔)</label>
            <input type="email" class="form-control" name="course_email" value="" id="course_email" required>
        </div>
        <div class="form-group">
            <label for="course_suitable" class="bmd-label-floating">课程适合人群</label>
            <input type="text" class="form-control" name="course_suitable" id="course_suitable" value="" required>
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
    window.addEventListener('load',function(){
        var color_basic_class = "btn card text-white mb-3 text-center";
        var icon_basic_class = "";
        $('#color-choose select').on('change',function(){
            let main_color_class = 'wemd-' + $('#color-choose div:first-of-type option:selected').text();
            let deputy_color_class = ' wemd-' +$('#color-choose div:last-of-type option:selected').text();
            if(deputy_color_class == ' wemd-standard') deputy_color_class = '';
            $('a.attsast-course > div').attr('class',color_basic_class + ' ' + main_color_class + deputy_color_class);
        });
        $('div.row#logo-row > div:first-of-type select').on('change',function(){
            let logo_type = $(this).children('option:selected').attr('for');
            $('div.row#logo-row > div:last-of-type > div').hide();
            $(`div.row#logo-row > div:last-of-type > div#${logo_type}`).show();
        });
        $('#devicon-select').on('change',function(){
            let chosen = $(this).children('option:selected').text();
            $('a.attsast-course i').attr('class',`devicon-${chosen}-plain`);
            $('a.attsast-course i').text('');
        });
        $('#MDI-input').on('input',function(){
            let content = $(this).val();
            $('a.attsast-course i').attr('class',`MDI ${content}`);
            $('a.attsast-course i').text('');
        });
        $('#letter-input').on('input',function(){
            let content = $(this).val();
            $('a.attsast-course i').attr('class',``);
            $('a.attsast-course i').text(content);
        });
        $('#course_name').on('input',function(){
            let content = $(this).val();
            $('a.attsast-course h5.card-title').text(content == '' ? '课程名' : content);
        });
        $('#course_desc').on('input',function(){
            let content = $(this).val();
            $('a.attsast-course p.card-text').text(content == '' ? '课程描述' : content);
        })
    });
    function addCourse(){
        if(!$("#necessary")[0].checked){
            alert('请勾选 符合课程开设相关必要因素');
            return;
        }
        //color
        let main_color_class = 'wemd-' + $('#color-choose div:first-of-type option:selected').text();
        let deputy_color_class = ' wemd-' +$('#color-choose div:last-of-type option:selected').text();
        if(deputy_color_class == ' wemd-standard') deputy_color_class = '';
        var color = main_color_class + deputy_color_class;
        //logo
        let logo_type = $('div.row#logo-row > div:first-of-type select option:selected').attr('for');
        if(logo_type == 'devicon-choose') {
            var logo = 'devicon-' +$(`div.row#logo-row > div:last-of-type > div#${logo_type} select option:selected`).text() + '-plain';
        }else if(logo_type == 'MDI-choose'){
            var logo = 'MDI ' + $(`div.row#logo-row > div:last-of-type > div#${logo_type} input`).val();
        }else {
            var logo = $(`div.row#logo-row > div:last-of-type > div#${logo_type} input`).val();
        }
        console.log(color + ' | ' + logo);
        $.ajax({
            type: 'POST',
            url: '{{$ATSAST_DOMAIN}}/ajax/course/addCourse',
            data: {
                name:$("#course_name").val(),
                email:$("#course_email").val(),
                organization_name:$("#course_organization").val(),
                desc:$("#course_desc").val(),
                logo:logo,
                color:color,
                suitable:$("#course_suitable").val(),
                type:parseInt($('input[name="course_type"]:checked').val()),
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, success: function(ret){
                console.log(ret);
                alert(ret.desc);
                if(ret.ret == 200){
                    setTimeout(function(){
                        location.href="{{$ATSAST_DOMAIN}}/course/"+ret.data;
                    }, 1000);
                }
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
