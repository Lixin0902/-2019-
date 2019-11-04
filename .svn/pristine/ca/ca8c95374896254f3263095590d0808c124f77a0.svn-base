<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

//  应用常量
use app\index\model\ExpertInformation;
use app\index\model\ExpertCertificate;
use app\xt\model\Area;
use app\xt\model\BaseCode;
use think\Request;
use think\Session;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;

define('PHPSESSID', 'PHPSESSID'); //sessionID Cookie name in php
/**
 * 用户登录的session key
 */
define('LOGIN_MARK_SESSION_KEY', '_XT_USER_SESSION');
define('IN_USE', 1);
define('YES', 1);
define('NO', 0);
define('NOT_USE', 0);

/**
 * 接口返回数据表格格式
 * @param int $code 状态码 200=正常 400=访问错误 401=权限错误
 * @param int $count 返回条数
 * @param string $msg 返回信息
 * @param array $data 返回的data数据
 * @param int $json_option json格式 默认为 0 不需要修改.
 * @return \think\response\Json
 */
function returnPage($code, $count, $msg = '', $data = [], $json_option = 0)
{
    $returnJson = array('code' => $code,'count' => $count, 'msg' => $msg, 'data' => $data);
    returnData($returnJson, $json_option);
}

/**
 * 返回并中断连接
 * @param $returnJson
 * @param int $json_option
 */
function returnData($returnJson, $json_option = 0){
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
    echo json_encode($returnJson, $json_option);
    exit();
}

/**
 * 接口返回数据格式
 * @param int $code 状态码 200=正常 400=访问错误 401=权限错误
 * @param string $msg 返回信息
 * @param array $data 返回的data数据
 * @param int $json_option json格式 默认为 0 不需要修改.
 * @return \think\response\Json
 */
function returnJson($code, $msg = '', $data = [], $json_option = 0)
{
    $returnJson = array('code' => $code, 'msg' => $msg, 'data' => $data);
    returnData($returnJson, $json_option);
}

/**
 * 判断当前session是否已经登录,如果已经登录则返回User,否则返回null
 * @author 谢灿 2019-6-19
 * @return bool 登录返回true 未登录返回false;
 */
function isLogin()
{
    $user = Session::get(LOGIN_MARK_SESSION_KEY);
    return isset($user);
}

/**
 * 获取Session当前登录用户
 * @author 谢灿 2019-6-19
 * @return array $user 当前登录的用户信息
 */
function getLoginedUser()
{
    $user = Session::get(LOGIN_MARK_SESSION_KEY);
    if (!isset($user)) {
        $request = Request::instance();
        if ($request->isAjax()) {
            returnJson(401, 'error 401! Please login first.');
        } else {
            //重定向至登录页面
            header('Location: login');
            exit();
        }
    } else {
        return $user;
    }
}

/**
 * 图片上传
 * @return string 图片存储路径
 * @author 崔同海
 * @data 2019/6/20 08:56
*/
function pictureUpload(){
    $request=Request::instance();
    $picture=$request->file('picture');
    if ($picture){
        $picture_position=$picture->move(ROOT_PATH.'public'.DS.'static'.DS.'picture'.DS.'upload');
        if ($picture_position){
            return DS.'\static\picture\upload\\'.$picture_position->getSaveName();
        }
        else{
            return $picture->getError();
        }
    }
}

/**
 * 资格证书上传
 * @return string 图片存储路径
 * @author 崔同海
 * @data 2019/6/20 08:56
 */
function imageUpload(){
    $request=Request::instance();
    $image=$request->file('image');
    if ($image){
        $image_position=$image->move(ROOT_PATH.'public'.DS.'static'.DS.'picture'.DS.'certificate');
        if ($image_position){
            return DS.'static\picture\certificate\\'.$image_position->getSaveName();
        }
        else{
            return $image->getError();
        }
    }
}

/**
 * 基础代码中文输出
 * @param object $value 需要转换的参数
 * @return object $value 转换后的参数
 * @author 崔同海
 * @data 2019/7/4 11:47
 */
