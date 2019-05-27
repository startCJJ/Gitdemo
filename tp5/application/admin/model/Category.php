<?php

namespace app\admin\model;

use think\Model;

/**
 * 后台文章分类模板
 */
class Category extends Model {
	protected $autoWriteTimestamp = true;
	protected $updateTime = "updated_at";
	protected $createTime = "created_at";

	/**
	 * 查询后台文章分类列表
	 *
	 * @param  array  $where 默认为空展示所有文章分类,当搜索时展示搜索文章分类
	 * @return array
	 */
	public function getList($where = []) {
		$cond = input('param.');

		if (isset($cond['category_name']) && !empty($cond['category_name'])) {
			$where['category_name'] = ['like', '%' . $cond['category_name'] . '%'];
		}

		$list = $this
			->field('id,category_name,sort_number,created_at')
			->where($where)
			->order('sort_number DESC')
			->paginate(5, false, ['query' => $cond]);

		return $list;
	}

	/**
	 * 返回下拉框中的分类选项
	 *
	 * @return array
	 */
	public function getOptions() {
		return $this
			->field('id,category_name')
			->order('sort_number DESC')
			->select();
	}
}
