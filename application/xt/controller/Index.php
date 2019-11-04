<?php
namespace app\xt\controller;

/**
 * 用于PC后台系统主页跳转
 * @package app\index\controller
 * @author 谢灿
 * @data 2019年6月17日
 */
class Index extends BaseController
{

    public function index()
    {
        $user = getLoginedUser();
        $this->assign("user", $user);
        return $this->fetch();
    }

    public function login()
    {
        return $this->fetch();
    }

    public function welcome()
    {
        return $this->fetch();
    }
}
