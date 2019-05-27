<?php

namespace app\admin\controller;

use app\common\controller\AdminBase;

/**
 * 后台后台用户控制器
 */
class User extends AdminBase {
	/**
	 * 显示用户列表
	 */
	public function index() {
		$list = model('User')->getList();
		$this->assign('list', $list);

		return $this->fetch();
	}

	/**
	 * 删除用户
	 *
	 * @param int $id 用户id
	 */
	public function delete($id) {
		if (is_numeric($id) && $id > 0) {
			$res = model('User')
				->where('id', '=', $id)
				->delete();
			if ($res) {
				$this->success('删除成功', url('admin/user/index'));
			} else {
				$this->error('删除失败');
			}
		} else {
			$this->error('参数非法');
		}
	}
}