function expertName($value)
{
    $area = new Area();
    if (isset($value['fk_area_id'])){
        $value['fk_area_id_number']=$value['fk_area_id'];
        $country_id= $value['fk_area_id'];
        $result_country = $area
            ->field('dept_name as name,LEVEL_UP_KEYID as level_up')
            ->where('keyid', $country_id)
            ->find();
        $city_id = $result_country['level_up'];
        $result_city = $area
            ->field('dept_name as name,LEVEL_UP_KEYID as level_up')
            ->where('keyid', $city_id)
            ->find();
        $province_id = $result_city['level_up'];
        $result_province = $area
            ->field('dept_name as name')
            ->where('keyid', $province_id)
            ->find();
        $province_res = $result_province['name'];
        $city_res = $result_city['name'];
        $country_res = $result_country['name'];
        $value['fk_area_id'] = $province_res . $city_res . $country_res;
        $value['province_id']=$province_id;
        $value['city_id']=$city_id;
        $value['country_id']=$country_id;
    }

    $base_code = new BaseCode();  //所属行业
    if (isset($value['fk_code_profession_id'])){
        $value['fk_code_profession_id_number']=$value['fk_code_profession_id'];
        $second_profession = $value['fk_code_profession_id'];
        $result_second_profession = $base_code
            ->field('para_name as name,parent_ID as parent_id')
            ->where('key_id', $second_profession)
            ->find();
        $first_profession = $result_second_profession['parent_id'];
        $result_first_profession = $base_code
            ->field('para_name as name')
            ->where('key_id', $first_profession)
            ->find();
        $value['first_profession']=$first_profession;
        $value['second_profession']=$second_profession;
        $value['fk_code_profession_id'] = $result_first_profession['name'] . $result_second_profession['name'];
    }


//    if (isset($value['fk_code_bank_type_id'])){
//        $value['fk_code_bank_type_id_number']=$value['fk_code_bank_type_id'];
//        $fk_code_bank_type_id= $value['fk_code_bank_type_id'];
//        $result_fk_code_bank_type_id = $base_code
//            ->field('para_name as name')
//            ->where('Key_Id', $fk_code_bank_type_id)
//            ->find();
//        $value['fk_code_bank_type_id'] = $result_fk_code_bank_type_id['name'];
//    }

//    $base_code = new BaseCode();
    if (isset($value['fk_code_gender_id'])){
        $value['fk_code_gender_id_number']=$value['fk_code_gender_id'];
        $fk_code_gender_id = $value['fk_code_gender_id'];
        $result_fk_code_gender_id = $base_code
            ->field('para_name as name')
            ->where('Key_Id', $fk_code_gender_id)
            ->find();
        $value['fk_code_gender_id'] = $result_fk_code_gender_id['name'];
    }

    if (isset($value['fk_certificate_type_id'])){
        $value['fk_certificate_type_id_number']=$value['fk_certificate_type_id'];
        $fk_certificate_type_id= $value['fk_certificate_type_id'];
        $result_fk_certificate_type_id = $base_code
            ->field('para_name as name')
            ->where('Key_Id', $fk_certificate_type_id)
            ->find();
        $value['fk_certificate_type_id'] = $result_fk_certificate_type_id['name'];
    }

    if (isset($value['fk_code_politics_status_id'])){
        $value['fk_code_politics_status_id_number']=$value['fk_code_politics_status_id'];
        $fk_code_politics_status_id= $value['fk_code_politics_status_id'];
        $result_fk_code_politics_status_id = $base_code
            ->field('para_name as name')
            ->where('Key_Id', $fk_code_politics_status_id)
            ->find();
        $value['fk_code_politics_status_id'] = $result_fk_code_politics_status_id['name'];
    }

    if (isset($value['fk_code_highest_degree_id'])){
        $value['fk_code_highest_degree_id_number']=$value['fk_code_highest_degree_id'];
        $fk_code_highest_degree_id= $value['fk_code_highest_degree_id'];
        $result_fk_code_highest_degree_id = $base_code
            ->field('para_name as name')
            ->where('Key_Id', $fk_code_highest_degree_id)
            ->find();
        $value['fk_code_highest_degree_id'] = $result_fk_code_highest_degree_id['name'];
    }

//    if (isset($value['fk_code_title_id'])){
//        $value['fk_code_title_id_number']=$value['fk_code_title_id'];
//        $fk_code_title_id = $value['fk_code_title_id'];
//        $result_fk_code_title_id = $base_code
//            ->field('para_name as name')
//            ->where('Key_Id', $fk_code_title_id)
//            ->find();
//        $value['fk_code_title_id'] = $result_fk_code_title_id['name'];
//    }

    if (isset($value['fk_code_first_education_id'])){
        $value['fk_code_first_education_id_number']=$value['fk_code_first_education_id'];
        $fk_code_first_education_id= $value['fk_code_first_education_id'];
        $result_fk_code_first_education_id= $base_code
            ->field('para_name as name')
            ->where('Key_Id', $fk_code_first_education_id)
            ->find();
        $value['fk_code_first_education_id'] = $result_fk_code_first_education_id['name'];
    }

    if (isset($value['fk_code_highest_education_id'])){
        $value['fk_code_highest_education_id_number']=$value['fk_code_highest_education_id'];
        $fk_code_highest_education_id= $value['fk_code_highest_education_id'];
        $result_fk_code_highest_education_id= $base_code
            ->field('para_name as name')
            ->where('Key_Id', $fk_code_highest_education_id)
            ->find();
        $value['fk_code_highest_education_id'] = $result_fk_code_highest_education_id['name'];
    }

    if (isset($value['fk_code_major_id'])){
        $value['fk_code_major_id_number']=$value['fk_code_major_id'];
        $fk_code_major_id = $value['fk_code_major_id'];
        $result_fk_code_major_id = $base_code
            ->field('para_name as name')
            ->where('Key_Id', $fk_code_major_id)
            ->find();
        $value['fk_code_major_id'] = $result_fk_code_major_id['name'];
    }

//    if (isset($value['fk_org_id'])){
//        $organise=new \app\xt\model\Organise();
//        $value['fk_org_id_number']=$value['fk_org_id'];
//        $fk_org_id= $value['fk_org_id'];
//        $result_fk_org_id= $organise
//            ->field('dept_name as name')
//            ->where('keyid', $fk_org_id)
//            ->find();
//        $value['fk_org_id'] = $result_fk_org_id['name'];
//    }

    if (isset($value['is_willing_attend_lectures'])){
        if ($value['is_willing_attend_lectures'] == '1') {
            $value['is_willing_attend_lectures'] = '是';
        }
        if ($value['is_willing_attend_lectures'] == '0'){
            $value['is_willing_attend_lectures'] = '否';
        }
    }

    if (isset($value['is_emergency'])){
        if ($value['is_emergency'] == '1') {
            $value['is_emergency'] = '是';
        }
        if ($value['is_emergency'] == '0'){
            $value['is_emergency'] = '否';
        }
    }
    return $value;
}

/**
 * excel文档导出
 * @author 崔同海
 * @data 2019/7/10 9:27
 */
