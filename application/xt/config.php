<?php
//配置文件
return [
    // 设置数据集返回类型
    'resultset_type'  => 'collection',

    /**
     * 登录白名单
     * @auth 谢灿 2019年6月18日
     **/
    'login_white_list' => [
        "xt.Index" => ['login'],
        'xt.User' => ['login']
    ],

    /**
     * 登录验证规则
     *  当方法内 存在 _msg(错误信息) 时
     *  使用该错误信息作为验证提示信息
     *  自定义regex在xt\validate\BaseValidate中定义
     *  tp5.0 内置规则可查阅https://www.kancloud.cn/manual/thinkphp5/129356
     * @var array
     * @modify 谢灿 2019-6-18 16:36:33 移植到模块config.php中.
     */
    'rules' => [
        'xt.BaseCode' => [
            'listBaseCode' => [
//                'flag' => 'require',
                'parent_id' => 'number|>=:0',
                'level' => 'number|between:0,2',
                '_msg' => [
//                    'flag' => ['require'=>'请输入基础代码代号']
                ]
            ]
        ],
        'xt.User' => [
            'index' => [
            ],
            'login' => [
                'account|账号account' => 'require|min:1',
                'password|密码password' => 'require|min:6',
                '_msg' => [
                    'account' => ['require' => '请输入账号', 'min' => '账号长度不能为空']
                ]
            ],
            'save' => [
                'account|账号account'=>'require|min:1',
                'password|密码password' => 'require|min:6',
                'name|姓名name' => 'require',
                'nick_name|昵称nick_name' => 'require'
            ],
            'update' => [
                'account|账号account'=>'min:1',
                'password|密码password' => 'min:6',
//                'name|姓名' => '',
//                'nick_name|昵称' => ''
            ]
        ],
        'xt.Organise' => [
            'index' => [
//                'parent_id|上级parent_id' => 'number|min:0',
            ],
            'save' => [
                'name|组织机构名称name' => 'require',
                'sort|排序号sort' => 'require',
                'parent_id|上级组织机构parent_id'=>'number'
            ],
            'update' => [
                'name|组织机构名称name' => 'require',
                'parent_id|上级组织机构parent_id'=>'number|min:0'
            ],
        ],
        //地区
        'xt.Area'=>[
            'save'=>[
                'name|地区名name' => 'require',
                'code|编码code' => 'require',
                'parent_id|上级地区parent_id'=>'number'
            ],
            'update' => [
                'name|组织机构名称name' => 'require',
                'parent_id|上级组织机构parent_id'=>'number|min:0'
            ],
        ],

        'index.ExpertOrg' => [
            'index' => [
                'parent_id|上级parent_id' => 'number|min:0',
            ],
            'save' => [
                'name|单位名称name' => 'require',
                'code|编码code' => 'require',
                'parent_id|上级单位parent_id'=>'number'
            ],
            'update' => [
                'name|单位名称name' => 'require',
                'parent_id|上级单位parent_id'=>'number|min:0'
            ],
        ],
        'index.ExpertInformation'=>[
            'save'=>[
//                'bank_code|银行卡号bank_code'=>'max:19',
//                'name|姓名name'=>'require|chs',
//                'certificate_code|证件号码certificate_code'=>'require|length:18',
//                'age|年龄age'=>'number|min:0',
//                'birthday|出生日期birthday'=>'require',
//                'social_security_cards_code|社会保障卡号'=>'',
//                'picture|照片picture'=>'image|fileSize:2M',
//                'title_certificate_code|职称证书号'=>'',
//                'position|职务'=>'',
//                'first_graduate_school_and_major|第一学历毕业院校及专业'=>'',
//                'highest_graduate_school_and_major|最高学历毕业院校及专业'=>'',
//                'major|从事专业'=>'require',
//                'marjor_age|从事专业年限'=>'require',
//                'working_age|工龄'=>'',
//                'phone|移动电话'=>'require',
//                'address|家庭地址'=>'',
//                'post_code|家庭邮编'=>'',
//                'email_address|电子邮箱'=>'',
//                'professional_technical_expertise|专业技术特长'=>'require',
//                'operate_id|修改时间'=>'',
//                'operate_name|操作人'=>'',
//                'fk_code_bank_type_id|开户行'=>'',
//                'fk_code_gender_id|性别'=>'require',
//                'fk_certificate_type_id|证件类型'=>'require',
//                'fk_code_politics_status_id|政治面貌'=>'',
//                'fk_code_highest_degree_id|最高学位'=>'',
//                'fk_code_title_id|职称证书号'=>'require',
//                'fk_code_first_education_id|第一学历'=>'',
//                'fk_code_highest_education_id|最高学历'=>'',
//                'fk_code_profession_id|所属行业'=>'require',
//                'fk_org_id|所属单位'=>'require',
//                'fk_area_id|所属区域'=>'require',
//                'is_senior|是否资深专家'=>'',
//                'is_emergency|是否为应急专家'=>'',
//                'is_trained|是否培训'=>'',
            ]
        ],

        'index.ExpertCertificate'=>[
            'save'=>[
                'sort|序号sort'=>'require',
                'name|名称name'=>'require',
                'code|编号code'=>'require',
                'fk_expert_info_id|所属专家信息fk_expert_info_id'=>'require',
                'image|图片'=>'image'
            ],
        ],
    ]
];