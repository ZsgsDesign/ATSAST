<?php
class AccountController extends BaseController
{

	public static function sendActivateEmail($email_address,$OPENID){
        $msg_content='<html> <head> <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;"> <title>Notify</title> <style type="text/css"> svg{width: 60px;height: 60px;} div, p, a, li, td { -webkit-text-size-adjust:none; } *{-webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; } .ReadMsgBody {width: 100%; background-color: #ffffff;} .ExternalClass {width: 100%; background-color: #ffffff;} body{width: 100%; height: 100%; background-color: #ffffff; margin:0; padding:0; -webkit-font-smoothing: antialiased;} html{width: 100%; background-color: #ffffff;} p {padding: 0!important; margin-top: 0!important; margin-right: 0!important; margin-bottom: 0!important; margin-left: 0!important; } .hover:hover {opacity:0.85;filter:alpha(opacity=85);} .image77 img {width: 77px; height: auto;} .avatar125 img {width: 125px; height: auto;} .icon61 img {width: 61px; height: auto;} .logo img {width: 75px; height: auto;} .icon18 img {width: 18px; height: auto;} </style> <!-- @media only screen and (max-width: 640px) {*/ --> <style type="text/css"> @media only screen and (max-width: 640px){body{width:auto!important;} table[class=full2] {width: 100%!important; clear: both; } table[class=mobile2] {width: 100%!important; padding-left: 20px; padding-right: 20px; clear: both; } table[class=fullCenter2] {width: 100%!important; text-align: center!important; clear: both; } td[class=fullCenter2] {width: 100%!important; text-align: center!important; clear: both; } td[class=pad15] {width: 100%!important; padding-left: 15px; padding-right: 15px; clear: both;} } </style> <!-- @media only screen and (max-width: 479px) {--> <style type="text/css"> @media only screen and (max-width: 479px){body{width:auto!important;} table[class=full2] {width: 100%!important; clear: both; } table[class=mobile2] {width: 100%!important; padding-left: 20px; padding-right: 20px; clear: both; } table[class=fullCenter2] {width: 100%!important; text-align: center!important; clear: both; } td[class=fullCenter2] {width: 100%!important; text-align: center!important; clear: both; } table[class=full] {width: 100%!important; clear: both; } table[class=mobile] {width: 100%!important; padding-left: 20px; padding-right: 20px; clear: both; } table[class=fullCenter] {width: 100%!important; text-align: center!important; clear: both; } td[class=fullCenter] {width: 100%!important; text-align: center!important; clear: both; } td[class=pad15] {width: 100%!important; padding-left: 15px; padding-right: 15px; clear: both;} .erase {display: none;} } } </style> </head> <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"> <!-- Notification 5 --> <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="full" bgcolor="#303030" style="background-color: rgb(240,240,240);"> <tbody> <tr mc:repeatable=""> <td style="-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;background-position: center center;background-repeat: no-repeat;" id="not5"> <div mc:hideable=""> <!-- Mobile Wrapper --> <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile2"> <tbody> <tr> <td width="100%" height="100" align="center"> <div class="sortable_inner ui-sortable"> <!-- Space --> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="full" object="drag-module-small"> <tbody> <tr> <td width="352" height="50"> </td> </tr> </tbody> </table> <!-- End Space --> <!-- Space --> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="full" object="drag-module-small"> <tbody> <tr> <td width="352" height="50"> </td> </tr> </tbody> </table> <!-- End Space --> </div> </td> </tr> </tbody> </table> <table width="392" border="0" cellpadding="0" cellspacing="0" align="center" class="full"> <tbody> <tr style=""> <td align="center" width="20" valign="middle"> </td> <td align="center" width="352" valign="middle" style=" "> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="full"> <tbody> <tr style=" \\: 0 5px 50px rgba(0,0,0,.5); "> <td align="center" width="352" valign="middle" bgcolor="#ffffff" style="border: 1px rgba(0,0,0,.1) solid;"> <div class="sortable_inner ui-sortable" style=" "> <!-- Start Top --> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small" style="background-color: rgb(255, 255, 255);"> <tbody style=" "> <tr style=" "> <td width="352" valign="middle" style=" "> <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter"> <tbody> <tr> <td width="100%" height="30"> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small" style="background-color: rgb(255, 255, 255);"> <tbody> <tr> <td width="352" valign="middle" class="icon61" align="center"> <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter"> <tbody> <tr> <td width="100%"> <span> <svg style="width: 60px;height: 60px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="60" height="60" viewbox="0 0 60 60" version="1.1"><defs> <style type="text/css"> @font-face { font-family: ifont; src: url("//at.alicdn.com/t/font_1442373896_4754455.eot?#iefix") format("embedded-opentype"), url("//at.alicdn.com/t/font_1442373896_4754455.woff") format("woff"), url("//at.alicdn.com/t/font_1442373896_4754455.ttf") format("truetype"), url("//at.alicdn.com/t/font_1442373896_4754455.svg#ifont") format("svg"); } </style> </defs><g class="transform-group"><g transform="scale(0.05859375, 0.05859375)"><path d="M509.874593 62.145385c-247.526513 0-448.185602 200.659089-448.185602 448.185602s200.659089 448.185602 448.185602 448.185602 448.185602-200.659089 448.185602-448.185602S757.400083 62.145385 509.874593 62.145385zM511.450485 206.575846c25.767873 0 46.731324 20.962427 46.731324 46.730301s-20.963451 46.731324-46.731324 46.731324-46.731324-20.963451-46.731324-46.731324S485.683634 206.575846 511.450485 206.575846zM559.205115 766.042927c0 26.331715-21.422915 47.75463-47.75463 47.75463-26.331715 0-47.75463-21.422915-47.75463-47.75463L463.695854 413.81377c0-26.330692 21.422915-47.753607 47.75463-47.753607 26.331715 0 47.75463 21.422915 47.75463 47.753607L559.205115 766.042927z" fill="#3FC2FF"></path></g></g></svg> </span> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small" style="background-color: rgb(255, 255, 255);"> <tbody> <tr> <td width="352" valign="middle"> <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter"> <tbody> <tr> <td width="100%" height="30"> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small" style="background-color: rgb(255, 255, 255);"> <tbody> <tr> <td width="352" valign="middle" align="center"> <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter"> <tbody> <tr> <td valign="middle" width="100%" style="text-align: center; font-family: Microsoft Yahei, Arial, sans-serif; font-size: 23px; color: rgb(63, 67, 69); line-height: 28px; font-weight: bold;" class="fullCenter" mc:edit="31"> <!--[if !mso]><!--><span style="font-family: \'Microsoft Yahei\', Microsoft Yahei; font-weight: normal;"><!--<![endif]-->Hey ，您好！<!--[if !mso]><!--></span><!--<![endif]--> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small" style="background-color: rgb(255, 255, 255);"> <tbody> <tr> <td width="352" valign="middle"> <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter"> <tbody> <tr> <td width="100%" height="30"> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small" style="background-color: rgb(255, 255, 255);"> <tbody> <tr> <td width="352" valign="middle" align="center"> <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter"> <tbody> <tr> <td valign="middle" width="100%" style="text-align: center; font-family: Microsoft Yahei, Arial, sans-serif; font-size: 40px; color: rgb(63, 67, 69); line-height: 46px; font-weight: bold;" class="fullCenter" mc:edit="32"> <!--[if !mso]><!--><p style="font-family: \'proxima_nova_rgbold\', Microsoft Yahei; font-weight: normal;line-height: 1.5;"><!--<![endif]-->欢迎注册<!--[if !mso]><!--></p><!--<![endif]--> <!--[if !mso]><!--><p style="font-family: \'proxima_nova_rgbold\', Microsoft Yahei; font-weight: normal;line-height: 1.5;"><!--<![endif]-->ATSAST<!--[if !mso]><!--></p><!--<![endif]--> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small" style="background-color: rgb(255, 255, 255);"> <tbody> <tr> <td width="352" valign="middle"> <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter"> <tbody> <tr> <td width="100%" height="30"> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <!-- Divider --> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small" style="background-color: rgb(255, 255, 255);"> <tbody> <tr> <td width="352" valign="middle"> <!-- Header Text --> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter"> <tbody> <tr> <td width="100%" height="10"> </td> </tr> <tr> <td width="100%" height="1" bgcolor="#e5e5e5" style="font-size: 1px; line-height: 1px;"> &nbsp; </td> </tr> <tr> <td width="100%" height="10"> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <!-- End Divider --> <!-- Start 2nd --> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small" style="background-color: rgb(255, 255, 255);"> <tbody> <tr> <td width="352" valign="middle" align="center"> <!-- Buttons + Text --> <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter"> <tbody> <tr> <td width="100%" height="30"> </td> </tr> <tr> <td valign="middle" width="100%" style="text-align: center; font-family: Microsoft Yahei, Arial, sans-serif; font-size: 14px; color: rgb(63, 67, 69); line-height: 24px;" class="fullCenter" mc:edit="33"> <!--[if !mso]><!--> <p style="text-align: left; font-family: \'proxima_nova_rgregular\', Microsoft Yahei; font-weight: normal;"> <!--<![endif]-->亲爱的 '.explode('@',$email_address)[0].'：<!--[if !mso]><!--> </p> <!--<![endif]--> <!--[if !mso]><!--> <p style="text-align: left; font-family: \'proxima_nova_rgregular\', Microsoft Yahei; font-weight: normal;text-indent: 2em;"> <!--<![endif]-->感谢您注册SAST教学辅助平台账号! 请点击下面的按钮完成邮箱验证：<!--[if !mso]><!--> </p> <!--<![endif]--> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small" style="background-color: rgb(255, 255, 255);"> <tbody> <tr> <td width="352" valign="middle"> <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter"> <tbody> <tr> <td width="100%" height="40"> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small" style="background-color: rgb(255, 255, 255);"> <tbody> <tr> <td width="352" valign="middle" align="center"> <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter"> <!----------------- Button Center -----------------> <tbody> <tr> <td align="center"> <table border="0" cellpadding="0" cellspacing="0" align="center" style=" "> <tbody> <tr> <td align="center" height="35" bgcolor="#ffffff" style="border-top-left-radius: 20px;border-top-right-radius: 20px;border-bottom-right-radius: 20px;border-bottom-left-radius: 20px;padding-left: 30px;padding-right: 30px;font-weight: bold;font-family: Microsoft Yahei, Arial, sans-serif;color: rgb(255, 255, 255);background-color: rgb(254, 70, 70);" mc:edit="34"> <!--[if !mso]><!--><span style="font-family: \'proxima_nova_rgbold\', Microsoft Yahei; font-weight: normal;"><!--<![endif]--> <a href="https://mundb.xyz/account/activate?act='.$OPENID.'" style="color: rgb(255, 255, 255); font-size: 14px; text-decoration: none; line-height: 35px; width: 100%;">立即激活</a> <!--[if !mso]><!--></span><!--<![endif]--> </td> </tr> </tbody> </table> </td> </tr> <tr> <td width="100%" height="12"> </td> </tr> <!----------------- End Button Center -----------------> </tbody> </table> </td> </tr> </tbody> </table> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small" style="background-color: rgb(255, 255, 255);"> <tbody> <tr> <td width="352" valign="middle"> <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter"> <tbody> <tr> <td width="100%" height="20"> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <!-- Divider --> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small" style="background-color: rgb(255, 255, 255);"> <tbody> <tr> <td width="352" valign="middle" align="center"> <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter"> <!----------------- End Button Center -----------------> <tbody> <tr> <td valign="middle" width="100%" style="text-align: center; font-family: Microsoft Yahei, Arial, sans-serif; font-size: 14px; color: rgb(63, 67, 69); line-height: 24px;" class="fullCenter" mc:edit="38"> <!--[if !mso]><!--> <p style="font-family: \'proxima_nova_rgregular\', Microsoft Yahei; font-weight: normal;"> <!--<![endif]-->或者复制此链接到浏览器<!--[if !mso]><!--> </p> <!--<![endif]--> <!--[if !mso]><!--> <p style="font-family: \'proxima_nova_rgregular\', Microsoft Yahei; font-weight: normal;"> <!--<![endif]-->https://mundb.xyz/account/activate?act='.$OPENID.'<!--[if !mso]><!--> </p> <!--<![endif]--> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small" style="background-color: rgb(255, 255, 255);"> <tbody> <tr> <td width="352" valign="middle"> <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter"> <tbody> <tr> <td width="100%" height="40"> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <!-- End 3th --> </div> </td> </tr> </tbody> </table> </td> <td align="center" width="20" valign="middle"> </td> </tr> </tbody> </table> <!-- Mobile Wrapper --> <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile2"> <tbody> <tr> <td width="100%" height="100" align="center"> <div class="sortable_inner ui-sortable"> <!-- Space --> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="full" object="drag-module-small"> <tbody> <tr> <td width="352" height="40"> </td> </tr> </tbody> </table> <!-- End Space --> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" object="drag-module-small"> <tbody> <tr> <td width="352" valign="middle" align="center"> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter"> <tbody> <tr> <td width="100%" style="text-align: center;font-family: Microsoft Yahei, Arial, sans-serif;font-size: 14px;color: rgb(15, 15, 15);line-height: 24px;" class="fullCenter" mc:edit="21_736372"> <!--[if !mso]><!--><span style="font-family: \'proxima_nova_rgregular\', Microsoft Yahei;"><!--<![endif]--><!--subscribe--> <p style=""> © 2018 ATSAST<br>Auxiliary Teaching for Students\' Association for Science and Technology </p> <!--unsub--><!--[if !mso]><!--></span><!--<![endif]--> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <!-- Space --> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="full" object="drag-module-small"> <tbody> <tr> <td width="352" height="50"> </td> </tr> </tbody> </table> <!-- End Space --> </div> </td> </tr> </tbody> </table> </div> </td> </tr> </tbody> </table> <!-- End Notification 5 --> <style> body{ background: none !important; } </style> </body> </html>';
		$mail = new PHPMailer(true);
		$mail->IsSMTP();
		$mail->CharSet='UTF-8'; //设置邮件的字符编码，这很重要，不然中文乱码
		$mail->SMTPAuth   = true;                  //开启认证
		// $mail->SMTPSecure = "ssl";
		$mail->Port       = 25;
		$mail->Host       = "mail.njupt.edu.cn";
		$mail->Username   = "sast@njupt.edu.cn";
		$mail->Password   = "iLOVEsast2018";
		//$mail->IsSendmail(); //如果没有sendmail组件就注释掉，否则出现“Could  not execute: /var/qmail/bin/sendmail ”的错误提示
		$mail->AddReplyTo("sast@njupt.edu.cn","南京邮电大学大学生科学技术协会");//回复地址
		$mail->From       = "sast@njupt.edu.cn";
		$mail->FromName   = "南京邮电大学大学生科学技术协会";
		//$to = "2793203840@qq.com";
		$mail->AddAddress($email_address);
		$mail->Subject  = "【SAST辅助教学平台】激活邮件";
		$mail->Body = $msg_content;
		$mail->AltBody    = "激活地址为：https://mundb.xyz/account/activate?act=".$OPENID."，请使用一个支持HTML视图的邮箱服务来查看本激活邮件！"; //当邮件不支持html时备用显示，可以省略
		$mail->WordWrap   = 80; // 设置每行字符串的长度
		//$mail->AddAttachment("f:/test.png");  //可以添加附件
		$mail->IsHTML(true);
		$mail->Send();
		return true;
    }
    
