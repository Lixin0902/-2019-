<?php

namespace app\xt\controller;

use think\Request;
use app\xt\model\Area as AreaModel;
/**
 * 地区(省市区)管理控制器
 * @auth 谢灿 2019-6-24
 * @package app\xt\controller
 */
class Area extends BaseController
{
    /**
     * 显示资源列表
     *
     * @param int $parent_id
     * @param string $name
     * @return \think\Response name省市区名, code编码,parent_id 上级主键, key_id 主键
     */
    public function index($parent_id=null, $name ='')
    {
        $areaEntity = new AreaModel();
        if($name!=""){
            $areaEntity->where("dept_name","like",$name."%");
        }
        if ($parent_id!=null){
            $areaEntity ->where("LEVEL_UP_KEYID",$parent_id);
        }
        $result = $areaEntity->field("dept_name as name, code, LEVEL_UP_KEYID as parent_id, keyid as key_id,level")
            ->order("name","asc")
            ->select();
        return returnJson(200,'',$result);
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
        $data   = $request->param();
        $areaModel = new AreaModel();
        $parentId = 0;
        if($request->has("parent_id")&&!empty($data['parent_id'])){
            $parentId = $data['parent_id'];
        }
        if($areaModel->valid($parentId, $data['name'], null)){
            return returnJson(400, '存在同名地区', '');
        }else{
            $loginer = getLoginedUser();
            $areaModel->setAttr("operator_id", $loginer->key_id);
            $areaModel->setAttr("dept_name", $data['name']);
            $areaModel->setAttr("code", $data['code']);
            $areaModel->setAttr("LEVEL_UP_KEYID", $parentId);
            $result = $areaModel->save();
            if ($result) {
                return returnJson(200, '新增成功', ['key_id'=>$areaModel->keyid]);
            } else {
                return returnJson(400, '新增失败','');
            }
        }
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
        $areaModel = AreaModel::get($id);
        if(isset($areaModel)){
            $result= [
                'key_id' => $areaModel['keyid'],
                'name' => $areaModel['dept_name'],
                'code'=> $areaModel['code'],
                'parent_id' => $areaModel['LEVEL_UP_KEYID'],
                'level' => $areaModel['level']
            ];
            return returnJson(200,'获取成功', [$result]);
        }else{
            return returnJson(400,'未找到相关数据', '');
        }
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
        $areaModel = new AreaModel();
        $restult = $areaModel->updateNameAndParent($request,$id);
        if(is_string($restult)){
            return returnJson(400, $restult, '');
        }else{
            return returnJson(200,'修改成功', $restult);
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
        $areaModel = AreaModel::get($id);
        $subOrgs = $areaModel->subOrgs;
        if($subOrgs){
            return returnJson(400,'存在下级单位无法删除','');
        }else{
            //删除
            $result = AreaModel::destroy($id);
            if($result){
                return returnJson(200,'删除成功','');
            }else{
                return returnJson(400,'删除失败','');
            }
        }
    }

}
