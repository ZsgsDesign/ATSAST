<?php
class AccountController extends BaseController {

	private function account_err_report($msg,$current=1) {
		$this->current=$current;
		return $this->msg1=$msg;
	}

	function actionIndex() {
		$this->current=0;
		if(@$_SESSION['OPENID']) $this->jump("/account/profile"); else $this->title="登录 / 注册";
		$this->url="ucenter";
		$this->msg1=$this->msg2="";
		$action=arg("action");
		if ($action==="register") { //如果是注册

			$db=new Model("users");
			$password=arg("password");
			$email=arg("email");
			$pattern="/^(\w){6,100}$/";
			if(empty($password) || empty($email)) {
				return self::account_err_report("请不要皮这个系统");
			}
			if(!preg_match($pattern,$password)){ 
				return self::account_err_report("请设置6位以上密码，不要过长");
			}

			if(filter_var($email, FILTER_VALIDATE_EMAIL)==false){
				return self::account_err_report("请输入合法的邮箱");
			}

			$username=strtoupper(explode('@',$email)[0]);
			$SID=$username;
			$email_domain=explode('@',$email)[1];

			if($email_domain!="njupt.edu.cn"){
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
				'OPENID'=>$OPENID,
				'avatar'=>"https://static.1cf.co/img/avatar/default.png",
				'gender'=>0
			);
			$json=$db->create($user);
			$_SESSION['OPENID']=$OPENID;
			//sendactivatemail();
			$this->jump("/");

			//echo json_encode($output);

		} else if($action==="login") { //如果是登录

			$email=arg("email");
			$password=arg("password");

			if(empty($password) || empty($email)) {
				return self::account_err_report("请不要皮这个系统",0);
			}

			$OPENID=sha1(strtolower($email)."@SAST+1s".md5($password));
			$db=new Model("users");
			$result=$db->find(array("OPENID=:OPENID",":OPENID"=>$OPENID));
			if (empty($result)) {
				return self::account_err_report("邮箱或密码错误",0);
			} else {
				$_SESSION['OPENID']=$OPENID;
				$this->jump("/");
			}

		}
	}

	function actionLogout() {
		session_unset();
		session_destroy();
		$this->jump("/");
	}

	function actionActivate() {
		// One-Cent Fund
		// remain unchanged
		if (arg("id") && arg("act")) {
			$uid=arg("id");
			$act=arg("act");
			$db=new Model("users");
			$result=$db->find(
				array(
					"uid=:uid",
					":uid"=>$uid
				)
			);
			$email=$result['email'];
			if(md5(md5($email))==$act){
				$result=$db->update(
					array(
						"uid=:uid",
						":uid"=>$uid
					),
					array(
						"emailok"=>1
					)
				);
			}
		}
	}
	
	function actionProfile() {
		$this->title="用户中心";
		$this->url="account/profile";
		$this->bg=null;
		$users=new Model("users");

		if($this->islogin){
			$OPENID=$_SESSION['OPENID'];
		}else{
			return $this->jump("/");
		}

		$detail=getuserinfo($OPENID);
		if(!is_null($detail['real_name']) || $detail['real_name']==="null") $display=$detail['real_name'];
		else $display=$detail['name'];
		$detail['display_name']=$display;
		$this->detail=$detail;

		$course_register=new Model("course_register");
		$result=$course_register->query("select r.cid,course_name,course_logo,course_desc,course_color from course_register as r left join courses c on r.cid = c.cid where r.uid=:uid and status=1 limit 2",array(":uid"=>$this->userinfo['uid']));
		$this->result=$result;
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

	function actionSettings() {
		$this->url="account/settings";
		$this->title="用户设置";
		$this->bg="";
		$users=new Model("users");
		if($this->islogin){
			$OPENID=$_SESSION['OPENID'];
		}else{
			return $this->jump("/");
		}
		$detail=getuserinfo($OPENID);
		$this->detail=$detail;
	}
}