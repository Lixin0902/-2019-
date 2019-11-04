<?php
/**
 * Created by IntelliJ IDEA.
 * User: Can Xie
 * Date: 2019/7/4
 * Time: 9:01
 */

namespace app\index\controller;

use app\xt\controller\BaseController;
use app\index\model\ExpertOrg as ExpertOrgModel;
use think\Request;

/**
 * 专家单位控制器
 * Class ExpertOrg
 * @package app\index\controller
 */
class ExpertOrg extends BaseController
{

    /**
     * 显示资源列表
     * @param int $parent_id
     * @param string $name
     * @return \think\Response name单位名, code编码,parent_id 上级主键, key_id 主键
     */
    public function index($parent_id = 0, $name ='')
    {
        $orgModel = new ExpertOrgModel;
        if($name!=""){
            $orgModel->where("dept_name","like",$name."%");
        }
        if ($parent_id==null){
            $parent_id=0;
        }
        $result = $orgModel->field("dept_name as name, code, LEVEL_UP_KEYID as parent_id, keyid as key_id")
            ->where("LEVEL_UP_KEYID",$parent_id)
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
        $orgModel = new ExpertOrgModel;
        $parentId = 0;
        $fk_unit_kind=1;
        if($request->has("parent_id")&&!empty($data['parent_id'])){
            $parentId = $data['parent_id'];
        }
        if($orgModel->valid($parentId, $data['name'], null)){
            return returnJson(400, '存在同名单位', '');
        }else{
            $loginer = getLoginedUser();
            $orgModel->setAttr("operator_id", $loginer->key_id);
            $orgModel->setAttr("dept_name", $data['name']);
            if($request->has('code')){
                $orgModel->setAttr("code", $data['code']);
            }
            $orgModel->setAttr("LEVEL_UP_KEYID", $parentId);
            $orgModel->setAttr("fk_unit_kind",$fk_unit_kind);
            $result = $orgModel->save();
            if ($result) {
                return returnJson(200, '新增成功', ['key_id'=>$orgModel->keyid]);
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
        $orgModel = ExpertOrgModel::get($id);
        if(isset($orgModel)){
            $result= [
                'key_id' => $orgModel['keyid'],
                'name' => $orgModel['dept_name'],
                'code'=> $orgModel['code'],
                'parent_id' => $orgModel['LEVEL_UP_KEYID'],
                'level' => $orgModel['level']
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
        $orgModel = new ExpertOrgModel();
        $result = $orgModel->updateNameAndParent($request,$id);
        if(is_string($result)){
            return returnJson(400, $result, '');
        }else{
            return returnJson(200,'修改成功', $result);
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
        $expert_org = ExpertOrgModel::get($id);
        $subOrgs = $expert_org->subOrgs;
        if($subOrgs){
            return returnJson(400,'存在下级单位无法删除','');
        }else{
            //删除
            $result = ExpertOrgModel::destroy($id);
            if($result){
                return returnJson(200,'删除成功','');
            }else{
                return returnJson(400,'删除失败','');
            }
        }
    }

}