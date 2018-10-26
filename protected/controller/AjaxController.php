<?php
class AjaxController extends BaseController {

	function actionSubmitCodes() {
		if (!($this->islogin)) ERR::Catcher(2001);
        if (arg("cid") && arg("syid") && arg("hid")) {
            $db=new Model("courses");
            $cid=arg("cid");
            $syid=arg("syid");
            $hid=arg("hid");
            if(is_numeric($cid) && is_numeric($syid)) {
                $homework=new Model("homework");
                $homework_submit=new Model("homework_submit");
                $organization=new Model("organization");
                $syllabus=new Model("syllabus");
                $result=$db->find(array("cid=:cid",":cid"=>$cid));
                $course_register=new Model("course_register");
                if ($this->islogin) $register_status=$course_register->find(array("cid=:cid and uid=:uid",":cid"=>$cid,":uid"=>$this->userinfo['uid']));
                if(empty($register_status)) ERR::Catcher(3001);
                $syllabus_info=$syllabus->find(array("cid=:cid",":cid"=>$cid));
                if(empty($result) || empty($syllabus_info)) ERR::Catcher(3003);
                $creator=$organization->find(array("oid=:oid",":oid"=>$result['course_creator']));
                $result['creator_name']=$creator['name'];
                $result['creator_logo']=$creator['logo'];
                $homework_details=$homework->find(array("hid=:hid and cid=:cid and syid=:syid",":hid"=>$hid,":cid"=>$cid,":syid"=>$syid));
                if(empty($homework_details)) ERR::Catcher(3004);
                $homework_submit_status=$homework_submit->find(array("hid=:hid and cid=:cid and syid=:syid and uid=:uid",":hid"=>$hid,":cid"=>$cid,":syid"=>$syid,":uid"=>$this->userinfo['uid']));

                if(arg("action")=="submit"){
                    if (empty($homework_submit_status)) {
                        $submit_time=date("Y-m-d H:i:s");
                        $newrow=array(
                            "cid"=>$cid,
                            "hid"=>$hid,
							"syid"=>$syid,
							"uid"=>$this->userinfo['uid'],
							"submit_content"=>arg("content"),
							"submit_time"=>$submit_time,
						);
                        $homework_submit->create($newrow);
                        return SUCCESS::Catcher("提交成功",array("time"=>$submit_time));
                    }else{
                        $submit_time=date("Y-m-d H:i:s");
						$homework_submit->update(
							array(
								"hid=:hid and cid=:cid and syid=:syid and uid=:uid",
                                ":cid"=>$cid,
                                ":hid"=>$hid,
								":syid"=>$syid,
								":uid"=>$this->userinfo['uid']
							),
							array(
								"submit_content"=>arg("content"),
								"submit_time"=>$submit_time,
							)
						);
                        SUCCESS::Catcher("重新提交成功",array("time"=>$submit_time));				
					}
                }
            } else ERR::Catcher(1004);
        } else ERR::Catcher(1003);

    }
    
    function actionSubmitBugs() {
		if (!($this->islogin)) ERR::Catcher(2001);
        if (arg("title") && arg("desc")) {
            $title=arg("title");
            $desc=arg("desc");
            if((!empty($title) || (is_numeric($title) && $title==0)) && (!empty($title) || (is_numeric($desc) && $desc==0))) {
                $bug=new Model("bug");
                $submit_time=date("Y-m-d H:i:s");
                $newrow=array(
                    "version"=>$this->version_info['version'],
                    "subversion"=>$this->version_info['subversion'],
                    "uid"=>$this->userinfo['uid'],
                    "desc"=>$desc,
                    "title"=>$title,
                    "status"=>0,
                    "release_time"=>$submit_time,
                );
                $bug->create($newrow);
                SUCCESS::Catcher("提交成功");
            } else ERR::Catcher(1004);
        } else ERR::Catcher(1003);

	}
	
