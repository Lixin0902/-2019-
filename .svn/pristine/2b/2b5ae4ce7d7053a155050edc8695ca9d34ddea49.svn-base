<?php

namespace app\index\controller;

use app\xt\controller\BaseController;
use app\xt\model\Area;
use app\xt\model\BaseCode;
use think\Request;
use app\index\model\ExpertInformation as ExpertInfo;

/**
 * 用于实现专家信息相关功能
 * @package app\index\controller
 * @author 谢灿
 * @data 2019年6月17日
 */
class ExpertInformation extends BaseController
{
    /**
     * 专家列表显示
     * @auth 崔同海 2019-6-22
     * @param Request $request
     * @return \think\Response
     * @throws \Exception
     */
    public function index(Request $request)
    {
        $param=$request->except('page,limit');
        $limit=intval($request->param('limit'));
        $page=intval($request->param('page'));
        $start=$limit*($page-1);
        try{
            $expertInfo=new ExpertInfo();
            $list=$expertInfo->listExpert($param,$limit,$start);
            $count=$list['count'];
            $data=$list['list'];
            if (isset($data)){
                foreach ($data as $key => $value) {
                    $result[$key]=expertName($value);
                }
            }
            if (!empty($result)){
                return returnPage(200,$count,'查询成功',$result);
            }
            else
                return returnJson(400,'查询失败，未找到相关数据','');
        }catch (\Exception $e){
            throw $e;
        }
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
     * 新增专家信息
     * @auth 崔同海 2019-6-20
     * @param  \think\Request $request
     * @return \think\Response
     * @throws \Exception
     */
    public function save(Request $request)
    {
        $data=$request->param();
        $data['picture']=pictureUpload();
        $user = getLoginedUser();
        $data['operate_id']=$user->key_id;
        $data['operate_name']=$user->name;
        try{
            $result=ExpertInfo::create($data);
            if ($result){
                return returnJson(200,'专家信息添加成功',['key_id'=>$result->key_id]);
            }
            else
                return returnJson(400,'添加失败','');
        }catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * 指定专家信息查询
     *
     * @param  int $id
     * @return \think\Response
     * @throws \Exception
     */
    public function read($id)
    {
        try{
            $expertInfoModel=new ExpertInfo();
            $result=$expertInfoModel
                ->field(['name','fk_code_gender_id','age','fk_code_title_id','fk_code_major_id','fk_area_id','fk_code_profession_id'])
                ->where('key_id',$id)
                ->find();
            if (isset($result)){
                $data=expertName($result);
                return returnJson(200,'专家信息查询成功',[$data]);
            }
            else
                return returnJson(400,'查询失败，未找到相关数据','');
        }catch (\Exception $e) {
            throw $e;
        }
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
     * 编辑专家信息（更新）
     * @auth 崔同海 2019-6-20
     * @param  \think\Request $request
     * @param  int $id
     * @return \think\Response
     * @throws \Exception
     */
    public function update(Request $request, $id)
    {
        $data = $request->except('id');
        $data['key_id']=$id;
        $picture=pictureUpload();
        if (!empty($picture)){
            $data['picture']=$picture;
        }
        $user = getLoginedUser();
        $data['operate_id']=$user->key_id;
        $data['operate_name']=$user->name;
        try{
            if (ExpertInfo::get($id)){
                $result = ExpertInfo::update($data, ["key_id" => $id],true);
                return returnJson(200,'专家信息更新成功',$data);
            }
            else
                return returnJson(400,'更新失败，相关专家不存在！','');
        }catch (\Exception $e){
            throw $e;
        }
    }

    /**
     * 专家信息删除
     * @auth 崔同海 2019-6-22
     * @param  int $id
     * @return \think\Response
     * @throws \Exception
     */
    public function delete($id)
    {
        try{
            $infoModel = new ExpertInfo();
            $infoModel->certificates()->where('fk_expert_info_id', $id)->delete();
            $infoModel -> where('key_id', $id)->delete();
        }catch (\Exception $e){
            throw $e;
        }
        return returnJson(200,'专家信息及相关资格证书删除成功','');
    }

    /**
     * 专家信息导出
     * @auth 崔同海 2019-6-22
     * @param  int $type 导出形式，0为excel，1为word，2为模板
     * @param int $id 当前专家key_id
     * @return \think\response
     */
    public function export($type,$id=1){
        if ($type==0){
            excelDown();
            return returnJson(200,'导出成功','');
        }
        if ($type==1){
            $domain=Request::instance()->domain();
            $root=Request::instance()->root();
            $path=$domain.$root;
            wordDown($id,$path);
            return returnJson(200,'导出成功','');
        }
        if ($type==2){
            blank_template();
            return returnJson(200,'导出成功','');
        }
    }

    /**
     * 专家信息导入数据库
     * @auth 崔同海 2019-8-26
     * @return \think\response
     */
    public function import(){
        excel_import();
    }
}
