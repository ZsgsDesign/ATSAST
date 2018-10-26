<?php
class TermsController extends BaseController {
	
	function actionPrivacy(){
    $this->title="隐私条款";
  }

  function actionService(){
    $this->title="服务条款";
  }
}