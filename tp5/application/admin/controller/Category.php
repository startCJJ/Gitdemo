<?php

namespace app\admin\controller;

use app\common\controller\AdminBase;

/**
 * 后台文章分类控制器
 */
class Category extends AdminBase {
	/**
	 * 显示文章分类列表
	 */
	public function index() {
		$list = model('Category')->getList();
		$this->assign('list', $list);

		return $this->fetch();
	}

	/**
	 * 创建文章分类
	 */
	public function create() {
		return $this->fetch();
	}

	/**
	 * 创建文章分类验证
	 */
	public function save() {
		$data = input('param.');

		$res = model('Category')->save($data);
		if ($res) {
			$this->success('添加成功', url('admin/category/create'));
		} else {
			$this->error('保存失败');
		}
	}

	/**
	 * 编辑文章分类
	 *
	 * @param  int  $id 文章分类的id
	 */
	public function edit($id) {
		if (is_numeric($id) && $id > 0) {
			$data = model('Category')->find($id);
			$this->assign('data', $data);

			return $this->fetch();
		} else {
			$this->error('参数非法');
		}

	}

	/**
	 * 编辑文章分类的验证
	 *
	 * @param  int  $id 文章分类的id
	 */
	public function update($id) {
		if (is_numeric($id) && $id > 0) {
			$data = input('param.');

			$res = model('Category')
				->isUpdate(true)
				->save($data);
			if ($res) {
				$this->success('保存成功', url('admin/category/index'));
			} else {
				$this->error('保存失败');
			}
		} else {
			$this->error('参数非法');
		}

	}

	/**
	 * 删除文章分类
	 *
	 * @param  int  $id 文章分类的id
	 */
	public function delete($id) {
		if (is_numeric($id) && $id > 0) {
			$res = model('Category')
				->where('id', '=', $id)
				->delete();
			if ($res) {
				$this->success('删除成功', url('admin/category/index'));
			} else {
				$this->error('删除失败');
			}
		} else {
			$this->error('参数非法');
		}

	}
}