function excelDown(){
    $expTitle='专家信息列表';
//    $result = ExpertInformation::get($id);
    $result=ExpertInformation::all();
    $data=json_decode(expertName($result[0]));
    $i=0;
    foreach ($data as $key => $value){
        $name[$i]=$key;
        $val[$i]=$value;
        $i++;
        if ($i==38){
            break;
        }
    }
    $expCellName=$name;
    $expTableData=$val;

    $xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
    $fileName = $expTitle;//or $xlsTitle 文件名称可根据自己情况设定

    $cellNum = count($expCellName);
    $dataNum = count($expTableData);
    $objPHPExcel = new PHPExcel();//方法一
    $cellName = array('A','B', 'C','D', 'E', 'F','G','H','I', 'J', 'K','L','M', 'N', 'O', 'P', 'Q','R','S', 'T','U','V', 'W', 'X','Y', 'Z', 'AA',
        'AB', 'AC','AD','AE', 'AF','AG','AH','AI', 'AJ', 'AK', 'AL','AM','AN','AO','AP','AQ','AR', 'AS', 'AT','AU', 'AV','AW', 'AX',
        'AY', 'AZ');

    //文本居中
    $objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
//    $objPHPExcel->getActiveSheet()->getStyle('H')->getAlignment()->setWrapText(true);         设置自动换行

    //文本超出单元格自动换行
    for($z=0;$z<count($cellName);$z++){
        $objPHPExcel->getActiveSheet()->getStyle($cellName[$z])->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension($cellName[$z])->setWidth(20);
    }

    //设置列名称
//    for ($i = 0; $i < $cellNum; $i++) {
//        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i] . '1', $expCellName[$i]);
//    }

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[0] . '1', '姓名');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[1] . '1', '性别');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[2] . '1', '年龄');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[3] . '1', '证件类型');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[4] . '1', '证件号码');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[5] . '1', '开户行');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[6] . '1', '银行卡号');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[7] . '1', '证件照');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[8] . '1', '是否应急专家');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[9] . '1', '是否愿意参加科普讲座');
//    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[9] . '1', '是否培训');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[10] . '1', '政治面貌');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[11] . '1', '出生日期');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[12] . '1', '社会保障卡号');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[13] . '1', '最高学位');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[14] . '1', '职称');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[15] . '1', '职称证书号');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[16] . '1', '执业资格');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[17] . '1', '执业资格证书编号');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[18] . '1', '职务');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[19] . '1', '所属行业');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[20] . '1', '第一学历');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[21] . '1', '第一学历毕业院校及专业');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[22] . '1', '最高学历');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[23] . '1', '最高学历毕业院校及专业');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[24] . '1', '从事专业');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[25] . '1', '从事专业年限');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[26] . '1', '所属单位');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[27] . '1', '所属区域');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[28] . '1', '工龄');
//    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[27] . '1', '是否资深专家');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[29] . '1', '移动电话');
//    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[29] . '1', '家庭地址');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[30] . '1', '邮政邮编');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[31] . '1', '电子邮箱');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[32] . '1', '专业技术特长');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[33] . '1', '简历');

//    //赋值
//    /**
//     * 单条记录导出
//     */
//    for ($i = 0; $i < $cellNum; $i++) {
//        $objPHPExcel->setActiveSheetIndex(0)->setCellValue(
//            $cellName[$i].'2',$expTableData[$i]
//        );
//    }

    /**
     * 全部记录导出
     */
    $result=ExpertInformation::all();
    $certificate=new ExpertCertificate();
    for ($j=0;$j<count($result);$j++){
        $s=$j+2;
        $data=json_decode(expertName($result[$j]));
        $data->picture=str_replace("\\","/",$data->picture);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[0].$s,$data->name);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[1].$s,$data->fk_code_gender_id);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[2].$s,$data->age);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[3].$s,$data->fk_certificate_type_id);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[4].$s,$data->cerificate_code);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[5].$s,$data->fk_code_bank_type_id);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[6].$s,$data->bank_code);
        if ($data->picture){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[7].$s,Request::instance()->domain().Request::instance()->root().$data->picture);
            $objPHPExcel->getActiveSheet()->getCell($cellName[7].$s)->getHyperlink()->setUrl(Request::instance()->domain().Request::instance()->root().$data->picture);
        }
        else{
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[7].$s,'');
        }
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[8].$s,$data->is_emergency);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[9].$s,$data->is_willing_attend_lectures);
//        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[9].$s,$data->is_trained);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[10].$s,$data->fk_code_politics_status_id);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[11].$s,$data->birthday);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[12].$s,$data->social_security_cards_code);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[13].$s,$data->fk_code_highest_degree_id);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[14].$s,$data->fk_code_title_id);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[15].$s,$data->title_certificate_code);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[16].$s,$data->qualification);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[17].$s,$data->qualification_code);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[18].$s,$data->position);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[19].$s,$data->fk_code_profession_id);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[20].$s,$data->fk_code_first_education_id);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[21].$s,$data->first_graduate_school_and_major);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[22].$s,$data->fk_code_highest_education_id);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[23].$s,$data->highest_graduate_school_and_major);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[24].$s,$data->fk_code_major_id);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[25].$s,$data->marjor_age);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[26].$s,$data->fk_org_id);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[27].$s,$data->fk_area_id);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[28].$s,$data->working_age);
//        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[27].$s,$data->is_senior);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[29].$s,$data->phone);
//        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[29].$s,$data->address);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[30].$s,$data->post_code);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[31].$s,$data->email_address);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[32].$s,$data->professional_technical_expertise);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[33].$s,$data->resume);

        $expert_certificate=$certificate->where('fk_expert_info_id',$data->key_id)->select();
        $n=34;
        foreach ($expert_certificate as $k => $v){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$n] . '1', '资格证书'.($n-33));
            $v['image']=str_replace("\\","/",$v['image']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$n].$s,Request::instance()->domain().Request::instance()->root().$v['image']);
            $objPHPExcel->getActiveSheet()->getCell($cellName[$n].$s)->getHyperlink()->setUrl(Request::instance()->domain().Request::instance()->root().$v['image']);
            $n++;
        }

//        $x=0;
//        foreach ($data as $key => $value){
//            $name[$x]=$key;
//            $val[$x]=$value;
//            $x++;
//        }
//        $expTableData=$val;
//        for ($num = 0; $num < $cellNum; $num++){
//            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$num].$s,$expTableData[$num]);
//        }
    }


    ob_end_clean();//这一步非常关键，用来清除缓冲区防止导出的excel乱码
    header('pragma:public');
    header('Content-type:application/vnd.ms-excel;charset=utf-8;name="' . $xlsTitle . '.xls"');
    header("Content-Disposition:attachment;filename=$fileName.xlsx");//"xls"参考下一条备注
    $objWriter = PHPExcel_IOFactory::createWriter(
        $objPHPExcel, 'Excel2007'
    );//"Excel2007"生成2007版本的xlsx，"Excel5"生成2003版本的xls
    $objWriter->save('php://output');
    exit;
}

/**
 * word文档导出
 * @param int $id 专家信息key_id
 * @author 崔同海
 * @data 2019/7/8 10:45
 */
