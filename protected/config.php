<?php

date_default_timezone_set('PRC');
require_once('model/CONFIG.php');

$config = array(
    'rewrite' => array(
        'admin/'                                             => 'admin/index',
        'admin/<a>'                                          => 'admin/<a>',
        'system/<a>'                                         => 'system/<a>',
        'account/register'                                   => 'account/index',
        'account/login'                                      => 'account/index',
        'account/<a>'                                        => 'account/<a>',
        'account/'                                           => 'account/index',
        'contest/<contest_id>/<a>/'                          => 'contest/<a>',
        'contest/<contest_id>/<a>'                           => 'contest/<a>',
        'contest/<contest_id>/'                              => 'contest/index',
        'contest/<contest_id>'                               => 'contest/index',
        'course/<cid>/view_homework/<syid>/details/<uid>'    => 'course/view_homework_details',
        'course/<cid>/view_homework/<syid>'                  => 'course/view_homework',
        'course/<cid>/sign/<syid>'                           => 'course/sign',
        'course/<cid>/feedback/<syid>'                       => 'course/feedback',
        'course/<cid>/homework/<syid>'                       => 'course/homework',
        'course/<cid>/script/<syid>'                         => 'course/script',
        'course/<cid>/<a>/'                                  => 'course/<a>',
        'course/<cid>/<a>'                                   => 'course/<a>',
        'course/<cid>/'                                      => 'course/index',
        'course/<cid>'                                       => 'course/index',
        'user/<uid>'                                         => 'user/info',
        'api/<a>'                                            => 'api/<a>',
        'ajax/<a>'                                           => 'ajax/<a>',
        'terms/<a>'                                          => 'terms/<a>',
        '<a>'                                                => 'main/<a>',
        '/'                                                  => 'main/index',
    ),
);

$domain = array(
    "127.0.0.1" => array( // 调试配置
        'debug' => 1,
        'mysql' => array(
            'MYSQL_HOST' => CONFIG::GET('ATSAST_DEBUG_MYSQL_HOST'),
            'MYSQL_PORT' => CONFIG::GET('ATSAST_DEBUG_MYSQL_PORT'),
            'MYSQL_USER' => CONFIG::GET('ATSAST_DEBUG_MYSQL_USER'),
            'MYSQL_DB'   => CONFIG::GET('ATSAST_DEBUG_MYSQL_DATABASE'),
            'MYSQL_PASS' => CONFIG::GET('ATSAST_DEBUG_MYSQL_PASSWORD'),
            'MYSQL_CHARSET' => 'utf8',
        ),
    ),
    "atsast.com" => array( //本地域名映射配置
        'debug' => 1,
        'mysql' => array(
            'MYSQL_HOST' => CONFIG::GET('ATSAST_DEBUG_MYSQL_HOST'),
            'MYSQL_PORT' => CONFIG::GET('ATSAST_DEBUG_MYSQL_PORT'),
            'MYSQL_USER' => CONFIG::GET('ATSAST_DEBUG_MYSQL_USER'),
            'MYSQL_DB'   => CONFIG::GET('ATSAST_DEBUG_MYSQL_DATABASE'),
            'MYSQL_PASS' => CONFIG::GET('ATSAST_DEBUG_MYSQL_PASSWORD'),
            'MYSQL_CHARSET' => 'utf8',
        ),
    ),
    "www.atsast.com" => array( //本地域名映射配置
        'debug' => 1,
        'mysql' => array(
            'MYSQL_HOST' => CONFIG::GET('ATSAST_DEBUG_MYSQL_HOST'),
            'MYSQL_PORT' => CONFIG::GET('ATSAST_DEBUG_MYSQL_PORT'),
            'MYSQL_USER' => CONFIG::GET('ATSAST_DEBUG_MYSQL_USER'),
            'MYSQL_DB'   => CONFIG::GET('ATSAST_DEBUG_MYSQL_DATABASE'),
            'MYSQL_PASS' => CONFIG::GET('ATSAST_DEBUG_MYSQL_PASSWORD'),
            'MYSQL_CHARSET' => 'utf8',
        ),
    ),
    "mundb.xyz" => array( //生产环境配置
        'debug' => 0,
        'mysql' => array(
            'MYSQL_HOST' => CONFIG::GET('ATSAST_MYSQL_HOST'),
            'MYSQL_PORT' => CONFIG::GET('ATSAST_MYSQL_PORT'),
            'MYSQL_USER' => CONFIG::GET('ATSAST_MYSQL_USER'),
            'MYSQL_DB'   => CONFIG::GET('ATSAST_MYSQL_DATABASE'),
            'MYSQL_PASS' => CONFIG::GET('ATSAST_MYSQL_PASSWORD'),
            'MYSQL_CHARSET' => 'utf8',
        ),
    ),
    "www.mundb.xyz" => array( //生产环境配置
        'debug' => 0,
        'mysql' => array(
            'MYSQL_HOST' => CONFIG::GET('ATSAST_MYSQL_HOST'),
            'MYSQL_PORT' => CONFIG::GET('ATSAST_MYSQL_PORT'),
            'MYSQL_USER' => CONFIG::GET('ATSAST_MYSQL_USER'),
            'MYSQL_DB'   => CONFIG::GET('ATSAST_MYSQL_DATABASE'),
            'MYSQL_PASS' => CONFIG::GET('ATSAST_MYSQL_PASSWORD'),
            'MYSQL_CHARSET' => 'utf8',
        ),
    ),
);
// 为了避免开始使用时会不正确配置域名导致程序错误，加入判断
if(empty($domain[$_SERVER["HTTP_HOST"]])) die("配置域名不正确，请确认".$_SERVER["HTTP_HOST"]."的配置是否存在！");

return $domain[$_SERVER["HTTP_HOST"]] + $config;