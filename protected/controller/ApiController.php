<?php

class ApiController extends BaseController {

	//function actionTest() {
		//$requestBody = file_get_contents("php://input");
		//file_put_contents("git-webhook_log.txt", $requestBody, FILE_APPEND);//写入日志到log文件中
    	//echo json_encode($output); 
	//}

	function actionGetPost() {
		$db=new Model("posts");
		$result1=$db->query("select * from posts as p left join users u on p.uid = u.uid WHERE visibility=1 and present =".arg("present")." order by pid desc");
		if($result1){
            $output=$result1[0];
	    }else{
	        $output=array(
        		'result'=>0
        	);
	    }
    	echo json_encode($output); 
	}
	
	function actionGetPosts() {
		$db=new Model("posts");
		if(arg('tag')) $tag=" AND (tag = '".arg('tag')."' OR tag = '会务') ";
		else $tag="";
		$result1=$db->query("select * from posts as p left join users u on p.uid = u.uid WHERE visibility=1 and present =".arg("present")." and pid<".arg("pid").$tag." order by pid desc limit 10");
		if($result1){
            $output=$result1;
	    }else{
	        $output=array(
        		'result'=>0
        	);
	    }
    	echo json_encode($output); 
	}
	
	function actionGetComments() {
		$db=new Model("posts_comment");
		$result1=$db->query("select * from posts_comment as p left join users u on p.uid = u.uid WHERE pid =".arg("pid")." order by p.pcid desc");
		if($result1){
            $output=$result1;
	    }else{
	        $output=array(
        		'result'=>0
        	);
	    }
    	echo json_encode($output); 
	}
	
	function actionDeletePostComment() {
		$db=new Model("posts_comment");
        $condition = array('pcid'=>arg("pcid")); // 构造条件
        $result1=$db->delete($condition); 		
        $output=array(
    		'result'=>$result1
    	);
    	echo json_encode($output); 
	}
	
	function actionGetLikes() {
		$db=new Model("posts_like");
		$result=0;
		$like=0;
		$result1=$db->query("select COUNT(pid) as \"result\" from posts_like WHERE pid =".arg("pid"));
		if($result1){
            $result=$result1[0]["result"];
            $result1=$db->find(array("uid=:uid and pid=:pid",":uid"=>arg("uid"),":pid"=>arg("pid")));
            if($result1){
                $like=1;
            }
	    }
        $output=array(
    		'result'=>$result,
    		'like'=>$like
    	);
    	echo json_encode($output); 
	}
	
	function actionGetPostDetails() {
		$db=new Model("posts");
		$result1=$db->query("select * from posts as p left join users u on p.uid = u.uid WHERE pid =".arg("pid"));
		if($result1){
            $output=$result1[0];
	    }else{
	        $output=array(
        		'result'=>0
        	);
	    }
    	echo json_encode($output); 
	}

	function actionGetFiles() {
		$db=new Model("files");
		$result1=$db->findAll(array("present=:present",":present"=>arg("present")));
		if($result1){
            $output=$result1;
	    }else{
	        $output=array(
        		'result'=>0
        	);
	    }
    	echo json_encode($output); 
	}
	
	function actionGetUserDetails() {
		$db=new Model("users");
		if(arg("verify")==1){
		    $result1=$db->findAll(array("uid=:uid and password=:password",":uid"=>arg("uid"),":password"=>arg("password")));
		}else{
		    $result1=$db->query("select * from users as p left join data u on p.uid = u.uid WHERE u.uid =".arg("uid"));
		}
		if($result1){
            $output=$result1[0];
	    }else{
	        $output=array(
        		'uid'=>0
        	);
	    }
    	echo json_encode($output); 
	}
    
	function actionLogin() {
		$db=new Model("users");
		if(strpos(arg("ticket"),'@')){
		    //Login via email
		    $result1=$db->find(array("email=:ticket and password=:password",":ticket"=>arg("ticket"),":password"=>md5(arg("password"))));
		}else{
		    //Login via username
		    $result1=$db->find(array("name=:ticket and password=:password",":ticket"=>arg("ticket"),":password"=>md5(arg("password"))));
		}
		if($result1){
            $output=$result1;
	    }else{
	        $output=array(
        		'uid'=>0
        	);
	    }
	    //echo arg("ticket");
    	echo json_encode($output); 
	}
	
