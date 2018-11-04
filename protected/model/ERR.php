<?php

class ERR {
    
    /**
     * An old-fashioned error catcher mainly to provide error description
     * existed here only to avoid direct SQL database access
     * return a hundred present pure string
     *
     * @author John Zhang
     * @param string $ERR_CODE
     */

    public static function Catcher($ERR_CODE)
    {
        if(($ERR_CODE<1000)) $ERR_CODE=1000;
        $output=array(
             'ret' => $ERR_CODE,
            'desc' => self::Desc($ERR_CODE),
            'data' => null
        );
        exit(json_encode($output));
    }
     
    private static function Desc($ERR_CODE)
    {
        $ERR_DESC=array(
            
            '1000' => "Unspecified Error",  /** Under normal condictions those errors shouldn't displayed to end users unless they attempt to do so
                                             *  some submissions should be intercepted by the frontend before the request sended 
                                             */
            '1001' => "Internal Sever Error : SECURE_VALUE 非法",
            '1002' => "内部服务器错误：操作失败",
            '1003' => "内部服务器错误：参数不全",
            '1004' => "内部服务器错误：参数非法",
            '1005' => "内部服务器错误：文件类型不被支持",

            '2000' => "Account-Related Error",

            '2001' => "请先登录",
            '2002' => "未找到该用户",
            '2003' => "您的权限不足",

            '3000' => "Course-Related Error",

            '3001' => "请先注册本课程",
            '3002' => "课程未找到",
            '3003' => "课时未找到",
            '3004' => "作业未找到",
            '3005' => "乔波",  // Reserved for Copper in memory of OASIS and those who contributed a lot
            '3006' => "作业已截止提交",

            '4000' => "Contest-Related Error",

            '4001' => "学号已经被注册",
            '4002' => "队名已经被注册",
            '4003' => "学号重复",
            '4004' => "请填写所有应填项",
            '4005' => "数字格式不正确",
            '4006' => "邮箱格式不正确",
        );
        return isset($ERR_DESC[$ERR_CODE])?$ERR_DESC[$ERR_CODE]:$ERR_DESC['1000'];
    }

}
