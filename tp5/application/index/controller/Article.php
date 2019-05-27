<?php

namespace app\index\controller;

use think\Controller;

/**
 * 前台文章控制器
 */
class Article extends Controller {
	/**
	 * 显示文章列表
	 */
	public function index() {
		$list = model('Article')->getList();
		$category = model('Category')->getCategory();
		$this->assign('list', $list);
		$this->assign('category', $category);

		return $this->fetch();
	}

	/**
	 * 显示文章的详情
	 *
	 * @param  int  $id 文章id
	 */
	public function read($id) {
		$data = model('Article')->getArticle($id);

		db('Article')->where('id', 'eq', $id)
			->setInc('browse_times');

		$this->assign('data', $data);

		return $this->fetch();
	}
}
