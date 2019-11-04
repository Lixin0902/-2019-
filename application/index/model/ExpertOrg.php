<?php
/**
 * Created by IntelliJ IDEA.
 * User: Can Xie
 * Date: 2019/7/4
 * Time: 9:02
 */

namespace app\index\model;


use app\xt\model\Organise;

class ExpertOrg extends Organise
{

    protected $orgType = 787;
    protected $auto = ['level', 'type' => 787];


    function subOrgs(){
        return $this->hasMany('ExpertOrg', 'LEVEL_UP_KEYID');
    }

    function parent(){
        return $this->belongsTo('ExpertOrg', 'LEVEL_UP_KEYID');
    }
}