    public static function sendRetrievePasswordEmail($email_address,$uid,$OPENID){
        $retrieveid=sha1($OPENID.$uid);
        $msg_content='<html> <head> <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;"> <title>Notify</title> <style type="text/css"> svg{width: 60px;height: 60px;} div, p, a, li, td { -webkit-text-size-adjust:none; } *{-webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; } .ReadMsgBody {width: 100%; background-color: #ffffff;} .ExternalClass {width: 100%; background-color: #ffffff;} body{width: 100%; height: 100%; background-color: #ffffff; margin:0; padding:0; -webkit-font-smoothing: antialiased;} html{width: 100%; background-color: #ffffff;} p {padding: 0!important; margin-top: 0!important; margin-right: 0!important; margin-bottom: 0!important; margin-left: 0!important; } .hover:hover {opacity:0.85;filter:alpha(opacity=85);} .image77 img {width: 77px; height: auto;} .avatar125 img {width: 125px; height: auto;} .icon61 img {width: 61px; height: auto;} .logo img {width: 75px; height: auto;} .icon18 img {width: 18px; height: auto;} </style> <!-- @media only screen and (max-width: 640px) {*/ --> <style type="text/css"> @media only screen and (max-width: 640px){body{width:auto!important;} table[class=full2] {width: 100%!important; clear: both; } table[class=mobile2] {width: 100%!important; padding-left: 20px; padding-right: 20px; clear: both; } table[class=fullCenter2] {width: 100%!important; text-align: center!important; clear: both; } td[class=fullCenter2] {width: 100%!important; text-align: center!important; clear: both; } td[class=pad15] {width: 100%!important; padding-left: 15px; padding-right: 15px; clear: both;} } </style> <!-- @media only screen and (max-width: 479px) {--> <style type="text/css"> @media only screen and (max-width: 479px){body{width:auto!important;} table[class=full2] {width: 100%!important; clear: both; } table[class=mobile2] {width: 100%!important; padding-left: 20px; padding-right: 20px; clear: both; } table[class=fullCenter2] {width: 100%!important; text-align: center!important; clear: both; } td[class=fullCenter2] {width: 100%!important; text-align: center!important; clear: both; } table[class=full] {width: 100%!important; clear: both; } table[class=mobile] {width: 100%!important; padding-left: 20px; padding-right: 20px; clear: both; } table[class=fullCenter] {width: 100%!important; text-align: center!important; clear: both; } td[class=fullCenter] {width: 100%!important; text-align: center!important; clear: both; } td[class=pad15] {width: 100%!important; padding-left: 15px; padding-right: 15px; clear: both;} .erase {display: none;} } } </style> </head> <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"> <!-- Notification 5 --> <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="full" bgcolor="#303030" style="background-color: rgb(240,240,240);"> <tbody> <tr mc:repeatable=""> <td style="-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;background-position: center center;background-repeat: no-repeat;" id="not5"> <div mc:hideable=""> <!-- Mobile Wrapper --> <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile2"> <tbody> <tr> <td width="100%" height="100" align="center"> <div class="sortable_inner ui-sortable"> <!-- Space --> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="full" object="drag-module-small"> <tbody> <tr> <td width="352" height="50"> </td> </tr> </tbody> </table> <!-- End Space --> <!-- Space --> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="full" object="drag-module-small"> <tbody> <tr> <td width="352" height="50"> </td> </tr> </tbody> </table> <!-- End Space --> </div> </td> </tr> </tbody> </table> <table width="392" border="0" cellpadding="0" cellspacing="0" align="center" class="full"> <tbody> <tr style=""> <td align="center" width="20" valign="middle"> </td> <td align="center" width="352" valign="middle" style=" "> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="full"> <tbody> <tr style=" \\: 0 5px 50px rgba(0,0,0,.5); "> <td align="center" width="352" valign="middle" bgcolor="#ffffff" style="border: 1px rgba(0,0,0,.1) solid;"> <div class="sortable_inner ui-sortable" style=" "> <!-- Start Top --> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small" style="background-color: rgb(255, 255, 255);"> <tbody style=" "> <tr style=" "> <td width="352" valign="middle" style=" "> <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter"> <tbody> <tr> <td width="100%" height="30"> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small" style="background-color: rgb(255, 255, 255);"> <tbody> <tr> <td width="352" valign="middle" class="icon61" align="center"> <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter"> <tbody> <tr> <td width="100%"> <span> <svg style="width: 60px;height: 60px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="60" height="60" viewbox="0 0 1024 1024" version="1.1"><defs><style type="text/css"></style></defs><path d="M512 64C264.64 64 64 264.64 64 512c0 247.424 200.64 448 448 448 247.488 0 448-200.576 448-448C960 264.64 759.488 64 512 64zM512 768c-26.432 0-48-21.504-48-48S485.568 672 512 672c26.624 0 48 21.504 48 48S538.624 768 512 768zM560 528C560 554.56 538.624 576 512 576 485.568 576 464 554.56 464 528l0-224C464 277.44 485.568 256 512 256c26.624 0 48 21.44 48 48L560 528z" p-id="7544" fill="#f44336"></path></svg> </span> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small" style="background-color: rgb(255, 255, 255);"> <tbody> <tr> <td width="352" valign="middle"> <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter"> <tbody> <tr> <td width="100%" height="30"> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small" style="background-color: rgb(255, 255, 255);"> <tbody> <tr> <td width="352" valign="middle" align="center"> <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter"> <tbody> <tr> <td valign="middle" width="100%" style="text-align: center; font-family: Microsoft Yahei, Arial, sans-serif; font-size: 23px; color: rgb(63, 67, 69); line-height: 28px; font-weight: bold;" class="fullCenter" mc:edit="31"> <!--[if !mso]><!--><span style="font-family: \'Microsoft Yahei\', Microsoft Yahei; font-weight: normal;"><!--<![endif]-->Hey ，您好！<!--[if !mso]><!--></span><!--<![endif]--> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small" style="background-color: rgb(255, 255, 255);"> <tbody> <tr> <td width="352" valign="middle"> <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter"> <tbody> <tr> <td width="100%" height="30"> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small" style="background-color: rgb(255, 255, 255);"> <tbody> <tr> <td width="352" valign="middle" align="center"> <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter"> <tbody> <tr> <td valign="middle" width="100%" style="text-align: center; font-family: Microsoft Yahei, Arial, sans-serif; font-size: 40px; color: rgb(63, 67, 69); line-height: 46px; font-weight: bold;" class="fullCenter" mc:edit="32"> <!--[if !mso]><!--><p style="font-family: \'proxima_nova_rgbold\', Microsoft Yahei; font-weight: normal;line-height: 1.5;"><!--<![endif]-->找回密码<!--[if !mso]><!--></p><!--<![endif]--> <!--[if !mso]><!--><p style="font-family: \'proxima_nova_rgbold\', Microsoft Yahei; font-weight: normal;line-height: 1.5;"><!--<![endif]-->ATSAST<!--[if !mso]><!--></p><!--<![endif]--> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small" style="background-color: rgb(255, 255, 255);"> <tbody> <tr> <td width="352" valign="middle"> <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter"> <tbody> <tr> <td width="100%" height="30"> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <!-- Divider --> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small" style="background-color: rgb(255, 255, 255);"> <tbody> <tr> <td width="352" valign="middle"> <!-- Header Text --> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter"> <tbody> <tr> <td width="100%" height="10"> </td> </tr> <tr> <td width="100%" height="1" bgcolor="#e5e5e5" style="font-size: 1px; line-height: 1px;"> &nbsp; </td> </tr> <tr> <td width="100%" height="10"> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <!-- End Divider --> <!-- Start 2nd --> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small" style="background-color: rgb(255, 255, 255);"> <tbody> <tr> <td width="352" valign="middle" align="center"> <!-- Buttons + Text --> <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter"> <tbody> <tr> <td width="100%" height="30"> </td> </tr> <tr> <td valign="middle" width="100%" style="text-align: center; font-family: Microsoft Yahei, Arial, sans-serif; font-size: 14px; color: rgb(63, 67, 69); line-height: 24px;" class="fullCenter" mc:edit="33"> <!--[if !mso]><!--> <p style="text-align: left; font-family: \'proxima_nova_rgregular\', Microsoft Yahei; font-weight: normal;"> <!--<![endif]-->亲爱的 '.explode('@',$email_address)[0].'：<!--[if !mso]><!--> </p> <!--<![endif]--> <!--[if !mso]><!--> <p style="text-align: left; font-family: \'proxima_nova_rgregular\', Microsoft Yahei; font-weight: normal;text-indent: 2em;"> <!--<![endif]-->如果您忘记了您的密码，请点击下面的按钮重置您的密码：<!--[if !mso]><!--> </p> <!--<![endif]--> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small" style="background-color: rgb(255, 255, 255);"> <tbody> <tr> <td width="352" valign="middle"> <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter"> <tbody> <tr> <td width="100%" height="40"> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small" style="background-color: rgb(255, 255, 255);"> <tbody> <tr> <td width="352" valign="middle" align="center"> <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter"> <!----------------- Button Center -----------------> <tbody> <tr> <td align="center"> <table border="0" cellpadding="0" cellspacing="0" align="center" style=" "> <tbody> <tr> <td align="center" height="35" bgcolor="#ffffff" style="border-top-left-radius: 20px;border-top-right-radius: 20px;border-bottom-right-radius: 20px;border-bottom-left-radius: 20px;padding-left: 30px;padding-right: 30px;font-weight: bold;font-family: Microsoft Yahei, Arial, sans-serif;color: rgb(255, 255, 255);background-color: rgb(254, 70, 70);" mc:edit="34"> <!--[if !mso]><!--><span style="font-family: \'proxima_nova_rgbold\', Microsoft Yahei; font-weight: normal;"><!--<![endif]--> <a href="https://mundb.xyz/account/retrieve?id='.$uid.'&ret='.$retrieveid.'" style="color: rgb(255, 255, 255); font-size: 14px; text-decoration: none; line-height: 35px; width: 100%;">立即重置</a> <!--[if !mso]><!--></span><!--<![endif]--> </td> </tr> </tbody> </table> </td> </tr> <tr> <td width="100%" height="12"> </td> </tr> <!----------------- End Button Center -----------------> </tbody> </table> </td> </tr> </tbody> </table> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small" style="background-color: rgb(255, 255, 255);"> <tbody> <tr> <td width="352" valign="middle"> <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter"> <tbody> <tr> <td width="100%" height="20"> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <!-- Divider --> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small" style="background-color: rgb(255, 255, 255);"> <tbody> <tr> <td width="352" valign="middle" align="center"> <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter"> <!----------------- End Button Center -----------------> <tbody> <tr> <td valign="middle" width="100%" style="text-align: center; font-family: Microsoft Yahei, Arial, sans-serif; font-size: 14px; color: rgb(63, 67, 69); line-height: 24px;" class="fullCenter" mc:edit="38"> <!--[if !mso]><!--> <p style="font-family: \'proxima_nova_rgregular\', Microsoft Yahei; font-weight: normal;"> <!--<![endif]-->或者复制此链接到浏览器<!--[if !mso]><!--> </p> <!--<![endif]--> <!--[if !mso]><!--> <p style="font-family: \'proxima_nova_rgregular\', Microsoft Yahei; font-weight: normal;"> <!--<![endif]-->https://mundb.xyz/account/retrieve?id='.$uid.'&ret='.$retrieveid.'<!--[if !mso]><!--> </p> <!--<![endif]--> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" bgcolor="#ffffff" object="drag-module-small" style="background-color: rgb(255, 255, 255);"> <tbody> <tr> <td width="352" valign="middle"> <table width="300" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter"> <tbody> <tr> <td width="100%" height="40"> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <!-- End 3th --> </div> </td> </tr> </tbody> </table> </td> <td align="center" width="20" valign="middle"> </td> </tr> </tbody> </table> <!-- Mobile Wrapper --> <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile2"> <tbody> <tr> <td width="100%" height="100" align="center"> <div class="sortable_inner ui-sortable"> <!-- Space --> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="full" object="drag-module-small"> <tbody> <tr> <td width="352" height="40"> </td> </tr> </tbody> </table> <!-- End Space --> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile" object="drag-module-small"> <tbody> <tr> <td width="352" valign="middle" align="center"> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter"> <tbody> <tr> <td width="100%" style="text-align: center;font-family: Microsoft Yahei, Arial, sans-serif;font-size: 14px;color: rgb(15, 15, 15);line-height: 24px;" class="fullCenter" mc:edit="21_736372"> <!--[if !mso]><!--><span style="font-family: \'proxima_nova_rgregular\', Microsoft Yahei;"><!--<![endif]--><!--subscribe--> <p style=""> © 2018 ATSAST<br>Auxiliary Teaching for Students\' Association for Science and Technology </p> <!--unsub--><!--[if !mso]><!--></span><!--<![endif]--> </td> </tr> </tbody> </table> </td> </tr> </tbody> </table> <!-- Space --> <table width="352" border="0" cellpadding="0" cellspacing="0" align="center" class="full" object="drag-module-small"> <tbody> <tr> <td width="352" height="50"> </td> </tr> </tbody> </table> <!-- End Space --> </div> </td> </tr> </tbody> </table> </div> </td> </tr> </tbody> </table> <!-- End Notification 5 --> <style> body{ background: none !important; } </style> </body> </html>';
		$mail = new PHPMailer(true);
		$mail->IsSMTP();
		$mail->CharSet='UTF-8'; //设置邮件的字符编码，这很重要，不然中文乱码
		$mail->SMTPAuth   = true;                  //开启认证
		// $mail->SMTPSecure = "ssl";
		$mail->Port       = 25;
		$mail->Host       = "mail.njupt.edu.cn";
		$mail->Username   = "sast@njupt.edu.cn";
		$mail->Password   = "iLOVEsast2018";
		//$mail->IsSendmail(); //如果没有sendmail组件就注释掉，否则出现“Could  not execute: /var/qmail/bin/sendmail ”的错误提示
		$mail->AddReplyTo("sast@njupt.edu.cn","南京邮电大学大学生科学技术协会");//回复地址
		$mail->From       = "sast@njupt.edu.cn";
		$mail->FromName   = "南京邮电大学大学生科学技术协会";
		//$to = "2793203840@qq.com";
		$mail->AddAddress($email_address);
		$mail->Subject  = "【SAST辅助教学平台】找回密码";
		$mail->Body = $msg_content;
		$mail->AltBody    = "找回地址为：https://mundb.xyz/account/retrieve?id='.$uid.'&ret=".$OPENID."，请使用一个支持HTML视图的邮箱服务来查看本激活邮件！"; //当邮件不支持html时备用显示，可以省略
		$mail->WordWrap   = 80; // 设置每行字符串的长度
		//$mail->AddAttachment("f:/test.png");  //可以添加附件
		$mail->IsHTML(true);
		$mail->Send();
		return true;
	}

