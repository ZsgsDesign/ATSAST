<?php
    $current_hour=date("H");
    if ($current_hour<6) {
        $greeting="凌晨了";
    } elseif ($current_hour<11) {
        $greeting="早上好";
    } elseif ($current_hour<13) {
        $greeting="中午好";
    } elseif ($current_hour<18) {
        $greeting="下午好";
    } elseif ($current_hour<22) {
        $greeting="晚上好";
    } else {
        $greeting="深夜了";
    }
?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Necessarily Declarations -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="alternate icon" type="image/png" href="{{$ATSAST_DOMAIN}}/favicon.png">
    <!-- Loading Style -->
    <style>
        loading>div {
            text-align: center;
        }

        loading p {
            font-weight: 300;
        }

        loading {
            display: flex;
            z-index: 999;
            position: fixed;
            top: 0;
            bottom: 0;
            right: 0;
            left: 0;
            justify-content: center;
            align-items: center;
            background: #f5f5f5;
            transition: .2s ease-out .0s;
            opacity: 1;
        }

        .lds-ellipsis {
            display: inline-block;
            position: relative;
            width: 64px;
            height: 64px;
        }

        .lds-ellipsis div {
            position: absolute;
            top: 27px;
            width: 11px;
            height: 11px;
            border-radius: 50%;
            background: rgba(0, 0, 0, .54);
            animation-timing-function: cubic-bezier(0, 1, 1, 0);
        }

        .lds-ellipsis div:nth-child(1) {
            left: 6px;
            animation: lds-ellipsis1 0.6s infinite;
        }

        .lds-ellipsis div:nth-child(2) {
            left: 6px;
            animation: lds-ellipsis2 0.6s infinite;
        }

        .lds-ellipsis div:nth-child(3) {
            left: 26px;
            animation: lds-ellipsis2 0.6s infinite;
        }

        .lds-ellipsis div:nth-child(4) {
            left: 45px;
            animation: lds-ellipsis3 0.6s infinite;
        }

        @keyframes lds-ellipsis1 {
            0% {
                transform: scale(0);
            }
            100% {
                transform: scale(1);
            }
        }

        @keyframes lds-ellipsis3 {
            0% {
                transform: scale(1);
            }
            100% {
                transform: scale(0);
            }
        }

        @keyframes lds-ellipsis2 {
            0% {
                transform: translate(0, 0);
            }
            100% {
                transform: translate(19px, 0);
            }
        }
    </style>
</head>

