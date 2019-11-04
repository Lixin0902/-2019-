<?php

namespace app\xt\controller;

use think\Controller;
use think\Request;
use app\xt\model\BaseCode as BaseCodeModel;

/**
 * 用于基础代码相关功能
 * @package app\index\controller
 * @author 谢灿
 * @data 2019年6月17日
 */
class BaseCode extends BaseController
{
    /**
     * 获取基础代码
     * @auth 谢灿 2019-6-21
     * @param String $flag  基础代码type_flag
     * @param int $level 基础代码等级
     * @param int $parent_id 基础代码上级key_id
     * @return BaseCode 实体类 字段为key_id 主键, name 名称, flag 代号, code 简称, level 级别, parent_id 上级主键
     */
    public function index($flag = '', $level=-1, $parent_id=-1)
    {
        $BaseCodeEntity = new BaseCodeModel();
        $entities = $BaseCodeEntity
            ->field("Key_id as key_id, para_name as name, para_memo as code, level, parent_ID as parent_id, type_flag as flag");
        if ($flag != '') {
            $entities->where("type_flag", '=', $flag);
        }
        if ($level != -1) {
            $entities->where("level", $level);
        }
        if ($parent_id != -1) {
            $entities->where("parent_ID", $parent_id);
        }
        return returnJson('200', '', $entities->select());
    }
    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        $data=$request->param();
        $user=getLoginedUser();
        $data['operator_id']=$user->key_id;
        $data['current_status']=1;
        $parent_ID=$data['parent_ID'];
        $base_code=new BaseCodeModel();
        if ($parent_ID==0){
            $data['level']=0;
        }
        else{
            $level=$base_code
                ->field('level')
                ->where('key_id',$parent_ID) //上级代码需要通过下拉列表选择，确保上级代码存在，默认则为0
                ->find();
            $data['level']=$level['level']+1;
        }
        $result=$base_code::create($data);
        return returnJson(200,'基础代码添加成功',["key_id"=>$result->key_id]);
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        $base_code=new BaseCodeModel();
        $data=$base_code
            ->field('para_name,para_memo,type_flag')
            ->where('key_id',$id)
            ->find();
        return returnJson(200,'基础代码查询成功',$data);
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        $data=$request->except('id');
        $data['key_id']=$id;
        $base_code=new BaseCodeModel();
        $user=getLoginedUser();
        $data['operator_id']=$user->key_id;
        $parent_ID=$data['parent_ID'];
        if ($parent_ID==0){
            $data['level']=0;
        }
        else if ($parent_ID==null){

        }
        else{
            $level=$base_code
                ->field('level')
                ->where('key_id',$parent_ID)
                ->find();
            $data['level']=$level['level']+1;
        }
        $result=$base_code::update($data,["key_id"=>$id],true);
        return returnJson(200,'基础代码修改成功',$data);
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        $base_code=new BaseCodeModel();
        $count=$base_code->where('parent_ID',$id)->count();
        if ($count==0){
            $result=$base_code->where('key_id',$id)->delete();
            if ($result){
                return returnJson(200,'基础代码删除成功！','');
            }
            else
                return returnJson(400,'删除失败，相关数据不存在','');
        }
        else{
            return returnJson(400,'删除失败，存在下级数据','');
        }
    }


}