    private function account_err_report($msg, $current=1)
    {
        $this->current=$current;
        return $this->msg1=$msg;
    }

    public function actionIndex()
    {
        $this->current=0;
        if ($this->islogin) {
            $this->jump("/account/profile");
        } else {
            $this->title="登录 / 注册";
        }
        $this->url="ucenter";
        $this->msg1=$this->msg2="";
        $action=arg("action");
        if ($action==="register") { //如果是注册

            $db=new Model("users");
            $password=arg("password");
            $email=arg("email");
            $pattern="/^(\w){6,100}$/";
            if (empty($password) || empty($email)) {
                return self::account_err_report("请不要皮这个系统");
            }
            if (!preg_match($pattern, $password)) {
                return self::account_err_report("请设置6位以上100位以下密码，只能包含字母、数字及下划线");
            }

            if (filter_var($email, FILTER_VALIDATE_EMAIL)==false) {
                return self::account_err_report("请输入合法的邮箱");
            }

            $username=strtoupper(explode('@', $email)[0]);
            $SID=$username;
            $email_domain=explode('@', $email)[1];

            if ($email_domain!="njupt.edu.cn") {
                return self::account_err_report("请使用NJUPT校内邮注册");
            }

            $result=$db->find(array("email=:email",":email"=>$email));

            if ($result) {
                return self::account_err_report("邮箱已被使用");
            }

            $ip=getIP();
            $rtime=date("Y-m-d H:i:s");
            $OPENID=sha1(strtolower($email)."@SAST+1s".md5($password));
            $user=array(
                'rtime'=>$rtime,
                'name'=>$username,
                'SID'=>$SID,
                'password'=>md5($password),
                'email'=>$email,
                'ip'=>$ip,
                'album'=>"bing",
                'cloud_size'=>5,
                'OPENID'=>$OPENID,
                'avatar'=>"https://static.1cf.co/img/avatar/default.png",
                'gender'=>0
            );
            $uid=$db->create($user);
            if (!file_exists("/home/wwwroot/1cf/domain/1cf.co/web/i/img/atsast/upload/$uid")) {
                mkdir("/home/wwwroot/1cf/domain/1cf.co/web/i/img/atsast/upload/$uid", 0777, true);
            }
            $_SESSION['OPENID']=$OPENID;
            @self::sendActivateEmail($email,$OPENID);
            $this->jump("/");

        //echo json_encode($output);
        } elseif ($action==="login") { //如果是登录

            $email=arg("email");
            $password=arg("password");

            if (empty($password) || empty($email)) {
                return self::account_err_report("请不要皮这个系统", 0);
            }

            $OPENID=sha1(strtolower($email)."@SAST+1s".md5($password));
            $db=new Model("users");
            $result=$db->find(array("OPENID=:OPENID",":OPENID"=>$OPENID));
            if (empty($result)) {
                return self::account_err_report("邮箱或密码错误", 0);
            } else {
                $_SESSION['OPENID']=$OPENID;
                $this->jump("/");
            }
        }
    }

