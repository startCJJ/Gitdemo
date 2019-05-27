<?php

namespace app\index\controller;

use think\Controller;
use think\Session;
use think\Validate;

/**
 * 前台用户控制器
 */
class User extends Controller {
	/**
	 * 显示登录页面
	 */
	public function login() {
		return $this->fetch();
	}

	/**
	 * 判断是否登录成功
	 */
	public function doLogin() {
		$data = input('param.');

		// 校验验证码
		if (!captcha_check($data['captcha'])) {
			$this->error("验证码非法");
		};

		$user = model('user')
			->field('id, username')
			->where('username', '=', $data['username'])
			->where('password', '=', md5($data['password']))
			->find();
		if ($user) {
			Session::set('user', $user);
			$this->success('登录成功', url('index/product/index'));
		} else {
			$this->error("登录失败");
		}
	}

	/**
	 * 用户退出
	 */
	public function logout() {
		if (!session('?user')) {
			$this->error("请先登录...", url('index/user/login'));
		}
		session('user', null);
		// 跳转到登录页面
		$this->redirect(url('index/user/login'));
	}

	/**
	 * 用户注册页面
	 */
	public function register() {
		return $this->fetch();
	}

	/**
	 * 判断是否注册成功
	 */
	public function doRegister() {
		$data = input('param.');

		// 校验验证码
		if (!captcha_check($data['captcha'])) {
			$this->error("验证码非法");
		};

		// 图片上传
		$file = request()->file('user_photo');
		if ($file) {
			$path = ROOT_PATH . "public/static/upload";
			$info = $file
				->validate([
					'ext' => "jpg,jpeg,png,gif",
					'size' => 1024000,
				])
				->move($path);
			if (is_object($info) && $info->getSaveName()) {
				$data['user_photo'] = $info->getSaveName();
			} else {
				$this->error($file->getError());
			}
		} else {
			$data['user_photo'] = "";
		}

		$m = model('User');
		$res = $m
			->validate(true)
			// 过滤非数据表字段 (repassword)
			->allowField(true)
			->save($data);
		if ($res) {
			$this->success("注册成功", url('index/user/login'));
		} else {
			$this->error($m->getError());
		}
	}

	/**
	 * 显示用户个人中心
	 *
	 * @return \think\Response
	 */
	public function center() {
		if (!session('?user')) {
			$this->error("请先登录...", url('index/user/login'));
		}
		return $this->fetch();
	}
}
