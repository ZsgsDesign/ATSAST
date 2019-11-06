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
    .atsast-img-container{
        width: 100%;
        padding:2rem;
    }
    .atsast-img-container > img{
        width: 100%;
    }
    .atsast-upload{
        display: none;
    }

    #avatar{
        box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 30px;
        border-radius: 4px;
    }

    notify{
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

    notify > .atsast-img-container{
        overflow: hidden;
        width:35rem;
        position: absolute;
        top:-2.5rem;
        right:-2.5rem;
        bottom: -2.5rem;
        z-index: -1;
    }

    notify > .atsast-img-container-small{
        width:100%;
        height:15rem;
    }

    notify > .atsast-img-container-small > img{
        height:100%;
        width:100%;
        object-fit: cover;
    }


    notify > .atsast-img-container::after{
        content: "";
        display: block;
        position: absolute;
        z-index: 1;
        top:-2.5rem;
        left:-2.5rem;
        bottom:-2.5rem;
        right:-1px;
        background:linear-gradient(to right,rgba(255,255,255,1) 15%,rgba(255,255,255,0) 100%);
    }

    notify > .atsast-content-container{
        /* display: flex;
        align-items: center; */
        height:100%;
        flex-shrink: 1;
        flex-grow: 1;
        padding:1rem;
        z-index: 1;
    }

    notify > .atsast-img-container > img{
        height:100%;
        width:100%;
        object-fit: cover;
        user-select: none;
    }

    notify:hover {
        box-shadow: rgba(0, 0, 0, 0.15) 0px 0px 40px;
    }

    @media (min-width: 992px){
        notify > .atsast-content-container {
            width: calc(100% - 35rem);
        }
    }

</style>

<div class="container mundb-standard-container">
    <h1 class="mb-3"><i class="MDI settings"></i> 设置</h1>
    <hr class="atsast-line mb-5">
    <notify>
        <div class="d-block d-lg-none atsast-img-container-small">
            <img src="{{$ATSAST_DOMAIN}}/static/img/atsast/encryption.jpg">
        </div>
        <div class="d-none d-lg-block atsast-img-container">
            <img src="{{$ATSAST_DOMAIN}}/static/img/atsast/encryption.jpg">
        </div>
        <div class="atsast-content-container">
            <h5><i class="MDI email-secure"></i> 激活邮箱</h5>
            @if($detail->verify_status)
            <p class="notify-text">您的邮箱 {{$detail->email}} 已经被确认，在您的账号出现安全问题时您的邮箱将会提供额外支持。</p>
            <p class="mundb-text-truncate-1 wemd-green-text"><i class="MDI lock"></i> 已确认邮箱</p>
            @else
            <p class="notify-text">一封激活邮件已经发送到了您的邮箱 {{$detail->email}} ，请尽快确认，这对您的账号安全至关重要。</p>
            <p class="mundb-text-truncate-1 wemd-red-text"><i class="MDI lock-open"></i> 尚未确认邮箱</p>
            <button class="btn btn-outline-primary" onclick="sendActivateEmail()">再次发送</button>
            @endif
        </div>
    </notify>
    <card class="mb-5" id="user-info">
        <h5><i class="MDI account-circle"></i> 用户信息</h5>
        <div class="row">
            <div class="col-md-4 col-sm-12" style="text-align: center">
                <label for="image" style="cursor: pointer">
                    <div class="atsast-img-container">
                        <img id="avatar" src="{{$ATSAST_DOMAIN.$detail->avatar}}">
                    </div>
                    <small>点击选择或直接拖入图片</small>
                </label>
                <input type="file" id="image" name="image" style="display: none" onchange="selectImg(this.files[0])" accept="image/png,image/jpeg"/>
            </div>
            <div class="col-md-8 col-sm-12">
                <div class="form-group">
                    <label for="name" class="bmd-label-floating">用户名</label>
                    <input type="text" class="form-control" name="name" value="{{$detail->name}}" id="name" required>
                </div>
                <div class="form-group">
                    <label for="real_name" class="bmd-label-floating">真实姓名</label>
                    <input type="text" class="form-control" name="real_name" value="{{$detail->real_name}}" id="real_name" required>
                </div>
                <div class="form-group">
                    <label for="email" class="bmd-label-floating">邮箱</label>
                    <input type="email" class="form-control" name="email" value="{{$detail->email}}" id="email" disabled>
                </div>
                <div class="form-group">
                    <label for="SID" class="bmd-label-floating">学号</label>
                    <input type="text" class="form-control" name="SID" value="{{$detail->SID}}" id="SID" disabled>
                </div>
                <div class="form-group" style="padding-top: 2.75rem;">
                    <label for="gender" class="bmd-label-floating">性别</label>

                    <div class="radio">
                        <label>
                            <input type="radio" name="gender" id="gender_0" value="0" @if($detail->gender==0)checked
                            @endif required>保密
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="gender" id="gender_1" value="1" @if($detail->gender==1)checked
                            @endif required>男
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="gender" id="gender_2" value="2" @if($detail->gender==2)checked
                            @endif required>女
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="title" class="bmd-label-floating">认证</label>
                    <input type="text" class="form-control" value="{{$detail->title}}" name="title" id="title" disabled>
                </div>
            </div>
        </div>

        <div class="text-right">
            <button class="btn btn-default" onclick="location.reload()">放弃更改</button>
            <button type="submit" class="btn btn-outline-primary" onclick="updateInfo()">更新</button>
        </div>
    </card>
    <card class="mb-5" id="user-info">
        <h5><i class="MDI key-variant"></i> 修改密码</h5>

        <div class="form-group">
            <label for="password" class="bmd-label-floating">当前密码</label>
            <input type="password" name="old_password" class="form-control" id="old_password" required>
        </div>
        <div class="form-group">
            <label for="password" class="bmd-label-floating">新密码</label>
            <input type="password" name="new_password" class="form-control" id="new_password" required>
        </div>
        <div class="form-group">
            <label for="password" class="bmd-label-floating">验证密码</label>
            <input type="password" name="confirm_password" class="form-control" id="confirm_password" required>
        </div>

        <div class="text-right">
            <button class="btn btn-default" onclick="location.reload()">放弃更改</button>
            <button type="submit" class="btn btn-outline-warning" onclick="changePassword()">修改密码</button>
        </div>
    </card>
    <card class="mb-5" id="cover-image">
        <h5><i class="MDI image-filter-hdr"></i> 封面图设置</h5>
        <div class="text-right">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <card class="img-card @if($detail->album=='bing')album-selected @endif" data-album="bing" onclick="changeAlbum(this)">
                        <img src="{{$ATSAST_DOMAIN}}/static/img/bing.png">
                        <div>必应&trade;精选美图</div>
                    </card>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <card class="img-card @if($detail->album=='njupt')album-selected @endif" data-album="njupt" onclick="changeAlbum(this)">
                        <img src="{{$ATSAST_DOMAIN}}/static/img/njupt.jpg">
                        <div>南邮印象</div>
                    </card>
                </div>
            </div>
            <button class="btn btn-default" onclick="location.reload()">放弃更改</button>
            <button type="submit" class="btn btn-outline-info" onclick="applyAlbum()">应用</button>
        </div>
    </card>
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

    var usage=[];

    window.addEventListener("load",function() {
        window.addEventListener('dragover',(e) => {
            e.preventDefault();
        },false);
        window.addEventListener('drop',(e) => {
            e.preventDefault();
            selectImg(e.dataTransfer.files[0]);
        },false);
    });

    var album="{{$detail->album}}";

    function changeAlbum(ele) {
        album = $(ele).attr("data-album");
        $(".album-selected").removeClass("album-selected");
        $(ele).addClass("album-selected");
    }

    var pic;
    //image preview
    function selectImg(file){
        pic = file;
        var filename = pic.name;
        if(pic.type != 'image/png' && pic.type != 'image/jpeg'){
            $('label[for="image"] small').text('只允许上传jpg和png类型的图片文件');
            $('label[for="image"] small').removeClass('text-success').addClass('text-danger');
        }else{
            $('label[for="image"] small').text(filename);
            $('label[for="image"] small').removeClass('text-danger').addClass('text-success');
            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => {
                $('label[for="image"] img').attr('src',reader.result).slideDown();
            }
        }
    }

    function updateInfo(){
        var data = new FormData();
        var name = $('#name').val();
        var real_name = $('#real_name').val();
        data.set('gender',$('input[name="gender"]:checked').val());
        data.set('name',$('#name').val());
        data.set('real_name',$('#real_name').val());
        data.set('avatar',pic);
        if(!name) return alert("请填写用户名");
        else if(!real_name) return alert("请填写真实姓名");
        else {
            $.ajax({
                type: 'POST',
                url: '{{$ATSAST_DOMAIN}}/ajax/account/updateInfo',
                data: data,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }, success: function(ret){
                    alert("提交成功");
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
                    console.log('Ajax error while posting to updateInfo!');
                }
            });
        }
    }

    // function sendActivateEmail(){
    //     if(!usage.sendActivateEmail)usage.sendActivateEmail=true;
    //     else return;
    //     $.post("/account/ajax/sendActivateEmail",{
    //     },function(result){
    //         result=JSON.parse(result);
    //         alert(result.desc);
    //         usage.sendActivateEmail=false;
    //     });
    // }

    function changePassword() {
        var old_password = $('#old_password').val();
        var new_password = $('#new_password').val();
        var confirm_password = $('#confirm_password').val();
        $.ajax({
            type: 'POST',
            url: '{{$ATSAST_DOMAIN}}/ajax/account/changePassword',
            data: {
                old_password: old_password,
                new_password: new_password,
                confirm_password: confirm_password,
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, success: function(ret){
                console.log(ret);
                if (ret.ret==200) {
                    alert("修改成功！");
                } else {
                    alert(ret.desc);
                }
                ajaxing=false;
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
                console.log('Ajax error while posting to changePassword!');
                ajaxing=false;
            }
        });
    }

    function getObjectURL(file) {
        var url = '';
        if (window.createObjectURL != undefined) {
            url = window.createObjectURL(file);
        } else if (window.URL != undefined) {
            url = window.URL.createObjectURL(file);
        } else if (window.webkitURL != undefined) {
            url = window.webkitURL.createObjectURL(file);
        }
        return url;
    }

    function applyAlbum(){
        $.ajax({
            type: 'POST',
            url: '{{$ATSAST_DOMAIN}}/ajax/account/applyAlbum',
            data: {
                album:album
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, success: function(ret){
                alert("修改成功！");
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
                console.log('Ajax error while posting to applyAlbum!');
            }
        });
    }
</script>

@endsection
