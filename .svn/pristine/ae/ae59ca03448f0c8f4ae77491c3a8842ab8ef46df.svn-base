<?php
/**
 * Created by IntelliJ IDEA.
 * User: Can Xie
 * Date: 2019/6/20
 * Time: 16:14
 */

namespace app\xt\model;

/**
 * 地区model 和组织机构是一个表.
 * @auth 谢灿 2019-6-20
 * @package app\xt\model
 */
class Area extends Organise
{
    protected $orgType = 788;
    protected $auto = ['level', 'type' => 788];


    function subOrgs(){
        return $this->hasMany('Area', 'LEVEL_UP_KEYID');
    }

    function parent(){
        return $this->belongsTo('Area', 'LEVEL_UP_KEYID');
    }
}