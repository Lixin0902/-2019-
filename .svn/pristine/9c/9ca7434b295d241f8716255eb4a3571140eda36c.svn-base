<?php

namespace app\index\model;

use app\xt\model\Area;
use app\xt\model\BaseModel;
use think\Request;

/**
 * 专家信息表model
 * @auth 谢灿 2019-6-20
 * @package app\index\model
 */
class ExpertInformation extends BaseModel
{
    protected $table="expert_information";
    protected $autoWriteTimestamp = 'datetime';
    protected $createTime = 'operate_date';
    protected $updateTime = 'operate_date';

    /**
     * 模糊查询
     * @auth 崔同海 2019-6-25
     * @param $query
     * @param $param
     */
    protected function scopeExpert($query,$param){
        if (isset($param['name'])){
            $name=$param['name'];
                $query->where('name','like','%'.$name.'%');
            $param['name']=null;
        }

//        if (isset($param['age_min'])&&isset($param['age_max'])){
//            $age_min=$param['age_min'];
//            $age_max=$param['age_max'];
//            $query->where('age','>=',$age_min)
//                ->where('age','<=',$age_max);
//            $param['age_min']=null;
//            $param['age_max']=null;
//        }
//        else if (isset($param['age_min'])&&!isset($param['age_max'])){
//            $age_min=$param['age_min'];
//            $query->where('age','>=',$age_min);
//            $param['age_min']=null;
//        }
//        else if (!isset($param['age_min'])&&isset($param['age_max'])){
//            $age_max=$param['age_max'];
//            $query->where('age','<=',$age_max);
//            $param['age_max']=null;
//        }

        if (isset($param['age_min'])&&$param['age_min']!=null){
            $age_min=$param['age_min'];
            $query->where('age','>=',$age_min);
            $param['age_min']=null;
        }
        if (isset($param['age_max'])&&$param['age_max']!=null){
            $age_max=$param['age_max'];
            $query->where('age','<=',$age_max);
            $param['age_max']=null;
        }

//        $fk_code_profession_id=$param['一级行业'].$param['二级行业'];
//        if ($fk_code_profession_id!=null){
//            $query->where('fk_code_profession_id','like','%'.$fk_code_profession_id.'%');
//        }

        foreach($param as $key => $value){
            if ($value!=null){
                $query->where($key,'=',$value);
            }
        }
    }

    /**
     * 关联的资格证书
     * @auth 谢灿 2019-6-21
     * @return array|\think\model\relation\HasMany
     */
    function certificates(){
        return $this->hasMany('ExpertCertificate', 'fk_expert_info_id', 'key_id');
    }

    /**
     * 分页查询专家信息
     * @auth 崔同海 2019-6-25
     * @param array $param
     * @param $limit
     * @param $start
     * @return \think\Paginator
     */
    public function listExpert($param,$limit,$start){
        $list = $this::expert($param)
//            ->field(['key_id','name','fk_code_gender_id','age','fk_code_title_id','fk_code_major_id','fk_area_id','fk_code_profession_id','is_senior'])
            ->limit($start,$limit)
            ->select();
        $count=count($this::expert($param)->select());
        $result['count']=$count;
        $result['list']=$list;
        return $result;
    }
}
