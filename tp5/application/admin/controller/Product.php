<?php

namespace app\admin\controller;

use app\common\controller\AdminBase;
use think\Request;

/**
 * 后台商品控制器
 */
class Product extends AdminBase {
	/**
	 * 商品列表
	 */
	public function index() {
		$list = model('Product')->getList();
		$this->assign('list', $list);

		return $this->fetch();
	}

	/**
	 * 添加商品
	 */
	public function create() {
		$ts = model('Type')->getTree();
		$this->assign('ts', $ts);
		return $this->fetch();
	}

	/**
	 * 添加商品验证
	 */
	public function save(Request $request) {
		$data = input('param.');

		// 图片上传
		$file = request()->file('image');
		if ($file) {
			$path = ROOT_PATH . "public/static/upload";
			$info = $file
				->validate([
					'ext' => "jpg,jpeg,png,gif",
					'size' => 2048000,
				])
				->move($path);
			if (is_object($info) && $info->getSaveName()) {
				$data['image'] = $info->getSaveName();
			} else {
				$this->error($file->getError());
			}
		} else {
			$data['image'] = "";
		}

		$res = model('Product')->save($data);
		if ($res) {
			$this->success("添加成功", url('admin/product/create'));
		} else {
			$this->error("添加失败");
		}
	}

	/**
	 * 修改商品
	 *
	 * @param  int $id 商品id
	 */
	public function edit($id) {
		if (is_numeric($id) && $id > 0) {
			$data = model('Product')->find($id);
			$ts = model('Type')->getTree();
			$this->assign('ts', $ts);
			$this->assign('data', $data);

			return $this->fetch();
		} else {
			$this->error('参数非法');
		}

	}

	/**
	 * 修改商品验证
	 */
	public function update(Request $request, $id) {
		if (is_numeric($id) && $id > 0) {
			$data = $request->param();

			// 图片上传
			$file = request()->file('image');
			if ($file) {
				$path = ROOT_PATH . "public/static/upload";
				$info = $file
					->validate([
						'ext' => "jpg,jpeg,png,gif",
						'size' => 2048000,
					])
					->move($path);
				if (is_object($info) && $info->getSaveName()) {
					$data['image'] = $info->getSaveName();
				} else {
					$this->error($file->getError());
				}
			}

			$res = model('Product')
				->isUpdate(true)
				->save($data);
			if ($res) {
				$this->success('保存成功', url('admin/product/index'));
			} else {
				$this->error('保存失败');
			}
		} else {
			$this->error('参数非法');
		}

	}

	/**
	 * 商品是否线下
	 */
	public function isOnline() {
		$data = input('param.');
		if ($data['online'] == 1) {
			$data['online'] = 0;
		} else {
			$data['online'] = 1;
		}

		$res = model('Product')
			->where('id', '=', $data['id'])
			->update($data);
		if ($res) {
			$this->success('修改成功', url('admin/product/index'));
		} else {
			$this->error('修改失败');
		}
	}
}
