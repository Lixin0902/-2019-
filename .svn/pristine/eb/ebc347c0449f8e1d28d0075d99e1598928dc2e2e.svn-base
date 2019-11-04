<?php
/**
 * Created by IntelliJ IDEA.
 * User: Can Xie
 * Date: 2019/6/20
 * Time: 10:47
 */

namespace app\xt\model;


use think\Model;

/**
 * 系统基础Moodel 关于系统Model的通用配置放在这里
 * Class BaseModel
 * @Auth 谢灿 2019-6-20
 * @package app\xt\model
 */
class BaseModel extends Model
{
    protected $pk = "key_id";
    //开启自动写入时间戳 格式datetime类型
    protected $autoWriteTimestamp = "datetime";
    protected $createTime = 'operate_date';
    protected $updateTime = 'operate_date';
    // 关闭自动写入update_time字段
//    protected $updateTime = false;
    //只读字段
//    protected $readonly = ['name','email'];
    //类型转换https://www.kancloud.cn/manual/thinkphp5/138669
//    protected $type = [
//        'status'    =>  'integer',
//        'score'     =>  'float',
//        'birthday'  =>  'datetime',
//        'info'      =>  'array',
//    ];
//可以使用toArray方法将当前的模型实例输出为数组，例如：
//$user = User::find(1);
//dump($user->toArray());

//支持设置不输出的字段属性：
//$user = User::find(1);
//dump($user->hidden(['create_time','update_time'])->toArray());

//数组输出的字段值会经过获取器的处理，也可以支持追加其它获取器定义（不在数据表字段列表中）的字段，例如：
//$user = User::find(1);
//dump($user->append(['status_text'])->toArray());

//支持设置允许输出的属性，例如：
//$user = User::find(1);
//dump($user->visible(['id','name','email'])->toArray());

//V5.0.4+版本开始，支持追加一对一关联模型的属性到当前模型，例如：
//$user = User::find(1);
//dump($user->appendRelationAttr('profile',['email','nickname'])->toArray());

////支持关联属性（V5.0.5+）
////模型的visible、hidden和append方法支持关联属性操作，例如：
//$user = User::get(1,'profile');
//// 隐藏profile关联属性的email属性
//dump($user->hidden(['profile'=>['email']])->toArray());
//// 或者使用
//dump($user->hidden(['profile.email'])->toArray());
//hidden、visible和append方法同样支持数据集对象。

//可以调用模型的toJson方法进行JSON序列化
//$user = User::get(1);
//echo $user->toJson();

//追加关联模型的属性（V5.0.4+）
//V5.0.4+版本开始，支持追加一对一关联模型的属性到当前模型，例如：
//$user = User::find(1);
//echo $user->appendRelationAttr('profile',['email','nickname'])->toJson();
//profile是关联定义方法名，email和nickname是Profile模型的属性。


//    // 定义全局的查询范围
//    protected function base($query)
//    {
//        $query->where('status',1);
//    }
}