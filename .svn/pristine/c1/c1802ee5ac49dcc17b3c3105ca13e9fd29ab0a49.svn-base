<?php

namespace app\xt\model;
use think\response\Json;

/**
 * 系统用户表Model
 * Class User
 * @auth 谢灿 2019-6-20
 * @package app\xt\model
 */
class User extends BaseModel
{
    //系统用户
    protected $table = "xt_t_user";
    protected $pk = "keyid";


    /**
     * 密码修改器, 进行MD5加密
     * @param $password
     * @return string
     */
    protected function setUserPasswordAttr($password){
        return getmd5PSW($password);
    }

    /**
     * 用户名查询条件封装
     * @auth 谢灿 2019-6-20
     * @param $query
     * @param $name
     */
    protected function scopeUserName($query, $name)
    {
        if ($name!=""){
            $query->where('user_name','like','%'.$name.'%')
                ->whereOr("nick_name",'like','%'.$name.'%');
        }
    }
    /**
     * 分页查询用户
     * @Auth 谢灿 2019-6-20
     * @param string $name 名称
     * @param int $page 页码
     * @param int $limit 条数
     * @return \think\Paginator
     */
    public function listUsers($name,$page,$limit){
        $start=$limit*($page-1);
        $list = $this::userName($name)
            ->field(['keyid as key_id', 'user_account', 'nick_name','user_name as name'])
//            ->paginate($limit);
            ->limit($start,$limit)
            ->select();
        $count=count($this::userName($name)->select());
        $result['list']=$list;
        $result['count']=$count;
        return $result;
    }

    /**
     * 用户登录认证
     * @Auth 谢灿 2019-6-20
     * @param string $account 账号
     * @param string $password 密码 需md5加密
     * @return Json key_id, account, name, nick_name
     */
    public function login($account, $password)
    {
        $userEntity = $this->field("keyid as key_id,USE_FLAG as use_flag, user_password as password, user_account as account, user_name as name, nick_name, mobile_phone")
            ->where("user_account", $account)
            ->find();
        if (isset($userEntity)) {
            if ($userEntity->password == getmd5PSW($password)) {
                if($userEntity->use_flag != 1){
                    return returnJson(400, "账号被冻结", []);
                }else{
                    saveInSession($userEntity->hidden(['use_flag','password']));
                    return returnJson(200, '登录成功', $userEntity->hidden(['use_flag','password']));
                }
            }
        }
        return returnJson(400, "账号或密码错误", []);
    }

    /**
     * 注册一个新用户
     * @auth 谢灿 2019-6-20
     * @param  array $data 用户注册信息
     * @return integer|bool  注册成功返回主键，注册失败-返回false
     */
    public function register($data = [])
    {
        $result = $this
            ->allowField(true)
            ->save($data);
        if ($result) {
            return $this->getData('keyid');
        } else {
            return false;
        }
    }

    /**
     * 账号查重
     * @param string $account 账号
     * @return bool
     */
    public function valid($account){
        $valid = new User();
        $exis = $valid->where("user_account",$account)->find();
        return isset($exis);
    }

}