	function actionchangeAlbum() {
		if (!($this->islogin)) ERR::Catcher(2001);
        if (arg("album")) {
            $album=arg("album");
            if($album=="bing" || $album=="njupt") {
                $users=new Model("users");
                $users->update( array("uid=:uid",":uid"=>$this->userinfo['uid']),array('album'=>$album));
                SUCCESS::Catcher("提交成功");
            } else ERR::Catcher(1004);
        } else ERR::Catcher(1003);

	}
	
	function actionUpdateInfo() {
		if (!($this->islogin)) ERR::Catcher(2001);
        if (arg("real_name") && arg("name") && (arg("gender") || arg("gender")==0)) {
			$real_name=arg("real_name");
			$name=arg("name");
			$gender=arg("gender");
            if(is_numeric($gender) && ($gender==0 || $gender==1 || $gender==2) ) {
                $users=new Model("users");
                $users->update( array("uid=:uid",":uid"=>$this->userinfo['uid']),array('real_name'=>$real_name,'name'=>$name,'gender'=>$gender));
                SUCCESS::Catcher("提交成功");
            } else ERR::Catcher(1004);
        } else ERR::Catcher(1003);

    }
    
    function actionUploadAvatar() {
        if (!($this->islogin)) ERR::Catcher(2001);
        $uid=$this->userinfo['uid'];
        $type = array("jpg", "gif", "bmp", "jpeg", "png");
        @$fileext = strtolower(substr(strrchr($_FILES['file']['name'], "."), 1));
        if (in_array($fileext, $type) && is_uploaded_file($_FILES['file']['tmp_name'])) {
            $image = $_FILES['file']['tmp_name']; // Original
            $imgstream = file_get_contents($image);
            $im = imagecreatefromstring($imgstream);
            $x = imagesx($im); // Get the width of the image
            $y = imagesy($im); // Get the height of the image
            
            $xx = 256;
            $yy = 256;
            
            if ($x>$y) {
                // h < w
                $sx = abs(($y-$x)/2);
                $sy = 0;
                $thumbw = $y;
                $thumbh = $y;
            } else {
                //h >= w
                $sy = abs(($x-$y)/2);
                $sx = 0;
                $thumbw = $x;
                $thumbh = $x;
            }

            if (function_exists("imagecreatetruecolor")) {
                $dim = imagecreatetruecolor($yy, $xx);
            } else {
                $dim = imagecreate($yy, $xx);
            }
            imageCopyreSampled($dim, $im, 0, 0, $sx, $sy, $yy, $xx, $thumbw, $thumbh);
            imageinterlace($dim, true);
            $stamp=time().rand(0, 9);
            if (!file_exists("/home/wwwroot/1cf/domain/1cf.co/web/i/img/atsast/upload/$uid")) {
                mkdir("/home/wwwroot/1cf/domain/1cf.co/web/i/img/atsast/upload/$uid", 0777, true);
            }
            imagejpeg($dim, "/home/wwwroot/1cf/domain/1cf.co/web/i/img/atsast/upload/$uid/$stamp.jpg", 100);
            $avatar = "https://static.1cf.co/img/atsast/upload/$uid/$stamp.jpg";
            $users = new Model("users");
            $result = $users -> find(array("uid = :uid", ':uid' => $uid));
            if ($result) {
                $result = $users -> update(array("uid = :uid", ':uid' => $uid), array("avatar" => $avatar));
            } else {
				ERR::Catcher(1002);
            }
            SUCCESS::Catcher("头像更新成功",array("path"=>$avatar));
        } else {
            ERR::Catcher(1005);
        }
    }

