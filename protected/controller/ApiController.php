<?php

class ApiController extends BaseController {

	function actionTest() {
		SUCCESS::Catcher("成功！",array("time"=>$submit_time));	
	}
}

