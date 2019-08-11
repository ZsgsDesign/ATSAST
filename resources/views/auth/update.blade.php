@extends('layouts.app')

@section('template')

<style>
    .form-control:focus,
    .form-control:hover {
        border-bottom-width: 2px;
    }

    form .form-group:last-of-type {
        margin-bottom: 0;
    }

    .alert>p {
        margin-bottom: 0;
    }

    .card {
        margin-bottom: 20vh;
        overflow: hidden;
        display: block;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 30px;
        border-radius: 4px;
        transition: .2s ease-out .0s;
        color: #7a8e97;
        background: #fff;
        position: relative;
        border: 1px solid rgba(0, 0, 0, 0.15);
    }

    .card .card-header {
        padding: 0;
    }

    .card .card-header>ul {
        margin: 0;
    }

    .card .card-header>ul .nav-link {
        padding: 1rem;
        border: none!important;
    }

    .card .card-header .nav-tabs .nav-link.active {
        color: #ff4081;
    }

    .nav-tabs-material .nav-tabs-indicator {
        background-color: #ff4081;
        bottom: -1px;
        display: block;
        width: 50%;
        height: .15rem;
        position: absolute;
        transition: .2s ease-out .0s;
    }

    #accountTab {
        position: relative;
    }

    .card-footer {
        border: none;
    }

    .checkbox {
        margin-top: 1rem;
    }

    form {
        margin-bottom: 0;
    }

    input {
        box-shadow: none!important;
    }

    .was-validated input[type="checkbox"].form-control:invalid+span+span {
        color: #f44336!important;
    }

    label[for="agreement"] {
        display: inline-block;
    }

    .card-bottom{
        background-color:rgb(244,244,244);
        padding:10px;
    }

    .socialite-section a{
        color: inherit;
    }
</style>
<div class="container mundb-standard-container">
    <div class="row justify-content-sm-center">
        <div class="col-sm-12 col-md-8 col-lg-6">
            <div class="text-center" style="margin-top:10vh;margin-bottom:20px;">
                <h1 style="padding:20px;display:inline-block;">@SAST</h1>
                <p>Auxiliary Teaching for SAST</p>
            </div>
            <div class="alert alert-primary text-left" role="alert">
                在ATSAST的v2.0.0更新中，我们重构了整个后台框架，其中也包括了加密算法。为了保障您账号的安全，在进一步登录之前，我们希望您能够更新自己的密码。输入的原密码仅为了校验，新密码可以与原密码一致。
            </div>
            <div class="card">
                <div class="tab-content" id="accountTabContent">
                    <div class="tab-pane fade show active" role="tabpanel">
                        <form class="needs-validation" method="post" id="update_form" novalidate>
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="email" class="bmd-label-floating">电子邮箱</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" id="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="bmd-label-floating">原密码</label>
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
                            </div>
                            <div class="card-footer text-right">
                                <a href="{{ route('password.request') }}"><button type="button" class="btn btn-secondary">忘记原密码？</button></a>
                                <button class="btn btn-danger" onclick="updatePassword()">更新</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    window.addEventListener("load",function() {
        $('input:-webkit-autofill').each(function(){
            if ($(this).val().length !== "") {
                console.log($(this).siblings('label'));
                $(this).siblings('label').addClass('active');
                $(this).parent().addClass('is-filled');
            }
        });
    }, false);

    let ajaxing = false;
    function updatePassword() {
        if(ajaxing)return;
        ajaxing=true;
        $.ajax({
            type: 'POST',
            url: '/ajax/account/updatePassword',
            data: {
                email: email,
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
                    location.href="/login";
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
                console.log('Ajax error while posting to passwordUpdate!');
                ajaxing=false;
            }
        });
    }
</script>

@endsection
