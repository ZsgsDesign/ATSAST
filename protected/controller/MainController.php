<?php
class MainController extends BaseController {
	
	function actionIndex(){
		$this->url="index";
		$this->title="发现";

		$str = file_get_contents('http://www.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1&mkt=zh-CN');
		$array = json_decode($str);
		$this->imgurl="https://cn.bing.com/".$array->{"images"}[0]->{"url"};
		$copyright=$array->{"images"}[0]->{"copyright"};
		$imginfo=explode(" (",$copyright);
		$this->imgcopyright=trim(rtrim(@$imginfo[1],")"));
		$imgname=explode("，",$imginfo[0]);
		$this->imgname=@$imgname[0];
		$this->imglocation=@$imgname[1];
		$this->imgcopyrightlink=$array->{"images"}[0]->{"copyrightlink"};

	}

	function actionCourses() {
		$this->url="courses";
		$this->title="课程";
		$db=new Model("courses");
		$result=$db->findAll(null,"cid asc");
		$this->result=$result;
	}

    function actionCourse() {
        $this->jump("/courses");
	}
	
	function actionSystem() {
        $this->jump("/system/logs");
    }

	function actionContests() {
		$this->url="contests";
		$this->title="赛事";
	}

	function actionSearch() {
		$this->url="search";
		$this->title="搜索结果";
		$keyword=arg("q");
		if(is_null($keyword)){
			$this->jump("/");
		}else{
			$this->keyword=$keyword;
		}
	}

	// The following codes were the remaining of ocf period 
	
	
	function actionAbout() {
		$this->url="about";
		$this->title="关于我们";
	}
	
	function actionCredit() {
		$this->url="credit";
		$this->title="致谢";
	}

	function actionHelp() {
		$this->url="help";
		$this->title="帮助中心";
	}

	function actionBase() {
		$this->url="base";
		$this->title="题库";
		setcookie("pre", "0","86400000000","/","1cf.co");
		$db=new Model("bases");
		$this->result=$db->findAll(
			null,
			"cata ASC, bid ASC",
			"*"
		);
	}

	function actionRank() {
		$this->url="rank";
		$this->title="排行榜";
		$db=new Model("users");
		$result=$db->findAll(
			array(
				"uid<>:uid1",
				"uid1"=>59
			),
			"credit desc,name asc",
			"uid,name,avatar,credit",
			20
		);
		$result[0]['rank']=1;
		$result[0]['url']="/user/".urlencode($result[0]['uid']);
		for ($i=1;$i<count($result);$i++) {
			if ($result[$i]['credit']==$result[$i-1]['credit']) $result[$i]['rank']=$result[$i-1]['rank'];
			else $result[$i]['rank']=$i+1;
			$result[$i]['url']="/user/".$result[$i]['uid'];
		}
		//dump($result);
		$this->result=$result;
	}

	function actionGrantee() {
		$this->url="grantee";
		$this->title="捐助";
		$db=new Model("grantee");
		$result=$db->findAll(null,"gid asc");
		$gb=new Model("log");
		for ($i=0;$i<count($result);$i++) {
			$result[$i]['rate']=round($result[$i]['current']/$result[$i]['target']*100,2);
			$count=$gb->query("select count(distinct(ip)) as count from log where gid=:gid",
												array(":gid"=>$result[$i]['gid']));
			$result[$i]['count'] = $count[0]['count'];
		}
		//dump($result);
		$this->result=$result;
		$user_db=new Model("users");
		$result=$user_db->find(
			array(
				"loginid=:loginid",
				":loginid"=>@$_SESSION['loginid']
			)
		);
		$this->userscore=$result['score'];
	}

	
	
}