	function actionChangePassword() {
		$db=new Model("users");
		$result=$db->find(array("uid=:uid and password=:password",":uid"=>arg("uid"),":password"=>md5(arg("password"))));
		if($result){
            $output=array(
        		'result'=>-1
        	);		    
		}else{
            $result=$db->update(array('uid'=>arg("uid")), array('password'=>md5(arg("password")),'insecure'=>0));
            $output=array(
        		'result'=>$result,
        		'password'=>md5(arg("password"))
        	);
		}		    
    	echo json_encode($output); 
	}
	
	function actionSignup() {
		$db=new Model("users");
		    $result1=$db->find(array("email=:email or name=:name",":email"=>arg("email"),":name"=>arg("name")));
		if($result1){
		    //Already taken
		    $output=array(
        		'result'=>0
        	);
	    }else{
            //$output=$result1;
            //We may proceed to insert this record
            //moves like a jagger - Maroon 5
            $newrow = array(
                'name' => arg("name"),
                'email' => arg("email"),
                'display_name' => arg("display_name"),
                'real_name' => arg("real_name"),
                'password' => md5(arg("password")),
            );
            $result1=$db->create($newrow);  // 进行新增操作 
            $output=array(
        		'result'=>$result1
        	);
	    }
    	echo json_encode($output); 
	}
	
	function actionGetCredits() {
		$db=new Model("credit");
		$result1=$db->query("SELECT SUM( amount ) AS  \"result\" FROM credit WHERE uid =".arg("uid"));
		if($result1){
            $output=$result1[0];
            if(is_null($output["result"]))$output["result"]=0;
	    }else{
	        $output=array(
        		'result'=>0
        	);
	    }
    	echo json_encode($output); 
	}
	
	function actionGetCreditDetails() {
		$db=new Model("credit");
		$result1=$db->findAll(array("uid=:uid order by cid desc",":uid"=>arg("uid")));
		if($result1){
            $output=$result1;
	    }else{
	        $output=array(
        		'result'=>0
        	);
	    }
    	echo json_encode($output); 
	}
	
