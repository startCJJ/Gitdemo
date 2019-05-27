<?php

namespace app\admin\controller;

use think\Controller;

/**
 * 后台管理员控制器
 */
class Admin extends Controller {

	/**
	 * 前置操作,只有login和dologin两个方法不需要检验管理员状态
	 *
	 * except 排除需要验证的方法
	 */
	protected $beforeActionList = [
		'checkAdmin' => ['except' => 'login,dologin'],
	];

	/**
	 * 校验管理员状态
	 */
	public function checkAdmin() {
		if (!session('?admin')) {
			$this->error("请先登录...", url('admin/admin/login'));
		}
	}

	/**
	 * 后台登录
	 */
	public function login() {

		return $this->fetch();
	}

	/**
	 * 后台登录验证
	 */
	public function doLogin() {
		$data = input('param.');
		if (!captcha_check($data['captcha'])) {
			$this->error('验证码非法');
		}

		$admin = model('Admin')->getAdmin($data);
		if ($admin) {
			session('admin', $admin);
			$this->success('登录成功', url('admin/index/index'));
		} else {
			$this->error("登录失败");
		}
	}

	/**
	 * 管理员退出
	 */
	public function logout() {
		session('admin', null);

		$this->success("退出成功", url('admin/admin/login'));
	}

	/**
	 * 管理员列表
	 */
	public function index() {
		$list = model('Admin')->getList();

		$this->assign('list', $list);

		return $this->fetch();
	}

	/**
	 * 删除管理员
	 *
	 * @param  int  $id 管理员的id
	 */
	public function delete($id) {
		if (is_numeric($id) && $id > 0) {
			$res = model('Admin')
				->where('id', '=', $id)
				->delete();
			if ($res) {
				$this->success('删除成功', url('admin/admin/index'));
			} else {
				$this->error('删除失败');
			}
		} else {
			$this->error('参数非法');
		}
	}

	/**
	 * 添加管理员
	 */
	public function create() {

		return $this->fetch();
	}

	/**
	 * 添加管理员验证
	 */
	public function save() {
		$data = input('param.');
		$data['nick_name'] = $data['adminname'];
		$data['password'] = md5($data['password']);

		$res = model('Admin')->create($data);
		if ($res) {
			$this->success("创建成功", url('admin/admin/create'));
		} else {
			$this->error('创建失败');
		}
	}

	/**
	 * 管理员密码修改
	 */
	public function info() {
		return $this->fetch();
	}

	/**
	 * 修改密码的验证
	 */
	public function doPassword() {
		$data = input('param.');

		if ($data['password'] == $data['password2']) {
			$admin = model('Admin')->field('id')->where('adminname', '=', $data['adminname'])->where('password', '=', md5($data['password1']))->find();
			if ($admin) {
				$res = model('Admin')->where('adminname', '=', $data['adminname'])->update(['password' => md5($data['password'])]);
				if ($res) {
					$this->success("修改成功", url('admin/admin/info'));
				} else {
					$this->error('修改失败');
				}
			} else {
				$this->error("原始密码错误");
			}
		} else {
			$this->error("两次密码不一致");
		}

	}

	/**
	 * 提高管理员的权限
	 *
	 * @param  int  $id 管理员id
	 */
	public function upRole($id) {
		if (is_numeric($id) && $id > 0) {
			$res = model('Admin')->where('id', '=', $id)->setInc('role_id');
			if ($res) {
				$this->success("提高成功", url('admin/admin/index'));
			} else {
				$this->error('提高失败');
			}
		} else {
			$this->error('参数非法');
		}
	}

	/**
	 * 降低管理员的权限
	 *
	 * @param  int  $id 管理员id
	 */
	public function delRole($id) {
		if (is_numeric($id) && $id > 0) {
			$res = model('Admin')->where('id', '=', $id)->setDec('role_id');
			if ($res) {
				$this->success("降低成功", url('admin/admin/index'));
			} else {
				$this->error('降低失败');
			}
		} else {
			$this->error('参数非法');
		}
	}
}
