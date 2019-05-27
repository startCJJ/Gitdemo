<?php

namespace app\admin\controller;

use app\common\controller\AdminBase;

/**
 * 后台订单控制器
 */
class Orders extends AdminBase {
	/**
	 * 显示订单列表
	 */
	public function index() {
		$list = model('Orders')->getList();
		$this->assign('list', $list);

		return $this->fetch();
	}

	/**
	 * 删除订单订单
	 *
	 * @param int @id 订单的id
	 */
	public function delete($id) {
		if (is_numeric($id) && $id > 0) {
			$res = model('Orders')
				->where('id', '=', $id)
				->delete();
			if ($res) {
				$this->success('删除成功', url('admin/orders/index'));
			} else {
				$this->error('删除失败');
			}
		} else {
			$this->error('参数非法');
		}

	}
}