	function actionTransfer() {
	    if(arg("value")<=0){
            $output=array(
    	    	'result'=>-4
    	    ); //钱不能负数啊
        }else{
    		$db=new Model("credit");
    		$result1=$db->query("SELECT SUM( amount ) AS  \"result\" FROM credit WHERE uid =".arg("uid"));
    		if($result1){
                $output=$result1[0]["result"];
                if($output<arg("value")){
                    $output=array(
            	    	'result'=>-1
            	    ); //钱不够啊
                }else{
                    $db2=new Model("users");
                    if(strpos(arg("ticket"),'@')){
                        //email
                        $result1=$db2->find(array("email=:email",":email"=>arg("ticket")));
                    }else{
                        //name
                        $result1=$db2->find(array("name=:name",":name"=>arg("ticket")));
                    }
                    if($result1){
                        $uid=$result1["uid"];
                        if($uid==arg("uid")){
                            $output=array(
                    		    'result'=>-3
                    	    );   
                        }else{
                            $newrow = array(
                                'uid' => arg("uid"),
                                'amount' => -arg("value"),
                                'comment' => "转账给 ".arg("ticket"),
                                'type' => 1,
                            );
                            $result1=$db->create($newrow);  // 进行新增操作 
                            $result1=$db2->find(array("uid=:uid",":uid"=>arg("uid")));
                            $result1=$result1["email"];
                        	$newrow = array(
                                'uid' => $uid,
                                'amount' => arg("value"),
                                'comment' => "来自 ".$result1." 的转账",
                                'type' => 1,
                            );
                            $result1=$db->create($newrow);  // 进行新增操作 
                            $output=array(
                        		'result'=>$result1
                        	);  
                            
                        }   
                    }else{
            	        $output=array(
                    		'result'=>-2
                    	);          
                    	//User not found           
                    }
                }
    	    }else{
    	        $output=array(
            		'result'=>0
            	);
    	    }
                
        }
    	echo json_encode($output); 
	}
	function actionBuy() {
	    $db=new Model("credit");
	    $db2=new Model("item");
	    $db3=new Model("users");
	    $result1=$db2->find(array("iid=:iid",":iid"=>arg("iid")));
	    $item_name=$result1["name"];
	    $item_price=$result1["price"];
	    $item_owner=$result1["owner"];
		$result1=$db->query("SELECT SUM( amount ) AS  \"result\" FROM credit WHERE uid =".arg("uid"));
		if($result1){
            $output=$result1[0]["result"];
            if($output<$item_price){
                $output=array(
        	    	'result'=>-1
        	    ); //钱不够啊
            }else{
                $newrow = array(
                    'uid' => arg("uid"),
                    'amount' => -$item_price,
                    'comment' => "购买 ".$item_name,
                    'type' => 0,
                    'confirm' => 0
                );
                $result1=$db->create($newrow);  // 进行新增操作 
                $result1=$db3->find(array("uid=:uid",":uid"=>arg("uid")));
                $result1=$result1["real_name"];
            	$newrow = array(
                    'uid' => $item_owner,
                    'amount' => $item_price,
                    'comment' => "来自 ".$result1." 的购买",
                    'type' => 2,
                    'confirm' => 0
                );
                $result1=$db->create($newrow);  // 进行新增操作 
                $output=array(
            		'result'=>$result1,
            		'item_name'=>$item_name,
            		'item_price'=>$item_price
            	);  
            }
	    }else{
	        $output=array(
        		'result'=>0
        	);
	    }
    	echo json_encode($output); 	    
	}
	function actionBuyViaCode() {
	    $db=new Model("credit");
	    $db2=new Model("item");
	    $db3=new Model("users");
	    $result1=$db3->find(array("uid=:uid and password=:password",":uid"=>arg("uid"),":password"=>arg("password")));
	    $item_name=arg("item_name");
	    $item_price=arg("item_price");
	    $item_owner="3";
		$result1=$db->query("SELECT SUM( amount ) AS  \"result\" FROM credit WHERE uid =".arg("uid"));
		if($result1){
            $output=$result1[0]["result"];
            if($output<$item_price){
                $output=array(
        	    	'result'=>-1
        	    ); //钱不够啊
            }else{
                $newrow = array(
                    'uid' => arg("uid"),
                    'amount' => -$item_price,
                    'comment' => "购买 ".$item_name,
                    'type' => 0,
                    'confirm' => 1
                );
                $result1=$db->create($newrow);  // 进行新增操作 
                $result1=$db3->find(array("uid=:uid",":uid"=>arg("uid")));
                $result1=$result1["real_name"];
            	$newrow = array(
                    'uid' => $item_owner,
                    'amount' => $item_price,
                    'comment' => "来自 ".$result1." 的购买",
                    'type' => 2,
                    'confirm' => 11
                );
                $result1=$db->create($newrow);  // 进行新增操作 
                $output=array(
            		'result'=>$result1,
            		'item_name'=>$item_name,
            		'item_price'=>$item_price
            	);  
            }
	    }else{
	        $output=array(
        		'result'=>0
        	);
	    }
    	echo json_encode($output); 	    
	}
	function actionConfirmBuy() {
		$db=new Model("credit");
		$cid=arg("cid");
    	$condition = array("cid=:cid or cid=:cid2",":cid"=>$cid,":cid2"=>$cid-1);
        $result1=$db->update($condition, array('confirm'=>1));
        $output=array(
    		'result'=>$result1
    	); 
    	echo json_encode($output); 
	}
	function actionCommentPost() {
		$db=new Model("posts_comment");
    	$newrow = array(
            'uid' => arg("uid"),
            'pid' => arg("pid"),
            'content' => arg("content"),
            'date' => date('Y-m-d H:i:s')
        );
        $result1=$db->create($newrow);  // 进行新增操作 
        $output=array(
    		'result'=>$result1
    	); 
    	echo json_encode($output); 
	}
	function actionLikePost() {
		$db=new Model("posts_like");
		$result1=$db->find(array("uid=:uid and pid=:pid",":uid"=>arg("uid"),":pid"=>arg("pid")));
    	if($result1){
    	    $condition = array("uid"=>arg("uid"),"pid"=>arg("pid")); // 构造条件
            $db->delete($condition); 
            $output=array(
        		'result'=>-1
        	); 
    	}else{
        	$newrow = array(
                'uid' => arg("uid"),
                'pid' => arg("pid")
            );
            $result1=$db->create($newrow);  // 进行新增操作 
            $output=array(
        		'result'=>1
        	); 
    	}
    	echo json_encode($output); 
	}
	function actionCreatePost() {
		$db=new Model("posts");
        $newrow = array(
                'present' => "100001",
                'uid' => arg("uid"),
                'title' => arg("title"),
                'content' => arg("content"),
                'tag' => arg("tag"),
                'date' => date('Y-m-d H:i:s'),
                'visibility' => arg("visibility")
            );
        $result1=$db->create($newrow);  // 进行新增操作 
        $output=array(
    		'result'=>$result1
    	); 
    	echo json_encode($output); 
	}
	function actionInspectPost() {
		$db=new Model("posts");
		$pid=arg("pid");
    	$condition = array("pid=:pid",":pid"=>$pid);
        $result1=$db->update($condition, array('visibility'=>arg("visibility")));
        $output=array(
    		'result'=>$result1
    	); 
    	echo json_encode($output); 
	}
	function actionModifyPost() {
		$db=new Model("posts");
		$pid=arg("pid");
    	$condition = array("pid=:pid",":pid"=>$pid);
    	        $newrow = array(
                'present' => "100001",
                'uid' => arg("uid"),
                'title' => arg("title"),
                'content' => arg("content"),
                'tag' => arg("tag"),
                'visibility' => arg("visibility")
            );
        $result1=$db->update($condition, $newrow);
        $output=array(
    		'result'=>$result1
    	); 
    	echo json_encode($output); 
	}
	function actionJoinAuctionGroup() {
		$db=new Model("data");
		$result1=$db->find(array("auction_name=:auction_name",":auction_name"=>arg("auction_name")));
		if($result1){
		    //there is a group
		    $auction_group=$result1["auction_group"];
		    $condition = array('uid'=>arg("uid"));
            $result1=$db->update($condition, array("auction_group"=>$auction_group));
            $output=array(
        		'result'=>$auction_group,
        		'auction_name'=>arg("auction_name")
        	); 
		}else{
            $output=array(
        		'result'=>-1
        	);
        	//no such group	    
		}
    	echo json_encode($output); 
	}
	function actionSignAuctionGroup() {
		$db=new Model("data");
		$result1=$db->find(array("auction_name=:auction_name",":auction_name"=>arg("auction_name")));
		if($result1){
		    //there is a group
            $output=array(
        		'result'=>-1
        	); 
		}else{
            $condition = array('uid'=>arg("uid"));
            $result1=$db->update($condition, array("auction_name"=>arg("auction_name"),"auction_group"=>arg("uid")));
            $output=array(
        		'result'=>$result1
        	); 
        	//no such group	    
		}
    	echo json_encode($output); 
	}
	function actionExitAuctionGroup() {
		$db=new Model("data");
		if(arg("uid")==arg("auction_group")){
		    //delete all the group
		    $condition = array('uid'=>arg("uid"));
            $db->update($condition, array('auction_name'=>''));
		    $condition = array('auction_group'=>arg("auction_group"));
            $result1=$db->update($condition, array('auction_group'=>'0'));
		}else{
		    $condition = array('uid'=>arg("uid"));
            $result1=$db->update($condition, array('auction_group'=>'0'));		    
		}
        $output=array(
    		'result'=>$result1
    	); 
    	echo json_encode($output); 
	}
	function actionGetAuctionName() {
		$db=new Model("data");
		$result1=$db->find(array("uid=:uid",":uid"=>arg("auction_group")));
    	if($result1){
            $output=array(
        		'auction_name'=>$result1["auction_name"]
        	); 
    	}else{
        	$output=array(
        		'auction_name'=>""
        	); 
    	}
    	echo json_encode($output); 
	}
	function actionGetAuctionMembers() {
		$db=new Model("data");
		$result1=$db->query("select * from users as p left join data u on p.uid = u.uid WHERE u.auction_group =".arg("auction_group"));
    	if($result1){
            $output=$result1;
    	}else{
        	$output=array(
        		'result'=>0
        	); 
    	}
    	echo json_encode($output); 
	}
	function actionAddCredit() {
		$db=new Model("credit");
		for($i=1;$i<=99;$i++){
		   	$newrow = array( // PHP的数组
                'uid' => $i,
                'amount' => 5,
                'comment' => "2月12日主席工资",
                'type' => 2,
                'confirm' => 1
            );
            $db->create($newrow);  // 进行新增操作   
            echo $i;
            echo "：成功<br>";
		}
    	//echo json_encode($output); 
	}
	function actionTest() {
		var_dump(arg('parameters'));
	}
}