function wordDown($id,$path){
    $param=ExpertInformation::get($id);
    $result=expertName($param);

    //调用插件
    vendor('PHPWord');
    vendor('PHPWord.IOFactory');

    $phpWord  =  new PhpWord();      //实例化phpWord类
//    $properties = $phpWord->getDocInfo();
//    $properties->setCreator('崔同海');     //创建者
//    $properties->setCompany('新德音');    //公司
//    $properties->setTitle('My title');    //biao
//    $properties->setDescription('My description');    //描述
//    $properties->setCategory('My category');    //分类
//    $properties->setLastModifiedBy('崔同海');    //最后修改者
//    $properties->setCreated( mktime(9, 29, 0, 6, 28, 2019) );    //创建时间
//    $properties->setModified( mktime(9, 29, 0, 6, 28, 2019) );    //修改时间
//    $properties->setSubject('My subject');     //主题
//    $properties->setKeywords('my, key, word');    //关键字

    $sectionStyle = array();
    $section = $phpWord->addSection($sectionStyle);    //创建一个有样式的页面

    //设置段样式
    $paragraphStyle = [
        'align'=>'center',
    ];

    //设置标题样式
    $titleStyle=[
        'size' => '20',
        'color' => 'black',
        'bold' => true,
    ];

    //添加标题(相关样式需要单独设置)
    $phpWord->addTitleStyle(1, $titleStyle,$paragraphStyle);
    $section->addTitle('专家信息表', 1);


    //设置文本样式
    $fontStyle = [
        'bold' => true,     //是否加粗
        'size' => '18',
        'color' => 'black',     //字体颜色
    ];

    //设置表格key属性文本样式
    $table_key_fontStyle=[
        'bold' => true,     //是否加粗
        'size' => '10',
        'color' => 'black',     //字体颜色
        'name'=>'微软雅黑',
    ];

    //设置表格中value属性文本样式
    $table_value_fontStyle=[
        'bold' => false,     //是否加粗
        'size' => '10',
        'color' => 'black',     //字体颜色
        'align'=>'center',
        'name'=>'微软雅黑',
    ];

    //添加页脚方法
    $footer = $section->addFooter();
    $footer->addPreserveText('Page {PAGE} of {NUMPAGES}.');     //向页眉或页脚添加页码或页数
    $breakCount = 0;       //设置换行数
    $section->addTextBreak($breakCount, $fontStyle, $paragraphStyle);       //设置换行

    $styleTable = [
        'borderSize'=>1,
        'borderColor'=>'black',
        'cellMargin'=>80,
    ];
    $styleImage=[
        'width'=>150,
        'height'=>147,
    ];
    $styleImage1=[
        'width'=>140,
        'height'=>170,
        'valign' => 'center',
        'align' => 'center'
    ];
    $styleCell = ['valign' => 'center'];
    // Add table style
    $phpWord->addTableStyle('myOwnTableStyle', $styleTable);
    // Add table
    $table = $section->addTable('myOwnTableStyle');

    $result['picture']=str_replace("\\","/",$result['picture']);
    // Add row设置行高
    $table->addRow(250);
    $table->addCell(1490, $styleCell)->addText('姓名',$table_key_fontStyle,$paragraphStyle);
    $table->addCell(2980, array('gridSpan' => 2,'valign' => 'center'))->addText($result['name'], $table_value_fontStyle,$paragraphStyle);
    if ($result['picture']){
        $table->addCell(1400, array('valign' => 'center','vMerge' => 'restart'))->addText('证件照', $table_key_fontStyle,$paragraphStyle);
        $table->addCell(2980, array('gridSpan' => 2,'valign' => 'center','vMerge' => 'restart'))->addImage($path.$result['picture'],$styleImage1);
    }
    else{
        $table->addCell(1400, array('valign' => 'center','vMerge' => 'restart'))->addText('证件照', $table_key_fontStyle,$paragraphStyle);
        $table->addCell(2980, array('gridSpan' => 2,'valign' => 'center','vMerge' => 'restart'))->addText('',$styleImage1);
    }

    $table->addRow();
    $table->addCell(1490, $styleCell)->addText('性别', $table_key_fontStyle,$paragraphStyle);
    $table->addCell(2980, array('gridSpan' => 2,'valign' => 'center'))->addText($result['fk_code_gender_id'], $table_value_fontStyle,$paragraphStyle);
    $table->addCell(1490, array('valign' => 'center','vMerge' => 'continue'));
    $table->addCell(2980, array('gridSpan' => 2,'valign' => 'center','vMerge' => 'continue'));

    $table->addRow(250);
    $table->addCell(1490, $styleCell)->addText('年龄', $table_key_fontStyle,$paragraphStyle);
    $table->addCell(2980, array('gridSpan' => 2,'valign' => 'center'))->addText($result['age'], $table_value_fontStyle,$paragraphStyle);
    $table->addCell(1490, array('valign' => 'center','vMerge' => 'continue'));
    $table->addCell(2980, array('gridSpan' => 2,'valign' => 'center','vMerge' => 'continue'));

    $table->addRow(250);
    $table->addCell(1490, $styleCell)->addText('证件类型', $table_key_fontStyle,$paragraphStyle);
    $table->addCell(2980, array('gridSpan' => 2,'valign' => 'center'))->addText($result['fk_certificate_type_id'], $table_value_fontStyle,$paragraphStyle);
    $table->addCell(1490, array('valign' => 'center','vMerge' => 'continue'));
    $table->addCell(2980, array('gridSpan' => 2,'valign' => 'center','vMerge' => 'continue'));

    $table->addRow(250);
    $table->addCell(1490, $styleCell)->addText('证件号码', $table_key_fontStyle,$paragraphStyle);
    $table->addCell(2980, array('gridSpan' => 2,'valign' => 'center'))->addText($result['cerificate_code'], $table_value_fontStyle,$paragraphStyle);
    $table->addCell(1490, array('valign' => 'center','vMerge' => 'continue'));
    $table->addCell(2980, array('gridSpan' => 2,'valign' => 'center','vMerge' => 'continue'));

    $table->addRow(250);
    $table->addCell(1490, $styleCell)->addText('开户行', $table_key_fontStyle,$paragraphStyle);
    $table->addCell(2980, array('gridSpan' => 2,'valign' => 'center'))->addText($result['fk_code_bank_type_id'], $table_value_fontStyle,$paragraphStyle);
    $table->addCell(1490, array('valign' => 'center','vMerge' => 'continue'));
    $table->addCell(2980, array('gridSpan' => 2,'valign' => 'center','vMerge' => 'continue'));

    $table->addRow(250);
    $table->addCell(1490, $styleCell)->addText('银行卡号', $table_key_fontStyle,$paragraphStyle);
    $table->addCell(2980, array('gridSpan' => 2,'valign' => 'center'))->addText($result['bank_code'], $table_value_fontStyle,$paragraphStyle);
    $table->addCell(1490, array('valign' => 'center','vMerge' => 'continue'));
    $table->addCell(2980, array('gridSpan' => 2,'valign' => 'center','vMerge' => 'continue'));

    $table->addRow(250);
    $table->addCell(1490, $styleCell)->addText('是否应急专家', $table_key_fontStyle,$paragraphStyle);
    $table->addCell(2980, array('gridSpan' => 2,'valign' => 'center'))->addText($result['is_emergency'], $table_value_fontStyle,$paragraphStyle);
     $table->addCell(1490, $styleCell)->addText('是否愿意参加科普讲座', $table_key_fontStyle,$paragraphStyle);
    $table->addCell(2980, array('gridSpan' => 2,'valign' => 'center'))->addText($result['is_willing_attend_lectures'], $table_value_fontStyle,$paragraphStyle);

    $table->addRow(250);
    $table->addCell(1490, $styleCell)->addText('政治面貌', $table_key_fontStyle,$paragraphStyle);
    $table->addCell(2980, array('gridSpan' => 2,'valign' => 'center'))->addText($result['fk_code_politics_status_id'], $table_value_fontStyle,$paragraphStyle);
    $table->addCell(1490, $styleCell)->addText('出生日期', $table_key_fontStyle,$paragraphStyle);
    $table->addCell(2980, array('gridSpan' => 2,'valign' => 'center'))->addText($result['birthday'], $table_value_fontStyle,$paragraphStyle);

    $table->addRow(250);
    $table->addCell(1490, $styleCell)->addText('社会保障卡号', $table_key_fontStyle,$paragraphStyle);
    $table->addCell(2980, array('gridSpan' => 2,'valign' => 'center'))->addText($result['social_security_cards_code'], $table_value_fontStyle,$paragraphStyle);
    $table->addCell(1490, $styleCell)->addText('最高学位', $table_key_fontStyle,$paragraphStyle);
    $table->addCell(2980, array('gridSpan' => 2,'valign' => 'center'))->addText($result['fk_code_highest_degree_id'], $table_value_fontStyle,$paragraphStyle);

    $table->addRow(250);
    $table->addCell(1490, $styleCell)->addText('职称', $table_key_fontStyle,$paragraphStyle);
    $table->addCell(2980, array('gridSpan' => 2,'valign' => 'center'))->addText($result['fk_code_title_id'], $table_value_fontStyle,$paragraphStyle);
    $table->addCell(1490, $styleCell)->addText('职称证书号', $table_key_fontStyle,$paragraphStyle);
    $table->addCell(2980, array('gridSpan' => 2,'valign' => 'center'))->addText($result['title_certificate_code'], $table_value_fontStyle,$paragraphStyle);

    $table->addRow(250);
    $table->addCell(1490, $styleCell)->addText('执业资格', $table_key_fontStyle,$paragraphStyle);
    $table->addCell(2980, array('gridSpan' => 2,'valign' => 'center'))->addText($result['qualification'], $table_value_fontStyle,$paragraphStyle);
    $table->addCell(1490, $styleCell)->addText('执业资格证书编号', $table_key_fontStyle,$paragraphStyle);
    $table->addCell(2980, array('gridSpan' => 2,'valign' => 'center'))->addText($result['qualification_code'], $table_value_fontStyle,$paragraphStyle);

    $table->addRow(250);
    $table->addCell(1490, $styleCell)->addText('职务', $table_key_fontStyle,$paragraphStyle);
    $table->addCell(2980, array('gridSpan' => 2,'valign' => 'center'))->addText($result['position'], $table_value_fontStyle,$paragraphStyle);
    $table->addCell(1490, $styleCell)->addText('所属行业', $table_key_fontStyle,$paragraphStyle);
    $table->addCell(2980, array('gridSpan' => 2,'valign' => 'center'))->addText($result['fk_code_profession_id'], $table_value_fontStyle,$paragraphStyle);

    $table->addRow(250);
    $table->addCell(1490, $styleCell)->addText('第一学历', $table_key_fontStyle,$paragraphStyle);
    $table->addCell(2980, array('gridSpan' => 2,'valign' => 'center'))->addText($result['fk_code_first_education_id'], $table_value_fontStyle,$paragraphStyle);
    $table->addCell(1490, $styleCell)->addText('第一学历毕业院校及专业', $table_key_fontStyle,$paragraphStyle);
    $table->addCell(2980, array('gridSpan' => 2,'valign' => 'center'))->addText($result['first_graduate_school_and_major'], $table_value_fontStyle,$paragraphStyle);

    $table->addRow(250);
    $table->addCell(1490, $styleCell)->addText('最高学历', $table_key_fontStyle,$paragraphStyle);
    $table->addCell(2980, array('gridSpan' => 2,'valign' => 'center'))->addText($result['fk_code_highest_education_id'], $table_value_fontStyle,$paragraphStyle);
    $table->addCell(1490, $styleCell)->addText('最高学历毕业院校及专业', $table_key_fontStyle,$paragraphStyle);
    $table->addCell(2980, array('gridSpan' => 2,'valign' => 'center'))->addText($result['highest_graduate_school_and_major'], $table_value_fontStyle,$paragraphStyle);

    $table->addRow(250);
    $table->addCell(1490, $styleCell)->addText('从事专业', $table_key_fontStyle,$paragraphStyle);
    $table->addCell(2980, array('gridSpan' => 2,'valign' => 'center'))->addText($result['fk_code_major_id'], $table_value_fontStyle,$paragraphStyle);
    $table->addCell(1490, $styleCell)->addText('从事专业年限', $table_key_fontStyle,$paragraphStyle);
    $table->addCell(2980, array('gridSpan' => 2,'valign' => 'center'))->addText($result['marjor_age'], $table_value_fontStyle,$paragraphStyle);

    $table->addRow(250);
    $table->addCell(1490, $styleCell)->addText('所属单位', $table_key_fontStyle,$paragraphStyle);
    $table->addCell(2980, array('gridSpan' => 2,'valign' => 'center'))->addText($result['fk_org_id'], $table_value_fontStyle,$paragraphStyle);
    $table->addCell(1490, $styleCell)->addText('所属区域', $table_key_fontStyle,$paragraphStyle);
    $table->addCell(2980, array('gridSpan' => 2,'valign' => 'center'))->addText($result['fk_area_id'], $table_value_fontStyle,$paragraphStyle);

    $table->addRow(250);
    $table->addCell(1490, $styleCell)->addText('工龄', $table_key_fontStyle,$paragraphStyle);
    $table->addCell(2980, array('gridSpan' => 2,'valign' => 'center'))->addText($result['working_age'], $table_value_fontStyle,$paragraphStyle);
//    $table->addCell(1490, $styleCell)->addText('是否资深专家', $table_key_fontStyle,$paragraphStyle);
//    $table->addCell(2980, array('gridSpan' => 2,'valign' => 'center'))->addText($result['is_senior'], $table_value_fontStyle,$paragraphStyle);
    $table->addCell(1490, $styleCell)->addText('移动电话', $table_key_fontStyle,$paragraphStyle);
    $table->addCell(2980, array('gridSpan' => 2,'valign' => 'center'))->addText($result['phone'], $table_value_fontStyle,$paragraphStyle);
//    $table->addCell(1490, $styleCell)->addText('家庭地址', $table_key_fontStyle,$paragraphStyle);
//    $table->addCell(2980, array('gridSpan' => 2,'valign' => 'center'))->addText($result['address'], $table_value_fontStyle,$paragraphStyle);

    $table->addRow(250);
    $table->addCell(1490, $styleCell)->addText('邮政编码', $table_key_fontStyle,$paragraphStyle);
    $table->addCell(2980, array('gridSpan' => 2,'valign' => 'center'))->addText($result['post_code'], $table_value_fontStyle,$paragraphStyle);
    $table->addCell(1490, $styleCell)->addText('电子邮箱', $table_key_fontStyle,$paragraphStyle);
    $table->addCell(2980, array('gridSpan' => 2,'valign' => 'center'))->addText($result['email_address'], $table_value_fontStyle,$paragraphStyle);

    $table->addRow(250);
    $table->addCell(1490, $styleCell)->addText('专业技术特长', $table_key_fontStyle,$paragraphStyle);
    $table->addCell(2980, array('gridSpan' => 5,'valign' => 'center'))->addText($result['professional_technical_expertise'], $table_value_fontStyle,$paragraphStyle);

    $result['resume']=strip_tags($result['resume']);
    $trans = array("&nbsp;" => " ");
    $result['resume']=strtr($result['resume'],$trans);
    $table->addRow(250);
    $table->addCell(1490, $styleCell)->addText('简历', $table_key_fontStyle,$paragraphStyle);
    $table->addCell(2980, array('gridSpan' => 5,'valign' => 'center'))->addText($result['resume'], $table_value_fontStyle,$paragraphStyle);


    $certificateModel=new \app\index\model\ExpertCertificate();
    $certificate=$certificateModel->where('fk_expert_info_id',$id)->select();
    $i=0;
    $j=1;
    foreach ($certificate as $key => $val){
        if ($i==0){
            $table->addRow(3000);
        }
        $val['image']=str_replace("\\","/",$val['image']);
        $table->addCell(1490, $styleCell)->addText('资格证书'.$j, $table_key_fontStyle,$paragraphStyle);
        $table->addCell(2980, array('gridSpan' => 2))->addImage($path.$val['image'],$styleImage);
        $i++;
        if ($i==2){
            $i=0;
        }
        $j++;
    }

    header('Content-type: application/docx');
    header('Content-Disposition: attachment; filename="专家信息表.docx"');

    $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
    $objWriter->save('php://output');
    exit;
}

