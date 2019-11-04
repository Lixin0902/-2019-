<?php

use think\Session;

//自定义MD5加密规则
function getmd5PSW($psw)
{
    $miwen = "hbfg&119.29.189.235";
    $md51 = md5(md5(substr_replace($psw, "&*?", 2, 0) . substr_replace($psw, "?*&", 4, 0) . "*2017*10*31&" . $miwen, true));
    return $md51;
}


/**
 * 保存用户进session
 * @author 谢灿 2019-6-19
 * @param $userEntity
 */
function saveInSession($userEntity){
    Session::set(LOGIN_MARK_SESSION_KEY, $userEntity);
}