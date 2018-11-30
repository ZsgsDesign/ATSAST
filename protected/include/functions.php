<?php
function getIP()
{
    if (@$_SERVER["HTTP_X_FORWARDED_FOR"]) {
        $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    } elseif (@$_SERVER["HTTP_CLIENT_IP"]) {
        $ip = $_SERVER["HTTP_CLIENT_IP"];
    } elseif (@$_SERVER["REMOTE_ADDR"]) {
        $ip = $_SERVER["REMOTE_ADDR"];
    } elseif (@getenv("HTTP_X_FORWARDED_FOR")) {
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    } elseif (@getenv("HTTP_CLIENT_IP")) {
        $ip = getenv("HTTP_CLIENT_IP");
    } elseif (@getenv("REMOTE_ADDR")) {
        $ip = getenv("REMOTE_ADDR");
    } else {
        $ip = "Unknown";
    }
    return $ip;
}

function weixinapp()
{
    return;
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') === false) {
        exit("请用微信浏览器打开");
    }
}

function is_login()
{
    $is_login=1;
    if ($OPENID=arg("OPENID")) {
        $_SESSION['loginid']=$OPENID;
        $is_login=validateOPENID($OPENID, "app");
    } elseif (!@$_SESSION['OPENID']) {
        $is_login=0;
    } else {
        $is_login=validateOPENID($_SESSION['OPENID'], "browser");
    }
    return $is_login;
}

function validateapi($time='', $secret='')
{
    $task=arg("a");
    if (!$task || !$time || !$secret) {
        $output=array(
            'status'=>0,
            'info'=>"Invalid post."
        );
        echo json_encode($output);
        exit;
    }
    $secret2=sha1($task."7d3cfe8c4ecbdad6539e0b8d50d91215".$time);
    if ($secret!=$secret2) {
        $output=array(
            'status'=>0,
            'info'=>"Unauthorized post."
        );
        echo json_encode($output);
        exit;
    }
}
function validateOPENID($OPENID, $mode='browser')
{
    $user_db=new Model("users");
    $result=$user_db->find(array("OPENID = :OPENID",":OPENID" => $OPENID));
    if (empty($result)) {
        if ($mode=="app") {
            $output=array(
                'status'=>0,
                'info'=>'invalid OPENID'
            );
            echo json_encode($output);
            exit;
        } else {
            session_unset();
            session_destroy();
            return 0;
        }
    } else {
        $_SESSION['uid']=$result['uid'];
        return 1;
    }
}

function link_urldecode($url)
{
    $uri = '';
    $cs = unpack('C*', $url);
    $len = count($cs);
    for ($i=1; $i<=$len; $i++) {
        $uri .= $cs[$i] > 127 ? '%'.strtoupper(dechex($cs[$i])) : $url{$i-1};
    }
    return $uri;
}

function getuserinfo($OPENID)
{
    $user_db=new Model("users");
    return $user_db->find(array("OPENID = :OPENID",":OPENID" => $OPENID));
}

function getusersettings($loginid)
{
    $user_db=new Model("users");
    $result=$user_db->find(
        array(
            "loginid = :loginid",
            ":loginid" => $loginid
        )
    );
    $uid=$result['uid'];
    $user1_db=new Model("user_setting");
    $result=$user1_db->find(
        array(
            "uid = :uid",
            ":uid" => $uid
        )
    );
    return $result;
}

function sizeConverter($bit)
{
    $type = array('Bytes','KB','MB','GB','TB');
    for ($i = 0; $bit >= 1024; $i++) {
        $bit/=1024;
    }
    return (floor($bit*100)/100)." ".$type[$i];
}


function getDirSize($dir)
{
    $size = 0;
    $handle = opendir($dir);
    while (($folderOrFile = readdir($handle)) != false) {
        if ($folderOrFile != '.' && $folderOrFile != '..') {
            if (is_dir($folderOrFile)) {
                $size += getDirSize("$dir/$folderOrFile");
            } else {
                $size += filesize("$dir/$folderOrFile");
            }
        }
    }
    closedir($handle);
    return $size;
}

function generateRandStr($len)
{
    $code = '';
    for ($i = 0; $i < $len; $i++) {
        $code = $code . substr(str_shuffle('0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM'), 0, 1);
    }
    return $code;
}
