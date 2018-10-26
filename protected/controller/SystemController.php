<?php
class SystemController extends BaseController
{
    public function actionIndex()
    {
        if (!($this->islogin)) {
            return $this->jump("/account");
        }
        $this->jump("/system/logs");
    }
    public function actionLogs()
    {
        $this->url="system/logs";
        $this->title="版本日志";
        $this->bg="";
    }

    public function actionBugs()
    {
        $this->url="system/bugs";
        $this->title="汇报BUG";
        $this->bg="";

        if (!($this->islogin)) {
            return $this->jump("/account");
        }
    }
}
