<?php

namespace app\index\controller;

use think\Controller;

/**
 * 前台购物车控制器
 */
class Carts extends Controller {
	protected function _initialize() {
		if (!session('?user')) {
			$this->error("请先登录...", url('index/user/login'));
		}
	}

	/**
	 * 显示购物车
	 */
	public function index() {
		$data = model('Carts')->where('uid', '=', session('user.id'))->select();
		$this->assign('data', $data);

		return $this->fetch();
	}

	/**
	 * 创建购物车接口
	 *
	 * @return string
	 */
	public function create() {
		$data = input('param.');

		$data['uid'] = session('user.id');

		$check = model('Carts')->where('uid', '=', $data['uid'])->where('product_id', '=', $data['product_id'])->count();
		if ($check) {
			$res = model('Carts')->where('uid', '=', $data['uid'])->where('product_id', '=', $data['product_id'])->setInc('number', $data['number']);
		} else {
			$res = model('Carts')->create($data);
		}
		echo $res ? '添加成功' : '添加失败';
	}

	/**
	 * 删除购物车
	 *
	 * @param  int $id 购物车id
	 */
	public function delete($id) {
		if (is_numeric($id) && $id > 0) {
			$res = model('Carts')->where('id', '=', $id)->where('uid', '=', session('user.id'))->delete();
			if ($res) {
				$this->success('删除成功', url('index/carts/index'));
			} else {
				$this->error("删除失败");
			}
		} else {
			$this->error('参数非法');
		}
	}
}
