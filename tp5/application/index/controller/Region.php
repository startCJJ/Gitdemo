<?php

namespace app\index\controller;

use think\Controller;

/**
 * 前台地址控制器
 */
class Region extends Controller {
	protected function _initialize() {
		if (!session('?user')) {
			$this->error("请先登录...", url('index/user/login'));
		}
	}

	/**
	 * 展示地址接口
	 *
	 * @return string
	 */
	public function region() {
		$parentid = $_GET['parentid'];
		$res = model('Region')->getRegion($parentid);

		echo json_encode($res);
	}

}
