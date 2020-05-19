<?php
/**
 * Created by PhpStorm.
 * User: QinHsiu
 * Date: 2020/3/6
 * Time: 9:35
 */

return array(
    //'配置项'=>'配置值'
    //模版常量
    'TMPL_PARSE_STRING' => array(
        '__ADMIN__' => __ROOT__.'/Public/Admin'
    ),
    /* 数据库设置 */
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  'localhost', // 服务器地址
    'DB_NAME'               =>  'db_learn',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  'root',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'il_',    // 数据库表前缀

    //显示跟踪信息
    'SHOW_PAGE_TRACE'       =>  true,   //默认为false，开启则改写成true

    //动态加载文件
    'LOAD_EXT_FILE'         =>  'info', //包含文件名的字符串，多个文件名之间使用英文半角逗号分割

    //RBAC权限数据信息
    //角色数组
    'RBAC_ROLES'            =>      array(
        0   =>  '系统管理员',
        1   =>  '管理员',
        2   =>  'VIP用户',
        3   =>  '普通用户'
    ),
    //权限数组（关联角色数组）
    'RBAC_ROLE_AUTHS'       =>      array(
        0   => '*/*',//所有权限
        //0   =>  array('index/*'),
        1   =>  array('index/*','email/*','notice/*','active/*','user/add','user/*'),
        2   =>  array('index/*','email/*','active/deliver','active/del','active/index','notice/index','user/edit','user/index','user/del'),
        3   =>  array('index/*','email/*','user/edit','notice/index','user/index','user/edit','user/del','active/*')
    ),

    'URL_MODEL'=>2,
    'MODULE_ALLOW_LIST'=> array('Home','Admin'),

    //默认初始化module为home
    'DEFAULT_MODULE'=>'Home',
);
