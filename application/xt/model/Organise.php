<?php

namespace app\xt\model;
use think\Request;

/**
 * 系统组织机构Model
 * Class Organise
 * @auth 谢灿 2019-6-20
 * @package app\xt\model
 */
class Organise extends BaseModel
{
    //组织机构表(包含地区数据)
    protected $table = "xt_t_organise";
    protected $pk = "keyid";
    protected $orgType = 787;
    protected $auto = ['level', 'type' => 787];

    /**
     * 全局条件.
     * 因为地区和组织机构用同一个表所以使用全局条件将这个表分成两个model
     * @author 谢灿 2019-6-20
     * @param $query
     */
    function base($query){
        $query->where('type',$this->orgType);
    }

    /**
     * 下级
     * @author 谢灿 2019-6-20
     * @return \think\model\relation\HasMany
     */
    function subOrgs(){
        return $this->hasMany('Organise', 'LEVEL_UP_KEYID');
    }

    /**
     * 上级
     * @author 谢灿 2019-6-20
     * @return \think\model\relation\BelongsTo
     */
    function parent(){
        return $this->belongsTo('Organise', 'LEVEL_UP_KEYID');
    }

    /**
     * 级别修改器
     * @author 谢灿 2019-6-20
     * @param int $level
     * @return int level
     */
    function setLevelAttr($level){
        if($this->LEVEL_UP_KEYID == 0){
            return 0;
        }else{
            $parentModel = $this->where("keyid",$this->LEVEL_UP_KEYID)->find();
            return ++$parentModel->level;
        }
    }
    /**
     * 验证组织机构
     * @author 谢灿 2019-6-20
     * @param int $parent_id
     * @param string $name
     * @param int $keyid
     * @return bool
     */
    function valid($parent_id, $name, $keyid){
        $valid = $this;
        if(isset($keyid)){
            $valid->where("keyid",'<>',$keyid);
        }
        $exis = $valid->where("dept_name", $name)
            ->where("LEVEL_UP_KEYID",$parent_id)
            ->find();
        return isset($exis);
    }

    /**
     * @param Request $request
     * @param $id
     * @return Organise|bool
     */
    function updateNameAndParent(Request $request,$id){
        $data   = $request->param();
        $model = $this->where("keyid",$id)->field("*,keyid as key_id,LEVEL_UP_KEYID as parent_id,dept_name as name")->find();
        $parentId = $model->LEVEL_UP_KEYID;
        if($request->has("parent_id")){
            $parentId = $data['parent_id'];
            $model->setAttr("LEVEL_UP_KEYID", $data['parent_id']);
        }
        if($model->valid($parentId, $data['name'], $id)){
            return "存在同名";
        }else{
            $loginer = getLoginedUser();
            $model->setAttr("operator_id", $loginer->key_id);
            if($request->has("name")){
                $model->setAttr("dept_name", $data['name']);
            }
            $result = $model->save();
            if ($result) {
                $model->setAttr("name", $model->getAttr('dept_name'));
                $model->setAttr("parent_id", $model->getAttr('LEVEL_UP_KEYID'));
                return $model->visible(["key_id","name","parent_id"],true);
            } else {
                return "更新失败";
            }
        }
    }

    function deleteById(){
//        $subOrgs = this::hasWhere('subOrgs')->select();
//        dump($subOrgs);
        if(isset($subOrgs)){
            return returnJson(400,'存在下级无法删除','');
        }
    }

}
