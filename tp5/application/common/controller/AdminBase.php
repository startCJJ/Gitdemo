<?php

namespace app\common\controller;

use think\Controller;

/**
 * 后台控制器基类
 */
class AdminBase extends Controller
{
    // 初始化方法
    protected function _initialize()
    {
        // 管理员登录后,才能看后台的内容
        // 判断管理员的登录状态
        if (!session('?admin')) {
            $this->error("请先登录...", url('admin/Admin/login'));
        }
    }
}