    function actionSubmitFile(){
		if (!($this->islogin)) ERR::Catcher(2001);
        if (arg("cid") && arg("syid") && arg("hid")) {
            $db=new Model("courses");
            $cid=arg("cid");
            $syid=arg("syid");
            $hid=arg("hid");
            if(is_numeric($cid) && is_numeric($syid)) {
                $homework=new Model("homework");
                $homework_submit=new Model("homework_submit");
                $organization=new Model("organization");
                $syllabus=new Model("syllabus");
                $result=$db->find(array("cid=:cid",":cid"=>$cid));
                $course_register=new Model("course_register");
                if ($this->islogin) $register_status=$course_register->find(array("cid=:cid and uid=:uid",":cid"=>$cid,":uid"=>$this->userinfo['uid']));
                if(empty($register_status)) ERR::Catcher(3001);
                $syllabus_info=$syllabus->find(array("cid=:cid",":cid"=>$cid));
                if(empty($result) || empty($syllabus_info)) ERR::Catcher(3003);
                $creator=$organization->find(array("oid=:oid",":oid"=>$result['course_creator']));
                $result['creator_name']=$creator['name'];
                $result['creator_logo']=$creator['logo'];
                $homework_details=$homework->find(array("hid=:hid and cid=:cid and syid=:syid",":hid"=>$hid,":cid"=>$cid,":syid"=>$syid));
                if(empty($homework_details)) ERR::Catcher(3004);
                $homework_submit_status=$homework_submit->find(array("hid=:hid and cid=:cid and syid=:syid and uid=:uid",":hid"=>$hid,":cid"=>$cid,":syid"=>$syid,":uid"=>$this->userinfo['uid']));

                if(arg("action")=="submit"){
                    $uid=$this->userinfo['uid'];
                    $type = array("7z","csv","dbf","doc","docx","dwg","gif","iso","jpg","pdf","png","ppt","pptx","psd","rar","rtf","svg","tiff","txt","xls","xlsx","xml","zip");
                    @$fileext = strtolower(substr(strrchr($_FILES['file']['name'], "."), 1));
                    if (in_array($fileext, $type) && is_uploaded_file($_FILES['file']['tmp_name'])) {
                        $file = $_FILES['file']['tmp_name']; // Original
                        $filestream = file_get_contents($file);
                        
                        $stamp=time().rand(0, 9);
                        if (!file_exists("/home/wwwroot/1cf/domain/1cf.co/web/i/img/atsast/upload/$uid")) {
                            mkdir("/home/wwwroot/1cf/domain/1cf.co/web/i/img/atsast/upload/$uid", 0777, true);
                        }
                        file_put_contents("/home/wwwroot/1cf/domain/1cf.co/web/i/img/atsast/upload/$uid/[$stamp]".$_FILES['file']['name'],$filestream);
                        $link="https://static.1cf.co/img/atsast/upload/$uid/[$stamp]".$_FILES['file']['name'];
                    } else {
                        ERR::Catcher(1005);
                    }

                    if (empty($homework_submit_status)) {
                        $submit_time=date("Y-m-d H:i:s");
                        $newrow=array(
                            "cid"=>$cid,
                            "hid"=>$hid,
							"syid"=>$syid,
							"uid"=>$uid,
							"submit_content"=>$link,
							"submit_time"=>$submit_time,
						);
                        $homework_submit->create($newrow);
                        return SUCCESS::Catcher("提交成功",array("time"=>$submit_time,"file_name"=>"[$stamp]".$_FILES['file']['name'],"file_extension"=>$fileext,"file_link"=>$link));
                    }else{
                        $submit_time=date("Y-m-d H:i:s");
						$homework_submit->update(
							array(
								"hid=:hid and cid=:cid and syid=:syid and uid=:uid",
                                ":cid"=>$cid,
                                ":hid"=>$hid,
								":syid"=>$syid,
								":uid"=>$uid
							),
							array(
								"submit_content"=>$link,
								"submit_time"=>$submit_time,
							)
						);
                        SUCCESS::Catcher("重新提交成功",array("time"=>$submit_time,"file_name"=>"[$stamp]".$_FILES['file']['name'],"file_extension"=>$fileext,"file_link"=>$link));				
					}
                }
            } else ERR::Catcher(1004);
        } else ERR::Catcher(1003);

    }

}