    public function actionLogout()
    {
        session_unset();
        session_destroy();
        $this->jump("/");
    }
    
    public function actionProfile()
    {
        $this->title="用户中心";
        $this->url="account/profile";
        $this->bg=null;
        $users=new Model("users");

        if ($this->islogin) {
            $OPENID=$_SESSION['OPENID'];
        } else {
            return $this->jump("/");
        }

        $detail=getuserinfo($OPENID);
        if (!is_null($detail['real_name']) || $detail['real_name']==="null") {
            $display=$detail['real_name'];
        } else {
            $display=$detail['name'];
        }
        $detail['display_name']=$display;
        $this->detail=$detail;

        $course_register=new Model("course_register");
        $result=$course_register->query("select r.cid,course_name,course_logo,course_desc,course_color from course_register as r left join courses c on r.cid = c.cid where r.uid=:uid and status=1 limit 2", array(":uid"=>$this->userinfo['uid']));
        $this->result=$result;

        $contest=new Model("contest");
        $contest_result=$contest->query("select r.contest_id,c.name,creator,`desc`,type,start_date,end_date,r.`status`,due_register,image,o.`name` creator_name from contest_register r left join contest c on r.contest_id=c.contest_id left join organization o on c.creator = o.oid where uid=:uid and c.status=1 limit 2",array(":uid"=>$this->userinfo['uid']));
        foreach ($contest_result as &$r) {
            if ($r["start_date"]==$r["end_date"]) {
                $r["parse_date"]=$r["start_date"];
            } else {
                $r["parse_date"]=$r["start_date"]." ~ ".$r["end_date"];
            }
            if($r["status"]==1) $r["parse_status"]='<span class="wemd-green-text"><i class="MDI checkbox-marked-circle-outline"></i> 已成功报名</span>';
            else if($r["status"]==0) $r["parse_status"]='<span class="wemd-light-blue-text"><i class="MDI timer-sand"></i> 已提交报名</span>';
            else if($r["status"]==-1) $r["parse_status"]='<span class="wemd-red-text"><i class="MDI alert-circle-outline"></i> 报名已被拒绝</span>';
        }
        $this->contest_result=$contest_result;

        $storage=array();
        $storage["usage"]=getDirSize("/home/wwwroot/1cf/domain/1cf.co/web/i/img/atsast/upload/{$this->userinfo['uid']}");
        $storage["usage_string"]=sizeConverter($storage["usage"]);
        $storage["tot"]=$detail['cloud_size'];
        $storage["percent"]=$storage["usage"] / ($storage["tot"] * 1024 * 1024) * 100;
        if($storage["percent"]>=90) {
            $storage["color"]="red";
        } else if($storage["percent"]>=60) {
            $storage["color"]="amber";
        } else if($storage["percent"]>=40) {
            $storage["color"]="lime";
        } else {
            $storage["color"]="green";
        }
        $this->storage=$storage;

        if ($detail['album']=="bing") {
            $str = file_get_contents('http://www.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1&mkt=zh-CN');
            $array = json_decode($str);
            $this->imgurl="https://cn.bing.com/".$array->{"images"}[0]->{"url"};
            $copyright=$array->{"images"}[0]->{"copyright"};
            $imginfo=explode(" (", $copyright);
            $this->imgcopyright=trim(rtrim(@$imginfo[1], ")"));
            $imgname=explode("，", $imginfo[0]);
            $this->imgname=@$imgname[0];
            $this->imglocation=@$imgname[1];
            $this->imgcopyrightlink=$array->{"images"}[0]->{"copyrightlink"};
        } else {
            $this->imgurl="https://static.1cf.co/img/njupt.jpg";
        }
    }

