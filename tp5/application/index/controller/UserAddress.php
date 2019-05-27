<?php

namespace app\index\controller;

use think\Controller;

/**
 * 用户收货地址控制器
 */
class UserAddress extends Controller {
	protected function _initialize() {
		if (!session('?user')) {
			$this->error("请先登录...", url('index/user/login'));
		}
	}
	/**
	 * 显示当前用户收货地址列表和创建收货地址页面
	 */
	public function address() {
		$data = model('UserAddress')->field('*')->where('uid', '=', session('user.id'))->select();
		$this->assign('data', $data);

		return $this->fetch();
	}

	/**
	 * 验证新建的收货地址
	 */
	public function save() {
		$data = input('param.');
		$data['uid'] = session('user.id');

		$res = model('UserAddress')->save($data);
		if ($res) {
			$this->success('添加成功', url('index/userAddress/address'));
		} else {
			$this->error("添加失败");
		}
	}

	/**
	 * 修改选中的收货地址
	 *
	 * @param  int   $id   收货地址id
	 */
	public function edit($id) {
		if (is_numeric($id) && $id > 0) {
			$data = model('UserAddress')->field('*')->where('uid', '=', session('user.id'))->select();
			$arr = model('UserAddress')->field('*')->where('id', '=', $id)->find();
			$this->assign('data', $data);
			$this->assign('arr', $arr);

			return $this->fetch();
		} else {
			$this->error('参数非法');
		}
	}

	/**
	 * 判断修改的收货地址是否成功
	 * @param  int   $id   收货地址id
	 */
	public function doEdit($id) {
		$data = input('param.');
		$res = model('UserAddress')->where('id', '=', $id)->update($data);
		if ($res) {
			$this->success('修改成功', url('index/userAddress/address'));
		} else {
			$this->error("修改失败");
		}
	}

	/**
	 * 删除选中的收货地址
	 *
	 * @param  int   $id  收货地址id
	 */
	public function delete($id) {
		if (is_numeric($id) && $id > 0) {
			$res = model('UserAddress')->where('id', '=', $id)->delete();

			if ($res) {
				$this->success('删除成功', url('index/userAddress/address'));
			} else {
				$this->error("删除失败");
			}
		} else {
			$this->error('参数非法');
		}
	}

	/**
	 * 将选中的收货地址设为默认
	 *
	 * @param  int   $id  收货地址id
	 */
	public function modify($id) {
		if (is_numeric($id) && $id > 0) {
			$data['status'] = 0;
			$res = model('UserAddress')->where('id', '>', 0)->update($data);
			if ($res) {
				$data['status'] = 1;
				$res = model('UserAddress')->where('id', '=', $id)->update($data);
				if ($res) {
					$this->success('设置默认成功', url('index/userAddress/address'));
				} else {
					$this->error("设置默认失败");
				}
			} else {
				$this->error("设置默认失败");
			}
		} else {
			$this->error('参数非法');
		}
	}
}