function blank_template()
{
    $expTitle = '专家信息录入模板';

    $xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
    $fileName = $expTitle;//or $xlsTitle 文件名称可根据自己情况设定

    $objPHPExcel = new PHPExcel();//方法一
    $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA',
        'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX',
        'AY', 'AZ');

    //文本居中
    $objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
//    $objPHPExcel->getActiveSheet()->getStyle('H')->getAlignment()->setWrapText(true);         设置自动换行

    //文本超出单元格自动换行
//    for($z=0;$z<count($cellName);$z++){
    for ($z = 0; $z < 33; $z++) {
        $objPHPExcel->getActiveSheet()->getStyle($cellName[$z])->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension($cellName[$z])->setWidth(20);
    }

    //设置列名称
//    for ($i = 0; $i < $cellNum; $i++) {
//        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i] . '1', $expCellName[$i]);
//    }

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[0] . '1', '姓名');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[1] . '1', '性别');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[2] . '1', '年龄');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[3] . '1', '证件类型');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[4] . '1', '证件号码');

    $objPHPExcel->getActiveSheet()->getStyle('E2')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);//防止出现科学计数
    $objPHPExcel->getActiveSheet()->getStyle('G2')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);//防止出现科学计数
//    $objValidation1 = $objPHPExcel->getActiveSheet()->getCell('E2')->getDataValidation();
//    $objValidation1->setType(\PHPExcel_Cell_DataType::TYPE_STRING);
//    $objValidation1 = $objPHPExcel->getActiveSheet()->getCell('G2')->getDataValidation();
//    $objValidation1->setType(\PHPExcel_Cell_DataType::TYPE_STRING);

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[5] . '1', '开户行');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[6] . '1', '银行卡号');
//    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[7] . '1', '证件照');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[7] . '1', '是否应急专家');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[8] . '1', '是否愿意参加科普讲座');
//    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[9] . '1', '是否培训');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[9] . '1', '政治面貌');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[10] . '1', '出生日期');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[11] . '1', '社会保障卡号');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[12] . '1', '最高学位');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[13] . '1', '职称');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[14] . '1', '职称证书号');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[15] . '1', '执业资格');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[16] . '1', '执业资格证书编号');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[17] . '1', '职务');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[18] . '1', '所属行业');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[19] . '1', '第一学历');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[20] . '1', '第一学历毕业院校及专业');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[21] . '1', '最高学历');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[22] . '1', '最高学历毕业院校及专业');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[23] . '1', '从事专业');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[24] . '1', '从事专业年限（单位：年）');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[25] . '1', '所属单位');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[26] . '1', '所属区域');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[27] . '1', '工龄（单位：年）');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[28] . '1', '移动电话');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[29] . '1', '邮政邮编');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[30] . '1', '电子邮箱');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[31] . '1', '专业技术特长');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[32] . '1', '简历');

    $base_code=new BaseCode();