    public function actionSettings()
    {
        $this->url="account/settings";
        $this->title="用户设置";
        $this->bg="";
        $users=new Model("users");
        if ($this->islogin) {
            $OPENID=$_SESSION['OPENID'];
        } else {
            return $this->jump("/");
        }
        $detail=getuserinfo($OPENID);
        $this->detail=$detail;
    }

    public function actionContests()
    {
        $this->url="account/contests";
        $this->title="报名比赛";
        $this->bg="";
        $users=new Model("users");

        if ($this->islogin) {
            $OPENID=$_SESSION['OPENID'];
        } else {
            return $this->jump("/");
        }


        $detail=getuserinfo($OPENID);
        if (!is_null($detail['real_name']) || $detail['real_name']==="null") {
            $display=$detail['real_name'];
        } else {
            $display=$detail['name'];
        }
        $detail['display_name']=$display;
        $this->detail=$detail;


        $contest=new Model("contest");
        $register_contest_result=$contest->query("select r.contest_id,c.name,creator,`desc`,type,start_date,end_date,r.`status`,due_register,image,o.`name` creator_name from contest_register r left join contest c on r.contest_id=c.contest_id left join organization o on c.creator = o.oid where uid=:uid and c.status=1",array(":uid"=>$this->userinfo['uid']));
        foreach ($register_contest_result as &$r) {
            if ($r["start_date"]==$r["end_date"]) {
                $r["parse_date"]=$r["start_date"];
            } else {
                $r["parse_date"]=$r["start_date"]." ~ ".$r["end_date"];
            }
            if($r["status"]==1) $r["parse_status"]='<span class="wemd-green-text"><i class="MDI checkbox-marked-circle-outline"></i> 已成功报名</span>';
            else if($r["status"]==0) $r["parse_status"]='<span class="wemd-light-blue-text"><i class="MDI timer-sand"></i> 已提交报名</span>';
            else if($r["status"]==-1) $r["parse_status"]='<span class="wemd-red-text"><i class="MDI alert-circle-outline"></i> 报名已被拒绝</span>';
        }
        $this->register_contest_result=$register_contest_result;
        
        $userdb=new Model("users");
        $sid=$userdb->find(["uid=:uid", ":uid"=>$this->userinfo['uid']])['SID'];
        $attend_contest_result=$contest->query("select r.contest_id,c.name,creator,`desc`,type,start_date,end_date,r.`status`,due_register,image,o.`name` creator_name from contest_register r left join contest c on r.contest_id=c.contest_id left join organization o on c.creator = o.oid where uid<>:uid and info like :info and c.status=1",array(":uid"=>$this->userinfo['uid'], ":info"=>'%"SID":"'.$sid.'"%'));
        foreach ($attend_contest_result as &$r) {
            if ($r["start_date"]==$r["end_date"]) {
                $r["parse_date"]=$r["start_date"];
            } else {
                $r["parse_date"]=$r["start_date"]." ~ ".$r["end_date"];
            }
            if($r["status"]==1) $r["parse_status"]='<span class="wemd-green-text"><i class="MDI checkbox-marked-circle-outline"></i> 已成功报名</span>';
            else if($r["status"]==0) $r["parse_status"]='<span class="wemd-light-blue-text"><i class="MDI timer-sand"></i> 已提交报名</span>';
            else if($r["status"]==-1) $r["parse_status"]='<span class="wemd-red-text"><i class="MDI alert-circle-outline"></i> 报名已被拒绝</span>';
        }
        $this->attend_contest_result=$attend_contest_result;

    }