<body style="display: flex;flex-direction: column;min-height: 100vh;">
    <!-- Loading -->
    <loading>
        <div>
            <div class="lds-ellipsis">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
            <p>ATSAST疯狂加载中</p>
        </div>
    </loading>
    <!-- Style -->
    <link rel="stylesheet" href="{{$ATSAST_DOMAIN}}/static/fonts/Roboto/roboto.css">
    <link rel="stylesheet" href="{{$ATSAST_DOMAIN}}/static/fonts/Montserrat/montserrat.css">
    <link rel="stylesheet" href="{{$ATSAST_DOMAIN}}/static/library/bootstrap-material-design/dist/css/bootstrap-material-design.min.css">
    <link rel="stylesheet" href="{{$ATSAST_DOMAIN}}/static/css/wemd-color-scheme.css">
    <link rel="stylesheet" href="{{$ATSAST_DOMAIN}}/static/css/main.css?version={{version()}}">
    <link rel="stylesheet" href="{{$ATSAST_DOMAIN}}/static/library/animate.css/animate.min.css">
    <link rel="stylesheet" href="{{$ATSAST_DOMAIN}}/static/fonts/MDI-WXSS/MDI.css">
    <link rel="stylesheet" href="{{$ATSAST_DOMAIN}}/static/fonts/Devicon/devicon.css">
    <!-- Background -->
    <div class="mundb-background-container">
        <img src="">
    </div>
    <div id="nav-container" style="margin-bottom:30px;position:sticky;top:0;z-index:899;flex-shrink: 0;flex-grow: 0;">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="{{$ATSAST_DOMAIN}}/">
                <img src="{{$ATSAST_DOMAIN}}/static/img/icon_white.png" height="30"> AT SAST
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item />">
                        <a class="nav-link" href="{{$ATSAST_DOMAIN}}/">发现</a>
                    </li>
                    <li class="nav-item />">
                        <a class="nav-link" href="{{$ATSAST_DOMAIN}}/course">课程</a>
                    </li>
                    <li class="nav-item />">
                        <a class="nav-link" href="{{$ATSAST_DOMAIN}}/contest">活动</a>
                    </li>
                    <li class="nav-item />">
                        <a class="nav-link" href="{{$ATSAST_DOMAIN}}/pb">PASTEBIN</a>
                    </li>
                    <li class="nav-item />">
                        <a class="nav-link" href="{{$ATSAST_DOMAIN}}/cloud">网盘</a>
                    </li>
                    <li class="nav-item />">
                        <a class="nav-link" href="{{$ATSAST_DOMAIN}}/blog">博客</a>
                    </li>
                    <li class="nav-item />">
                        <a class="nav-link" href="{{$ATSAST_DOMAIN}}/handling">借还</a>
                    </li>
                    <li class="nav-item />">
                        <a class="nav-link" href="{{$ATSAST_DOMAIN}}/finance">报销</a>
                    </li>
                </ul>

                <ul class="navbar-nav mundb-nav-right">
                    <li class="nav-item mundb-no-shrink />">
                        @guest
                            <a class="nav-link" href="{{$ATSAST_DOMAIN}}/login">登录 / 注册</a>
                        @else
                            <li class="nav-item dropdown mundb-btn-ucenter">
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">{{$greeting}}, <span id="nav-username">{{ Auth::user()["name"] }}</span></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <div class="dropdown-header"><img src="{{ $ATSAST_DOMAIN.Auth::user()->avatar }}" class="mundb-avatar" id="atsast_nav_avatar" /><div><h6><span id="nav-dropdown-username">{{ Auth::user()["name"] }}</span><br/><small>{{ Auth::user()->email }}</small></h6></div></div>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{$ATSAST_DOMAIN}}/account/profile"><i class="MDI account-circle"></i> 个人主页</a>
                                    <a class="dropdown-item" href="{{$ATSAST_DOMAIN}}/account/contests"><i class="MDI airballoon"></i> 报名活动</a>
                                    <a class="dropdown-item" href="{{$ATSAST_DOMAIN}}/account/settings"><i class="MDI settings"></i> 更多设置</a>
                                    {{-- @if ($userinfo['access_admin']) --}}
                                    <!--
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{$ATSAST_DOMAIN}}/admin"><i class="MDI view-dashboard"></i> 管理工具</a>
                                    -->
                                    {{-- @endif --}}
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{$ATSAST_DOMAIN}}/system/logs"><i class="MDI update"></i> 版本日志</a>
                                    <a class="dropdown-item" href="{{$ATSAST_DOMAIN}}/system/bugs"><i class="MDI bug"></i> 汇报BUG</a>
                                    <div class="dropdown-divider"></div>
                                    <a  class="dropdown-item text-danger"
                                        href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                        <i class="MDI exit-to-app text-danger"></i> 退出
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            <script>
                            window.addEventListener("load", function () {
                                $('.dropdown-header').click(function (e) {
                                e.stopPropagation();
                                });
                            }, false);
                            </script>
                        @endguest
                    </li>
                </ul>
            </div>
        </nav>
    </div>

    @yield('template')

    @yield('addition')

    <footer class="d-print-none bg-dark center-on-small-only" style="flex-shrink: 0;flex-grow: 0">
        <div class="mundb-footer mundb-copyright">Copyright &copy; Auxiliary Teaching for SAST 2018-{{date('Y')}}, all rights reserved.</div>
    </footer>
    <script src="{{$ATSAST_DOMAIN}}/static/library/jquery/dist/jquery.min.js"></script>
    <script src="{{$ATSAST_DOMAIN}}/static/library/popper.js/dist/umd/popper.min.js"></script>
    <script src="{{$ATSAST_DOMAIN}}/static/library/bootstrap-material-design/dist/js/bootstrap-material-design.min.js"></script>
    @include('layouts.primaryJS')
    @yield('additionJS')
</body>
</html>
