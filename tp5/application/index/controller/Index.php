<?php

namespace app\index\controller;

use think\Controller;

/**
 * 前台首页控制器
 */
class Index extends Controller {
	/**
	 * 显示公司首页
	 *
	 * @return \think\Response
	 */
	public function index() {
		$products = model('Product')->getProducts();
		$articles = model('Article')->getArticles();
		$this->assign('products', $products);
		$this->assign('articles', $articles);

		return $this->fetch();
	}

	/**
	 * 显示公司的信息
	 */
	public function about() {
		return $this->fetch();
	}

	/**
	 * 显示公司的服务信息
	 */
	public function service() {
		return $this->fetch();
	}
}