//    $fk_code_bank_type_id=$base_code->where('parent_ID',789)->select();//银行类型
//    middle($fk_code_bank_type_id,$objPHPExcel,'F');

    $fk_code_gender_id=$base_code->where('parent_ID',778)->select();//性别
    middle($fk_code_gender_id,$objPHPExcel,'B');

    $fk_certificate_type_id=$base_code->where('parent_ID',780)->select();//证件类型
    middle($fk_certificate_type_id,$objPHPExcel,'D');

    $fk_code_politics_status_id=$base_code->where('parent_ID',779)->select();//政治面貌
    middle($fk_code_politics_status_id,$objPHPExcel,'J');

    $fk_code_highest_degree_id=$base_code->where('parent_ID',860)->select();//最高学位
    middle($fk_code_highest_degree_id,$objPHPExcel,'M');

//    $fk_code_title_id=$base_code->where('parent_ID',782)->select();//职称
//    middle($fk_code_title_id,$objPHPExcel,'N');

    $fk_code_first_education_id=$base_code->where('parent_ID',781)->select();//第一学历
    middle($fk_code_first_education_id,$objPHPExcel,'T');

    $fk_code_highest_education_id=$base_code->where('parent_ID',781)->select();//最高学历
    middle($fk_code_highest_education_id,$objPHPExcel,'V');

    $fk_code_major_id=$base_code->where('parent_ID',783)->select();//从事专业
    middle($fk_code_major_id,$objPHPExcel,'X');

    $fk_code_profession_id=$base_code->where('type_flag','profession')->where('level',2)->select();//所属行业
    $objValidation1 = $objPHPExcel->getActiveSheet()->getCell('S2')->getDataValidation(); //输入框鼠标放上给出提示
    $objValidation1->setType(\PHPExcel_Cell_DataValidation::TYPE_NONE)
        ->setAllowBlank(false)
        ->setShowInputMessage(true)
        ->setPromptTitle('提示')
        ->setPrompt('请参照下列给出的行业信息输入您的所属行业，此项数据不允许私自定义！');
    foreach ($fk_code_profession_id as $key=>$value){
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.($key+5),$value['para_name']);
    }


    $is_arr=array(
        '0'=>'否',
        '1'=>'是'
    );
    is_middle($is_arr,$objPHPExcel,'H');//是否为应急专家
    is_middle($is_arr,$objPHPExcel,'I');//是否愿意参加科普讲座

