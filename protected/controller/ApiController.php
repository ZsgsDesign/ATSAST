<?php

class ApiController extends BaseController
{
    public function actionTest()
    {
        $submit_time=date("Y-m-d H:i:s");
        SUCCESS::Catcher("成功！", array("time"=>$submit_time));
    }
}
