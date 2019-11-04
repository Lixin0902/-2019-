<?php
namespace app\index\model;


use app\xt\model\BaseModel;
use think\Model;

/**
 * 专家资格证书Model
 * @auth 谢灿 2019-6-21
 * @package app\index\model
 */
class ExpertCertificate extends BaseModel
{
    protected $table = "expert_certificate";

    /**
     * 获取资格证书所属的专家信息
     * @auth 谢灿 2019-6-21
     * @return ExpertInformation|\think\model\relation\BelongsTo
     */
    function info(){
        return $this->belongsTo('ExpertInformation',  'key_id', 'fk_expert_info_id');
    }

}