//    $organise=new \app\xt\model\Organise();
//    $fk_org_id=$organise->select();//所属单位
//    organise_middle($fk_org_id,$objPHPExcel,'X');

    $area=new Area();
    $fk_area_id=$area->where('LEVEL_UP_KEYID',18156)->select();//所属区域
    organise_middle($fk_area_id,$objPHPExcel,'AA');

    ob_end_clean();//这一步非常关键，用来清除缓冲区防止导出的excel乱码
    header('pragma:public');
    header('Content-type:application/vnd.ms-excel;charset=utf-8;name="' . $xlsTitle . '.xls"');
    header("Content-Disposition:attachment;filename=$fileName.xlsx");//"xls"参考下一条备注
    $objWriter = PHPExcel_IOFactory::createWriter(
        $objPHPExcel, 'Excel2007'
    );//"Excel2007"生成2007版本的xlsx，"Excel5"生成2003版本的xls
    $objWriter->save('php://output');
    exit;

}


function excel_import()
{
        //导入数据
        vendor("PHPExcel.PHPExcel"); //方法一
        $objPHPExcel = new PHPExcel();
        //获取表单上传文件
        $file = request()->file('excel');
        $info = $file->validate(['ext' => 'xlsx'])->move(ROOT_PATH . 'public/excel');  //上传验证后缀名,以及上传之后移动的地址  E:\wamp\www\bick\public
        if ($info) {
            $exclePath = $info->getSaveName();  //获取文件名
            $file_name = ROOT_PATH . 'public/excel' . DS . $exclePath;//上传文件的地址
            $objReader = \PHPExcel_IOFactory::createReader("Excel2007");
            $obj_PHPExcel = $objReader->load($file_name, $encode = 'utf-8');  //加载文件内容,编码utf-8
            $excel_array = $obj_PHPExcel->getSheet(0)->toArray();   //转换为数组格式
            array_shift($excel_array);  //删除第一个数组(标题);
            $i = 0;
            $base_code=new BaseCode();
            $organise=new \app\xt\model\Organise();
            $area=new Area();
            foreach ($excel_array as $k => $v) {
                foreach ($v as $x=>$y){
                    if ($x==1){
                        $z=$base_code->field('Key_Id as key_id')->where('type_flag','gender')->where('para_name',$y)->find();
                        if ($z){
                            $v[$x]=$z['key_id'];
                        }
                    }
                    if ($x==3){
                        $z=$base_code->field('Key_Id as key_id')->where('type_flag','certificateType')->where('para_name',$y)->find();
                        if ($z){
                            $v[$x]=$z['key_id'];
                        }
                    }
//                    if ($x==5){
//                        $z=$base_code->field('Key_Id as key_id')->where('type_flag','bank_type')->where('para_name',$y)->find();
//                        $v[$x]=$z['key_id'];
//                    }
                    if ($x==7){
                        if ($y=='是')
                            $v[$x]=1;
                        else
                            $v[$x]=0;
                    }
                    if ($x==8){
                        if ($y=='是')
                            $v[$x]=1;
                        else
                            $v[$x]=0;
                    }
                    if ($x==9){
                        $z=$base_code->field('Key_Id as key_id')->where('type_flag','politicsStatus')->where('para_name',$y)->find();
                        if ($z){
                            $v[$x]=$z['key_id'];
                        }
                    }
                    if ($x==12){
                        $z=$base_code->field('Key_Id as key_id')->where('type_flag','education')->where('para_name',$y)->find();
                        if ($z){
                            $v[$x]=$z['key_id'];
                        }
                    }
//                    if ($x==13){
//                        $z=$base_code->field('Key_Id as key_id')->where('type_flag','title')->where('para_name',$y)->find();
//                        $v[$x]=$z['key_id'];
//                    }
                    if ($x==18){
                        $z=$base_code->field('Key_Id as key_id')->where('type_flag','profession')->where('level',2)->where('para_name',$y)->find();
                        if ($z){
                            $v[$x]=$z['key_id'];
                        }
                    }
                    if ($x==19){
                        $z=$base_code->field('Key_Id as key_id')->where('type_flag','degree')->where('para_name',$y)->find();
                        if ($z){
                            $v[$x]=$z['key_id'];
                        }
                    }
                    if ($x==21){
                        $z=$base_code->field('Key_Id as key_id')->where('type_flag','degree')->where('para_name',$y)->find();
                        if ($z){
                            $v[$x]=$z['key_id'];
                        }
                    }
                    if ($x==23){
                        $z=$base_code->field('Key_Id as key_id')->where('type_flag','major')->where('para_name',$y)->find();
                        if ($z){
                            $v[$x]=$z['key_id'];
                        }
                    }
//                    if ($x==25){
//                        $z=$organise->field('keyid as key_id')->where('dept_name',$y)->find();
//                        $v[$x]=$z['key_id'];
//                    }
                    if ($x==26){
                        $z=$area->field('keyid as key_id')->where('level',2)->where('dept_name',$y)->find();
                        if ($z){
                            $v[$x]=$z['key_id'];
                        }
                    }
                }
                $city[$k]['name'] = $v[0];
                $city[$k]['fk_code_gender_id'] = $v[1];
                $city[$k]['age'] = $v[2];
                $city[$k]['fk_certificate_type_id'] = $v[3];
                $city[$k]['cerificate_code'] = $v[4];
                $city[$k]['fk_code_bank_type_id'] = $v[5];
                $city[$k]['bank_code'] = $v[6];
                $city[$k]['is_emergency'] = $v[7];
                $city[$k]['is_willing_attend_lectures'] = $v[8];
                $city[$k]['fk_code_politics_status_id'] = $v[9];
                $city[$k]['birthday'] = $v[10];
                $city[$k]['social_security_cards_code'] = $v[11];
                $city[$k]['fk_code_highest_degree_id'] = $v[12];
                $city[$k]['fk_code_title_id'] = $v[13];
                $city[$k]['title_certificate_code'] = $v[14];
                $city[$k]['qualification'] = $v[15];
                $city[$k]['qualification_code'] = $v[16];
                $city[$k]['position'] = $v[17];
                $city[$k]['fk_code_profession_id'] = $v[18];
                $city[$k]['fk_code_first_education_id'] = $v[19];
                $city[$k]['first_graduate_school_and_major'] = $v[20];
                $city[$k]['fk_code_highest_education_id'] = $v[21];
                $city[$k]['highest_graduate_school_and_major'] = $v[22];
                $city[$k]['fk_code_major_id'] = $v[23];
                $city[$k]['marjor_age'] = $v[24];
                $city[$k]['fk_org_id'] = $v[25];
                $city[$k]['fk_area_id'] = $v[26];
                $city[$k]['working_age'] = $v[27];
                $city[$k]['phone'] = $v[28];
                $city[$k]['post_code'] = $v[29];
                $city[$k]['email_address'] = $v[30];
                $city[$k]['professional_technical_expertise'] = $v[31];
                $city[$k]['resume'] = $v[32];
                $i++;
                if ($k==0){
                    ExpertInformation::create($city[$k]);
                }
            }
        } else {
            echo $file->getError();
        }
//    return 0;
}

