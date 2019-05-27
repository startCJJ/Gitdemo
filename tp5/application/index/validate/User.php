<?php

namespace app\index\validate;

use think\Validate;

/**
 * 前台用户验证器
 */
class User extends Validate
{
    // 声明验证规则
    protected $rule = [
        // '字段名' => '规则1|规则2|...'
        'username'   => 'require|length:2,30|unique:user',
        'password'   => 'require|min:6',
        'repassword' => 'require|confirm:password',
    ];

    // 声明报错消息
    protected $message = [
        // '字段1.规则1' => '消息1',
        // '字段1.规则2' => '消息2',
        'username.require'   => "用户名不能为空",
        'username.length'    => '用户名长度非法(2-30位)',
        'username.unique'    => '用户名已被占用,请换一个',
        'password.require'   => '密码不能为空',
        'password.min'       => '密码最短是6位',
        'repassword.require' => "确认密码不能为空",
        'repassword.confirm' => "两次输入的密码不一致,请重新输入",
    ];
}
