<?php

namespace app\xt\controller;

use think\Controller;
use think\Request;
use think\response\Json;
use think\Session;
use app\xt\model\User as UserModel;

/**
 * 用于实现用户相关功能
 * @package app\index\controller
 * @author 谢灿
 * @data 2019年6月17日
 */
class User extends BaseController
{
    /**
     * 显示资源列表 分页查询和用户名称模糊查询.
     * @author 谢灿 2019年6月20日
     * @param string $name 名称
     * @param int $page 页码
     * @param int $limit 条数
     * @return \think\Response
     */
    public function index($name = "", $page, $limit)
    {
       $user = new UserModel();
        $list=$user->listUsers($name,$page,$limit);
        $count=$list['count'];
        $data=$list['list'];
        foreach ($data as $key => $value){
            $result[$key]=$value;
        }
        if (isset($result)){
            return returnPage(200,$count,'',$result );
        }
        else
            return returnJson(400,'不存在相关用户','');
    }

    /**
     * 保存新建的资源
     * @auth 谢灿 2019-6-20
     * @param  \think\Request $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        $data   = $request->param();
        $data['USE_FLAG']=1;
        $user = new UserModel;
        if($user->valid($data['account'])){
            return returnJson(400, '账号已存在', '');
        }else{
            $loginer = getLoginedUser();
            $result = $user->register([
                'oprator_id' => $loginer->key_id,
                'user_account' => $data['account'],
                'user_password' => $data['password'],
                'user_name' => $data['name'],
                'nick_name' => $data['nick_name'],
                'USE_FLAG'=>$data['USE_FLAG']
            ]);
            if ($result) {
                return returnJson(200, '注册成功', ['key_id'=>$result]);
            } else {
                return returnJson(400, '注册失败','');
            }
        }
    }

    /**
     * 显示指定的资源
     * @auth 谢灿 2019-6-20
     * @param  int $id
     * @return \think\Response
     */
    public function read($id)
    {
        $user = UserModel::get($id);
        if(isset($user)){
            $result= [
                'key_id' => $user['keyid'],
                'account' => $user['user_account'],
                'name' => $user['user_name'],
                'nick_name' => $user['nick_name']
            ];
            return returnJson(200,'获取成功', [$result]);
        }else{
            return returnJson(400,'获取失败', '');
        }
    }

    /**
     * 保存更新的资源 post 参数中需要_method: put
     * @auth 谢灿 2019-6-20
     * @param  \think\Request $request
     * @param  int $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data   = $request->param();
        $user = UserModel::get($id);
        if(isset($user)){
            $loginer = getLoginedUser();
            if($request->has("account")){
                $user->setAttr('user_account',$data['account']);
            }
            if($request->has("password")){
                if ($request->param('password')!=null){
                    $user->setAttr('user_password',$data['password']);
                }
            }
            if($request->has("name")){
                $user->setAttr('user_name',$data['name']);
            }
            if($request->has("nick_name")){
                $user->setAttr('nick_name',$data['nick_name']);
            }
            $user->setAttr('operator_id',$loginer->key_id);
            $user->save();
            $result= [
                'key_id' => $user['keyid'],
                'account' => $user['user_account'],
                'name' => $user['user_name'],
                'nick_name' => $user['nick_name']
            ];
            return returnJson(200,'保存成功', $result);
        }else{
            return returnJson(400,'未找到用户', '');
        }
    }

    /**
     * 删除指定资源
     *
     * @param  int $id
     * @return \think\Response
     */
    public function delete($id)
    {
        $result = UserModel::destroy($id);
        if($result){
            return returnJson(200,'删除成功','');
        }else{
            return returnJson(400,'删除失败','');
        }
    }


    /**
     * 系统登录功能
     * @author 谢灿 2019-6-19
     * @param string $account 账号
     * @param string $password 密码 需md5加密
     * @return Json key_id, account, name, nick_name
     */
    public function login($account = '', $password = '')
    {
        $User = new UserModel();
        return $User->login($account,$password);
    }

    /**
     * 用户登出
     * 清空Session
     * @author 谢灿 2019-6-19
     * @return Json 成功返回200
     */
    public function logout(){
        Session::set(LOGIN_MARK_SESSION_KEY, null);
        return returnJson(200, '', '');
    }

}
