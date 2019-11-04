<?php

namespace app\xt\controller;

use think\Controller;
use think\Request;
use think\response\Json;
use app\xt\model\Organise as OrganiseModel;
/**
 * 用于实现组织机构相关功能
 * @package app\index\controller
 * @author 谢灿
 * @data 2019年6月17日
 */
class Organise extends BaseController
{
    /**
     * 显示组织机构资源列表
     * 分页, 上级, 名称,
     * @param string $name 组织机构名
     * @return Json
     */
    public function index($name = '')
    {
        $organiseModel = new OrganiseModel();
        if($name != ''){
            $organiseModel->where("dept_name", 'like', $name.'%');
        }
        $list = $organiseModel
        ->field(['keyid as key_id', 'dept_name', 'LEVEL_UP_KEYID as parent_id','code','sort'])
        ->select();
        return returnJson(200, '', $list);
    }

    /**
     * 保存新建的资源
     * @author 谢灿
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        $data   = $request->param();
        $organise = new OrganiseModel();
        if($organise->valid($data['parent_id'], $data['name'], null)){
            return returnJson(400, '存在同名单位', '');
        }else{
            if ($request->has('code')){
                $organise->setAttr("code", $data['code']);
            }
            else
                $organise->setAttr("code",'');
            $loginer = getLoginedUser();
            $organise->setAttr("operator_id", $loginer->key_id);
            $organise->setAttr("dept_name", $data['name']);
            $organise->setAttr("sort", $data['sort']);
            if($request->has("parent_id")){
                $organise->setAttr("LEVEL_UP_KEYID", $data['parent_id']);
            }else{
                //顶级为0
                $organise->setAttr("LEVEL_UP_KEYID", 0);
            }
            $result = $organise->save();
            if ($result) {
                return returnJson(200, '新增成功', ['key_id'=>$organise->keyid]);
            } else {
                return returnJson(400, '新增失败','');
            }
        }
    }

    /**
     * 显示指定的资源
     * @author 谢灿 2019-6-20
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        $organise = OrganiseModel::get($id);
        if(isset($organise)){
            $result= [
                'key_id' => $organise['keyid'],
                'name' => $organise['dept_name'],
                'parent_id' => $organise['LEVEL_UP_KEYID'],
                'code' => $organise['code'],
                'sort' => $organise['sort']
            ];
            return returnJson(200,'获取成功', [$result]);
        }else{
            return returnJson(400,'未找到相关数据', '');
        }
    }

    /**
     * 保存更新的资源
     * @author 谢灿 2019-6-20
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        $data   = $request->param();
        $organise = OrganiseModel::get($id);
        if($organise->valid($data['parent_id'], $data['name'], $id)){
            return returnJson(400, '存在同名单位', '');
        }else{
            $loginer = getLoginedUser();
            $organise->setAttr("operator_id", $loginer->key_id);
            if($request->has("name")){
                $organise->setAttr("dept_name", $data['name']);
            }
            if($request->has("parent_id")){
                $organise->setAttr("LEVEL_UP_KEYID", $data['parent_id']);
            }
            if($request->has("sort")){
                $organise->setAttr("sort", $data['sort']);
            }
            if($request->has("code")){
                $organise->setAttr("code", $data['code']);
            }
            $result = $organise->save();
            if ($result) {
                return returnJson(200, '修改成功', ['key_id'=>$organise->keyid]);
            } else {
                return returnJson(400, '修改失败','');
            }
        }
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        $organises = OrganiseModel::get($id);
        $subOrgs = $organises->subOrgs;
        if($subOrgs){
            return returnJson(400,'存在下级单位无法删除','');
        }else{
            //删除
            $result = OrganiseModel::destroy($id);
            if($result){
                return returnJson(200,'删除成功','');
            }else{
                return returnJson(400,'删除失败','');
            }
        }
    }

}