function middle($fk_code,$objPHPExcel,$letter){
    foreach ($fk_code as $key => $value){
        $arr[$key]=$value['para_name'];
    }
    $list = implode(',', $arr);
    $objValidation1 = $objPHPExcel->getActiveSheet()->getCell($letter.'2')->getDataValidation(); //从第2行开始有下拉样式
    $objValidation1->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST)
        ->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_INFORMATION)
        ->setAllowBlank(false)
        ->setShowInputMessage(true)
        ->setShowErrorMessage(true)
        ->setShowDropDown(true)
        ->setErrorTitle('输入的值有误')
        ->setError('您输入的值不在下拉框列表内.')
        ->setPromptTitle('下拉选择框')
        ->setPrompt('请从下拉框中选择您需要的值！')
        ->setFormula1('"' . $list . '"');
//    $data=ExpertInformation::all();
//    foreach ($data as $k => $v) {
//        /*设置下拉*/
//        $list = implode(',', $arr);
//        $objValidation1 = $objPHPExcel->getActiveSheet()->getCell($letter . ($k + 3))->getDataValidation();
//        $objValidation1->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST)
//            ->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_INFORMATION)
//            ->setAllowBlank(false)
//            ->setShowInputMessage(true)
//            ->setShowErrorMessage(true)
//            ->setShowDropDown(true)
//            ->setErrorTitle('输入的值有误')
//            ->setError('您输入的值不在下拉框列表内.')
//            ->setPromptTitle('下拉选择框')
//            ->setPrompt('请从下拉框中选择您需要的值！')
//            ->setFormula1('"' . $list . '"');
//    }
}
function is_middle($arr,$objPHPExcel,$letter){
    $list = implode(',', $arr);
    $objValidation1 = $objPHPExcel->getActiveSheet()->getCell($letter.'2')->getDataValidation(); //从第2行开始有下拉样式
    $objValidation1->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST)
        ->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_INFORMATION)
        ->setAllowBlank(false)
        ->setShowInputMessage(true)
        ->setShowErrorMessage(true)
        ->setShowDropDown(true)
        ->setErrorTitle('输入的值有误')
        ->setError('您输入的值不在下拉框列表内.')
        ->setPromptTitle('下拉选择框')
        ->setPrompt('请从下拉框中选择您需要的值！')
        ->setFormula1('"' . $list . '"');
}
function organise_middle($fk_code,$objPHPExcel,$letter){
    foreach ($fk_code as $key => $value){
        $arr[$key]=$value['dept_name'];
    }
    $list = implode(',', $arr);
    $objValidation1 = $objPHPExcel->getActiveSheet()->getCell($letter.'2')->getDataValidation(); //从第2行开始有下拉样式
    $objValidation1->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST)
        ->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_INFORMATION)
        ->setAllowBlank(false)
        ->setShowInputMessage(true)
        ->setShowErrorMessage(true)
        ->setShowDropDown(true)
        ->setErrorTitle('输入的值有误')
        ->setError('您输入的值不在下拉框列表内.')
        ->setPromptTitle('下拉选择框')
        ->setPrompt('请从下拉框中选择您需要的值！')
        ->setFormula1('"' . $list . '"');
}