	function actionActivate() {
        $this->url="account/activate";
        $this->title="激活账号";
        $this->bg="";

        $this->status="激活失败";
        $this->msg="抱歉，激活出了一些问题。";
        $this->color="danger";
        $this->icon="alert-circle-outline";
		if (arg("act")) {
			$act=arg("act");
			$db=new Model("users");
			$result=$db->find(array("OPENID=:act",":act"=>$act));
			if($result){
				$result=$db->update(array("OPENID=:act",":act"=>$act),array("verify_status"=>1,"cloud_size"=>100));
                $this->status="激活成功";
                $this->msg="恭喜，您的邮箱已经在OASIS激活成功。";
                $this->color="success";
                $this->icon="check-circle-outline";
			}
		}
	}

	function actionRetrieve() {
        $this->url="account/retrieve";
        $this->title="找回密码";
        $this->bg="";

        if($this->islogin){
            return $this->jump("/");
        }

		$password=arg("password");
		$this->step=1;
		$this->status="重置密码";
		$this->msg="请根据提示重置您的密码。";
		$this->color="info";
		$this->icon="lock-outline";
		$this->id=arg("id");
		$this->ret=arg("ret");
		$this->err=false;
		if(strlen($password)>=6 && strlen($password)<=20){
			$this->step=2;
		}else if(strlen($password)>0){
			$this->err="请设置一个长度在6到20之间的密码！";
		}
		if (arg("id") && arg("ret")) {
			if($this->step==2){
				$uid=arg("id");
				$ret=arg("ret");
				$db=new Model("users");
				$result=$db->find(array("uid=:uid",":uid"=>$uid));	
				if($result && sha1($result['OPENID'].$uid)==$ret){
					$OPENID=sha1(strtolower($result['email'])."@SAST+1s".md5($password));
					$result=$db->update(array("uid=:uid",":uid"=>$uid),array("OPENID"=>$OPENID));
					if($result){
						$this->status="重置密码成功";
						$this->msg="恭喜，您的密码已经在ATSAST重置成功。";
						$this->color="success";
						$this->icon="check-circle-outline";
					}
				}else{
					$this->status="重置密码失败";
					$this->msg="抱歉，重置密码出了一些问题。";
					$this->color="danger";
					$this->icon="alert-circle-outline";					
				}		
			}
		}else{
            $this->step=0;
		}
	}
}
