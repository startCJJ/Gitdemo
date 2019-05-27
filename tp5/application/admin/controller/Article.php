<?php

namespace app\admin\controller;

use app\common\controller\AdminBase;
use think\Request;

/**
 * 后台文章控制器
 */
class Article extends AdminBase {
	/**
	 * 显示文章列表
	 */
	public function index() {
		$list = model('Article')->getList();
		$this->assign('list', $list);

		return $this->fetch();
	}

	/**
	 * 添加创建文章
	 */
	public function create() {
		$cs = model('Category')->getOptions();
		$this->assign('cs', $cs);

		return $this->fetch();
	}

	/**
	 * 保存文章
	 */
	public function save(Request $request) {
		$data = input('param.');

		// 图片上传
		$file = request()->file('subject_picture');
		if ($file) {
			$path = ROOT_PATH . "public/static/upload";
			$info = $file
				->validate([
					'ext' => "jpg,jpeg,png,gif",
					'size' => 8000000,
				])
				->move($path);
			if (is_object($info) && $info->getSaveName()) {
				$data['subject_picture'] = $info->getSaveName();
			} else {
				$this->error($file->getError());
			}
		} else {
			$data['subject_picture'] = "";
		}

		$data['admin_id'] = session('admin.id');

		$res = model('Article')->save($data);
		if ($res) {
			$this->success("添加成功", url('admin/article/create'));
		} else {
			$this->error("添加失败");
		}
	}

	/**
	 * 编辑文章
	 *
	 * @param  int  $id 文章的id
	 */
	public function edit($id) {
		$id = input('param.id');
		if (is_numeric($id) && $id > 0) {
			$data = model('Article')->find($id);

			$cs = model('Category')->getOptions();

			$this->assign('cs', $cs);
			$this->assign('data', $data);

			return $this->fetch();
		} else {
			$this->error('参数非法');
		}

	}

	/**
	 * 保存编辑的文章
	 */
	public function update() {
		$data = input('param.');

		// 图片上传
		$file = request()->file('subject_picture');
		if ($file) {
			$path = ROOT_PATH . "public/static/upload";
			$info = $file
				->validate([
					'ext' => "jpg,jpeg,png,gif",
					'size' => 2048000,
				])
				->move($path);
			if (is_object($info) && $info->getSaveName()) {
				$data['subject_picture'] = $info->getSaveName();
			} else {
				$this->error($file->getError());
			}
		} else {
			$data['subject_picture'] = "";
		}

		$res = model('Article')
			->isUpdate(true)
			->save($data);
		if ($res) {
			$this->success('保存成功', url('admin/article/index'));
		} else {
			$this->error('保存失败');
		}
	}

	/**
	 * 更改是否上线
	 */
	public function isOnline() {
		$data = input('param.');
		if ($data['is_online'] == 1) {
			$data['is_online'] = 0;
		} else {
			$data['is_online'] = 1;
		}

		$res = model('Article')
			->where('id', '=', $data['id'])
			->update($data);
		if ($res) {
			$this->success('修改成功', url('admin/article/index'));
		} else {
			$this->error('修改失败');
		}
	}

	/**
	 * 删除指定资源
	 *
	 * @param  int  $id 文章的id
	 */
	public function delete($id) {
		if (is_numeric($id) && $id > 0) {
			$res = model('Article')
				->where('id', '=', $id)
				->delete();
			if ($res) {
				$this->success('删除成功', url('admin/article/index'));
			} else {
				$this->error('删除失败');
			}
		} else {
			$this->error('参数非法');
		}
	}
}
