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

function get_thumbnail($data_string)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_URL, 'https://api.projectoxford.ai/vision/v1.0/generateThumbnail?width=100&height=100&smartCropping=true)');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        array(
        'Content-Type: application/json; charset=utf-8',
        'Host: api.projectoxford.ai',
        'Ocp-Apim-Subscription-Key: 86c2a4018d964a64b43558ed925eaea4',
        'Content-Length: ' . strlen($data_string))
    );
            
    ob_start();
    curl_exec($ch);
    $return_content = ob_get_contents();
    ob_end_clean();
      
    $return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    return array($return_code, $return_content);
}

function sizeConverter($bit)
{
    $type = array('Bytes','KB','MB','GB','TB');
    for($i = 0; $bit >= 1024; $i++)
    {
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

function sendactivatemail()
{
    $db=new Model("users");
    $result=$db->find(
        array(
            "loginid=:loginid",
            ":loginid"=>@$_SESSION['loginid']
        )
    );
    if (empty($result)) {
        echo json_encode(
            array(
                "result"=>0,
                "error"=>"invalid loginid"
            )
        );
        exit;
    }

    if ($result['emailok']) {
        echo json_encode(
            array(
                "result"=>0,
                "error"=>"email verified"
            )
        );
        exit;
    }

    $email=$result['email'];
    $user_id=$result['uid'];
    if ($result['real_name']) {
        $name=$result['real_name'];
    } else {
        $name=$result['name'];
    }
    require APP_DIR.'/protected/include/mail/class.phpmailer.php';
    $activeid=md5(md5($email));
    $msg_content='<html> <head> <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;"> <title>Notify</title> <style type="text/css"> svg{width: 60px;height: 60px;} div, p, a, li, td { -webkit-text-size-adjust:none; } *{-webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; } .ReadMsgBody {width: 100%; background-color: #ffffff;} .ExternalClass {width: 100%; background-color: #ffffff;} body{width: 100%; height: 100%; background-color: #ffffff; margin:0; padding:0; -webkit-font-smoothing: antialiased;} html{width: 100%; background-color: #ffffff;} p {padding: 0!important; margin-top: 0!important; margin-right: 0!important; margin-bottom: 0!important; margin-left: 0!important; } .hover:hover {opacity:0.85;filter:alpha(opacity=85);} .image77 img {width: 77px; height: auto;} .avatar125 img {width: 125px; height: auto;} .icon61 img {width: 61px; height: auto;} .logo img {width: 75px; height: auto;} .icon18 img {width: 18px; height: auto;} </style> <!-- @media only screen and (max-width: 640px) {*/ --> <style type="text/css"> @media only screen and (max-width: 640px){body{width:auto!important;} table[class=full2] {width: 100%!important; clear: both; } table[class=mobile2] {width: 100%!important; padding-left: 20px; padding-right: 20px; clear: both; } table[class=fullCenter2] {width: 100%!important; text-align: center!important; clear: both; } td[class=fullCenter2] {width: 100%!important; text-align: center!important; clear: both; } td[class=pad15] {width: 100%!important; padding-left: 15px; padding-right: 15px; clear: both;} } </style> <!-- @media only screen and (max-width: 479px) {--> <style type="text/css"> @media only screen and (max-width: 479px){body{width:auto!important;} table[class=full2] {width: 100%!important; clear: both; } table[class=mobile2] {width: 100%!important; padding-left: 20px; padding-right: 20px; clear: both; } table[class=fullCenter2] {width: 100%!important; text-align: center!important; clear: both; } td[class=fullCenter2] {width: 100%!important; text-align: center!important; clear: both; } table[class=full] {width: 100%!important; clear: both; } table[class=mobile] {width: 100%!important; padding-left: 20px; padding-right: 20px; clear: both; } table[class=fullCenter] {width: 100%!important; text-align: center!important; clear: both; } td[class=fullCenter] {width: 100%!important; text-align: center!important; clear: both; } td[class=pad15] {width: 100%!important; padding-left: 15px; padding-right: 15px; clear: both;} .erase {display: none;} } } </style> </head> <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"> <!-- Notification 5 --> <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="full" bgcolor="#303030" style="background-color: rgb(240,240,240);"> <tbody> <tr mc:repeatable=""> <td style="-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;background-position: center center;background-repeat: no-repeat;" id="not5"> <div mc:hideable=""> <!-- Mobile Wrapper --> <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile2"> <tbody> <tr> <td width="100%" height="100" align="center"> <div class="sortable_inner ui-sortable"> <!-- Space --> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="full" object="drag-module-small"> <tbody> <tr> <td width="352" height="50"> </td> </tr> </tbody> </table> <!-- End Space --> <!-- Space --> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="full" object="drag-module-small"> <tbody> <tr> <td width="352" height="50"> </td> </tr> </tbody> </table> <!-- End Space --> </div> </td> </tr> </tbody> </table> <table width="392" border="0" cellpadding="0" cellspacing="0" align="center" class="full"> <tbody> <tr style=""> <td align="center" width="20" valign="middle"> </td> <td align="center" width="352" valign="middle" style=" "> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="full"> <tbody> <tr style=" \\: 0 5px 50px rgba(0,0,0,.5); "> <td align="center" width="352" valign="middle" bgcolor="#ffffff" style="border: 1px rgba(0,0,0,.1) solid;"> <div class="sortable_inner ui-sortable" style=" "> <!-- Start Top --> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small" style="background-color: rgb(255, 255, 255);"> <tbody style=" "> <tr style=" "> <td width="352" valign="middle" style=" "> <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter"> <tbody> <tr> <td width="100%" height="30"> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small" style="background-color: rgb(255, 255, 255);"> <tbody> <tr> <td width="352" valign="middle" class="icon61" align="center"> <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter"> <tbody> <tr> <td width="100%"> <span> <svg style="width: 60px;height: 60px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="60" height="60" viewbox="0 0 60 60" version="1.1"><defs> <style type="text/css"> @font-face { font-family: ifont; src: url("//at.alicdn.com/t/font_1442373896_4754455.eot?#iefix") format("embedded-opentype"), url("//at.alicdn.com/t/font_1442373896_4754455.woff") format("woff"), url("//at.alicdn.com/t/font_1442373896_4754455.ttf") format("truetype"), url("//at.alicdn.com/t/font_1442373896_4754455.svg#ifont") format("svg"); } </style> </defs><g class="transform-group"><g transform="scale(0.05859375, 0.05859375)"><path d="M509.874593 62.145385c-247.526513 0-448.185602 200.659089-448.185602 448.185602s200.659089 448.185602 448.185602 448.185602 448.185602-200.659089 448.185602-448.185602S757.400083 62.145385 509.874593 62.145385zM511.450485 206.575846c25.767873 0 46.731324 20.962427 46.731324 46.730301s-20.963451 46.731324-46.731324 46.731324-46.731324-20.963451-46.731324-46.731324S485.683634 206.575846 511.450485 206.575846zM559.205115 766.042927c0 26.331715-21.422915 47.75463-47.75463 47.75463-26.331715 0-47.75463-21.422915-47.75463-47.75463L463.695854 413.81377c0-26.330692 21.422915-47.753607 47.75463-47.753607 26.331715 0 47.75463 21.422915 47.75463 47.753607L559.205115 766.042927z" fill="#3FC2FF"></path></g></g></svg> </span> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small" style="background-color: rgb(255, 255, 255);"> <tbody> <tr> <td width="352" valign="middle"> <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter"> <tbody> <tr> <td width="100%" height="30"> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small" style="background-color: rgb(255, 255, 255);"> <tbody> <tr> <td width="352" valign="middle" align="center"> <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter"> <tbody> <tr> <td valign="middle" width="100%" style="text-align: center; font-family: Microsoft Yahei, Arial, sans-serif; font-size: 23px; color: rgb(63, 67, 69); line-height: 28px; font-weight: bold;" class="fullCenter" mc:edit="31"> <!--[if !mso]><!--><span style="font-family: \'Microsoft Yahei\', Microsoft Yahei; font-weight: normal;"><!--<![endif]-->Hey ，您好！<!--[if !mso]><!--></span><!--<![endif]--> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small" style="background-color: rgb(255, 255, 255);"> <tbody> <tr> <td width="352" valign="middle"> <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter"> <tbody> <tr> <td width="100%" height="30"> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small" style="background-color: rgb(255, 255, 255);"> <tbody> <tr> <td width="352" valign="middle" align="center"> <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter"> <tbody> <tr> <td valign="middle" width="100%" style="text-align: center; font-family: Microsoft Yahei, Arial, sans-serif; font-size: 40px; color: rgb(63, 67, 69); line-height: 46px; font-weight: bold;" class="fullCenter" mc:edit="32"> <!--[if !mso]><!--><span style="font-family: \'proxima_nova_rgbold\', Microsoft Yahei; font-weight: normal;"><!--<![endif]-->欢迎注册<br class="erase"> 一分钱助学<!--[if !mso]><!--></span><!--<![endif]--> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small" style="background-color: rgb(255, 255, 255);"> <tbody> <tr> <td width="352" valign="middle"> <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter"> <tbody> <tr> <td width="100%" height="30"> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <!-- Divider --> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small" style="background-color: rgb(255, 255, 255);"> <tbody> <tr> <td width="352" valign="middle"> <!-- Header Text --> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter"> <tbody> <tr> <td width="100%" height="10"> </td> </tr> <tr> <td width="100%" height="1" bgcolor="#e5e5e5" style="font-size: 1px; line-height: 1px;"> &nbsp; </td> </tr> <tr> <td width="100%" height="10"> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <!-- End Divider --> <!-- Start 2nd --> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small" style="background-color: rgb(255, 255, 255);"> <tbody> <tr> <td width="352" valign="middle" align="center"> <!-- Buttons + Text --> <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter"> <tbody> <tr> <td width="100%" height="30"> </td> </tr> <tr> <td valign="middle" width="100%" style="text-align: center; font-family: Microsoft Yahei, Arial, sans-serif; font-size: 14px; color: rgb(63, 67, 69); line-height: 24px;" class="fullCenter" mc:edit="33"> <!--[if !mso]><!--> <p style="text-align: left; font-family: \'proxima_nova_rgregular\', Microsoft Yahei; font-weight: normal;"> <!--<![endif]-->亲爱的 '.$name.'：<!--[if !mso]><!--> </p> <!--<![endif]--> <!--[if !mso]><!--> <p style="text-align: left; font-family: \'proxima_nova_rgregular\', Microsoft Yahei; font-weight: normal;text-indent: 2em;"> <!--<![endif]-->感谢您注册一分钱助学账号! 请点击下面的按钮完成注册：<!--[if !mso]><!--> </p> <!--<![endif]--> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small" style="background-color: rgb(255, 255, 255);"> <tbody> <tr> <td width="352" valign="middle"> <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter"> <tbody> <tr> <td width="100%" height="40"> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small" style="background-color: rgb(255, 255, 255);"> <tbody> <tr> <td width="352" valign="middle" align="center"> <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter"> <!----------------- Button Center -----------------> <tbody> <tr> <td align="center"> <table border="0" cellpadding="0" cellspacing="0" align="center" style=" "> <tbody> <tr> <td align="center" height="35" bgcolor="#ffffff" style="border-top-left-radius: 20px;border-top-right-radius: 20px;border-bottom-right-radius: 20px;border-bottom-left-radius: 20px;padding-left: 30px;padding-right: 30px;font-weight: bold;font-family: Microsoft Yahei, Arial, sans-serif;color: rgb(255, 255, 255);background-color: rgb(254, 70, 70);" mc:edit="34"> <!--[if !mso]><!--><span style="font-family: \'proxima_nova_rgbold\', Microsoft Yahei; font-weight: normal;"><!--<![endif]--> <a href="https://www.1cf.co/account/activate?id='.$user_id.'&act='.$activeid.'" style="color: rgb(255, 255, 255); font-size: 14px; text-decoration: none; line-height: 35px; width: 100%;">立即激活</a> <!--[if !mso]><!--></span><!--<![endif]--> </td> </tr> </tbody> </table> </td> </tr> <tr> <td width="100%" height="12"> </td> </tr> <!----------------- End Button Center -----------------> </tbody> </table> </td> </tr> </tbody> </table> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small" style="background-color: rgb(255, 255, 255);"> <tbody> <tr> <td width="352" valign="middle"> <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter"> <tbody> <tr> <td width="100%" height="20"> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <!-- Divider --> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small" style="background-color: rgb(255, 255, 255);"> <tbody> <tr> <td width="352" valign="middle" align="center"> <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter"> <!----------------- End Button Center -----------------> <tbody> <tr> <td valign="middle" width="100%" style="text-align: center; font-family: Microsoft Yahei, Arial, sans-serif; font-size: 14px; color: rgb(63, 67, 69); line-height: 24px;" class="fullCenter" mc:edit="38"> <!--[if !mso]><!--> <p style="font-family: \'proxima_nova_rgregular\', Microsoft Yahei; font-weight: normal;"> <!--<![endif]-->或者复制此链接到浏览器<!--[if !mso]><!--> </p> <!--<![endif]--> <!--[if !mso]><!--> <p style="font-family: \'proxima_nova_rgregular\', Microsoft Yahei; font-weight: normal;"> <!--<![endif]-->https://www.1cf.co/account/activate?id='.$user_id.'&act='.$activeid.'<!--[if !mso]><!--> </p> <!--<![endif]--> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small" style="background-color: rgb(255, 255, 255);"> <tbody> <tr> <td width="352" valign="middle"> <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter"> <tbody> <tr> <td width="100%" height="40"> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <!-- End 3th --> </div> </td> </tr> </tbody> </table> </td> <td align="center" width="20" valign="middle"> </td> </tr> </tbody> </table> <!-- Mobile Wrapper --> <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile2"> <tbody> <tr> <td width="100%" height="100" align="center"> <div class="sortable_inner ui-sortable"> <!-- Space --> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="full" object="drag-module-small"> <tbody> <tr> <td width="352" height="40"> </td> </tr> </tbody> </table> <!-- End Space --> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" object="drag-module-small"> <tbody> <tr> <td width="352" valign="middle" align="center"> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter"> <tbody> <tr> <td width="100%" style="text-align: center;font-family: Microsoft Yahei, Arial, sans-serif;font-size: 14px;color: rgb(15, 15, 15);line-height: 24px;" class="fullCenter" mc:edit="21_736372"> <!--[if !mso]><!--><span style="font-family: \'proxima_nova_rgregular\', Microsoft Yahei;"><!--<![endif]--><!--subscribe--> <p style=""> © 2016 扬州市广陵区多公益发展中心 </p> <!--unsub--><!--[if !mso]><!--></span><!--<![endif]--> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <!-- Space --> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="full" object="drag-module-small"> <tbody> <tr> <td width="352" height="50"> </td> </tr> </tbody> </table> <!-- End Space --> </div> </td> </tr> </tbody> </table> </div> </td> </tr> </tbody> </table> <!-- End Notification 5 --> <style> body{ background: none !important; } </style> </body> </html>';
    $mail = new PHPMailer(true);
    $mail->IsSMTP();
    $mail->CharSet='UTF-8'; //设置邮件的字符编码，这很重要，不然中文乱码
                        $mail->SMTPAuth   = true;                  //开启认证
                        $mail->Port       = 25;
    $mail->Host       = "smtp.ym.163.com";
    $mail->Username   = "contact@1cf.co";
    $mail->Password   = "Zsgscorp1";
    //$mail->IsSendmail(); //如果没有sendmail组件就注释掉，否则出现“Could  not execute: /var/qmail/bin/sendmail ”的错误提示
                        $mail->AddReplyTo("contact@1cf.co", "联系团队");//回复地址
                        $mail->From       = "contact@1cf.co";
    $mail->FromName   = "联系团队";
    //$to = "2793203840@qq.com";
    $mail->AddAddress($email);
    $mail->Subject  = "【一分钱助学】激活邮件";
    $mail->Body = $msg_content;
    $mail->AltBody    = "请使用一个支持HTML视图的邮箱服务来查看本邮件！"; //当邮件不支持html时备用显示，可以省略
                        $mail->WordWrap   = 80; // 设置每行字符串的长度
                        //$mail->AddAttachment("f:/test.png");  //可以添加附件
                        $mail->IsHTML(true);
    $mail->Send();
    echo json_encode(
                            array("result"=>1)
                        );
}
