<?php
class TermsController extends BaseController
{
    public function actionPrivacy()
    {
        $this->title="隐私条款";
    }

    public function actionService()
    {
        $this->title="服务条款";
    }
}
