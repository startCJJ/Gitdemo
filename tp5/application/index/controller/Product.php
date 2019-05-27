<?php

namespace app\index\controller;

use think\Controller;

/**
 * 前台商品控制器
 */
class Product extends Controller {
	/**
	 * 显示商品列表
	 */
	public function index() {
		$list = model('Product')->getList();
		$type = model('Type')->getType();
		$this->assign('list', $list);
		$this->assign('type', $type);

		return $this->fetch();
	}

	/**
	 * 显示商品详情
	 *
	 * @param  int  $id  商品id
	 */
	public function read($id) {
		if (is_numeric($id) && $id > 0) {
			$data = model('Product')->find($id);

			// 更新商品的浏览量
			db('Product')->where('id', 'eq', $id)
				->setInc('view');

			$this->assign('data', $data);

			return $this->fetch();
		} else {
			$this->error('参数非法');
		}
	}
}
