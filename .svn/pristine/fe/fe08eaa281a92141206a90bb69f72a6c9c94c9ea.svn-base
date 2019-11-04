<?php
/**
 * Created by IntelliJ IDEA.
 * User: Can Xie
 * Date: 2019-7-9
 * Time: 9:19
 */

namespace app\index\controller;


use app\xt\controller\BaseController;
use app\index\model\ExpertInformation;
use app\xt\model\BaseCode;
use app\xt\model\Area;


/**
 * 专家统计分析接口控制器
 * Class ExpertAnalysis
 * @package app\index\controller
 */
class ExpertAnalysis extends BaseController
{
    /**
     *
     *    职称统计分析
     *    可以按照专家的职称进行统计分析
     *
     *    性别统计分析
     *    可以按照专家的性别进行统计分析
     *
     *    年龄段统计分析
     *    可以按照专家的年龄段进行统计分析
     *
     *    所属行业统计分析
     *   可以按照专家的所属行业进行统计分析
     *
     *    从事专业统计分析
     *    可以按照专家的从事专业进行统计分析
     *
     *    地区统计分析
     *    可以按照专家所在地区（精确到区县）进行统计分析
     */
    public function analysis($type){
        $experInfo=new ExpertInformation();
        $baseCode=new BaseCode();
        $area=new Area();

        /**
         * 职称统计分析
         */
        if ($type==0){
            $value=$baseCode->field('para_name as name,Key_Id as key_id')
                ->where('parent_ID',782)
                ->select();
            foreach ($value as $key => $val){
                $count=$experInfo->where('fk_code_title_id',$val['key_id'])
                    ->count();
                if ($count!=0)
                    $result[$val['name']]=$count;
            }
            return returnJson(200,'职称',$result);
        }

        /**
         * 性别统计分析
         */
        if ($type==1){
            $value=$baseCode->field('para_name as name,Key_Id as key_id')
                ->where('parent_ID',778)
                ->select();
            foreach ($value as $key => $val){
                $result[$val['name']]=$experInfo->where('fk_code_gender_id',$val['key_id'])
                    ->count();
            }
            return returnJson(200,'性别',$result);
        }

        /**
         * 年龄统计分析
         */
        if ($type==2){
            $result['0-20']=$experInfo->where('age','>=',0)->where('age','<=',20)->count();
            $result['21-30']=$experInfo->where('age','>=',21)->where('age','<=',30)->count();
            $result['31-40']=$experInfo->where('age','>=',31)->where('age','<=',40)->count();
            $result['41-50']=$experInfo->where('age','>=',41)->where('age','<=',50)->count();
            $result['51-']=$experInfo->where('age','>=',51)->count();
            return returnJson(200,'年龄',$result);
        }

        /**
         * 行业统计分析
         */
        if ($type==3){
            $value=$baseCode->field('para_name as name,Key_Id as key_id')
                ->where('type_flag','profession')
                ->where('level',2)
                ->where('level','>',0)
                ->select();
            foreach ($value as $key => $val){
                $count=$experInfo->where('fk_code_profession_id',$val['key_id'])
                    ->count();
                if ($count!=0)
                    $result[$val['name']]=$count;
            }
            return returnJson(200,'行业',$result);
        }

        /**
         * 专业统计分析
         */
        if ($type==4){
            $value=$baseCode->field('para_name as name,Key_Id as key_id')
                ->where('parent_ID',783)
                ->select();
            foreach ($value as $key => $val){
                $count=$experInfo->where('fk_code_major_id',$val['key_id'])
                    ->count();
                if ($count!=0)
                    $result[$val['name']]=$count;
            }
            return returnJson(200,'专业',$result);
        }

        /**
         * 地区统计分析
         */
        if ($type==5){
            $value=$area->field('dept_name as name,keyid as key_id')
                ->where('level',2)
                ->select();
            foreach ($value as $key => $val){
                $count=$experInfo->where('fk_area_id',$val['key_id'])
                    ->count();
                if ($count!=0){
                    $result[$val['name']]=$count;
                }
            }
            return returnJson(200,'地区',$result);
        }
    }
}