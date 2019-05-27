<?php

namespace app\admin\controller;

use app\common\controller\AdminBase;
use think\Db;

/**
 * 后台首页控制器
 */
class Index extends AdminBase {

	/**
	 * 后台首页
	 */
	public function index() {
		return $this->fetch();
	}

	/**
	 * 后台欢迎页
	 */
	public function welcome() {
		$db_version = Db::query('select version()');
		$db_version = $db_version ? $db_version[0]['version()'] : @mysql_get_server_info();

		$date = strtotime(date('Y-m-d'));

		$users = model('User')->count('id');
		$articles = model('Article')->count('id');
		$products = model('Product')->where('online', '=', '1')->count('id');

		$this->assign('db_version', $db_version);
		$this->assign('date', $date);
		$this->assign('users', $users);
		$this->assign('articles', $articles);
		$this->assign('products', $products);

		return $this->fetch();
	}
}
