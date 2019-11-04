<?php
/**
 * Created by IntelliJ IDEA.
 * User: 谢灿
 * Date: 2018/12/26
 * Time: 10:22
 */

namespace app\xt\validate;

use think\Validate;

class BaseValidate extends Validate
{

    /**
     * @var array 自定义验证条件
     */
    protected $regex = [
        'mobilePhone'=> '/^1[3-8]{1}[0-9]{9}$/',
        'idCard'=>'/(^\d(15)$)|((^\d{18}$))|(^\d{17}(\d|X|x)$)/'
    ];

}