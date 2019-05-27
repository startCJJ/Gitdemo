<?php

namespace app\admin\controller;

use app\common\controller\AdminBase;
use think\Request;

/**
 * 后台商品分类控制器
 */
class Type extends AdminBase {

	/**
	 * 初始化函数
	 */
	public function _initialize() {
		// 手动调用父类中的初始化方法
		parent::_initialize();
		$ts = model('Type')->getTree();
		$this->assign('ts', $ts);
	}

	/**
	 * 显示商品分类列表
	 */
	public function index() {
		return $this->fetch();
	}

	/**
	 * 添加商品分类
	 */
	public function create() {
		return $this->fetch();
	}

	/**
	 * 添加商品分类验证
	 */
	public function save(Request $request) {
		$data = $request->param();

		$res = model('Type')->save($data);
		if ($res) {
			$this->success("添加成功", url('admin/type/create'));
		} else {
			$this->error("添加失败");
		}
	}

	/**
	 * 修改商品分类
	 *
	 * @param  int $id 商品分类id
	 */
	public function edit($id) {
		if (is_numeric($id) && $id > 0) {
			$data = model('Type')->find($id);
			$this->assign('data', $data);
			return $this->fetch();
		} else {
			$this->error('参数非法');
		}
	}

	/**
	 * 修改商品分类验证
	 *
	 * @param  \think\Request  $request
	 * @param  int  $id 商品分类id
	 */
	public function update(Request $request, $id) {
		if (is_numeric($id) && $id > 0) {
			$data = $request->param();

			$res = model('Type')
				->isUpdate(true)
				->save($data);
			if ($res) {
				$this->success('保存成功', url('admin/type/index'));
			} else {
				$this->error('保存失败');
			}
		} else {
			$this->error('参数非法');
		}
	}

	/**
	 * 删除商品分类
	 *
	 * @param  int  $id 商品分类id
	 */
	public function delete($id) {
		if (is_numeric($id) && $id > 0) {
			$res = model('Type')
				->where('id', 'eq', $id)
				->delete();
			if ($res) {
				$this->success('删除成功', url('admin/type/index'));
			} else {
				$this->error('删除失败');
			}
		} else {
			$this->error('参数非法');
		}
	}
}
