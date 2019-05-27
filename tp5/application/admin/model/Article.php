<?php

namespace app\admin\model;

use think\Model;

/**
 * 后台文章模形
 */
class Article extends Model {
	protected $autoWriteTimestamp = true;
	protected $updateTime = "updated_at";
	protected $createTime = "created_at";

	/**
	 * 查询文章列表
	 *
	 * @param  array  $where 查询条件,如果没有查询条件,则查询所有数据
	 * @return array
	 */
	public function getList($where = []) {
		$cond = input('param.');

		if (isset($cond['subject']) && !empty($cond['subject'])) {
			$where['subject'] = ['like', '%' . $cond['subject'] . '%'];
		}

		$list = $this
			->field('*')
			->where($where)
			->order('created_at DESC')
			->paginate(5, false, ['query' => $cond]);

		return $list;
	}

	/**
	 * 查看文章的作者信息,当前模型是 Article
	 */
	public function author() {
		return $this->belongsTo('Admin');
	}

	/**
	 * 查看文章的所属分类,当前模型是 Article
	 */
	public function category() {
		return $this->belongsTo('Category');
	}

	/**
	 * 转换是否上线字段
	 *
	 * @param integer $value 原始值
	 * @return string
	 */
	public function getIsOnlineAttr($value) {
		$status = [
			0 => "<span class='layui-btn layui-btn-mini layui-btn-danger'>下线</span>",
			1 => "<span class='layui-btn layui-btn-mini layui-btn-normal'>上线</span>",
		];

		return $status[$value];
	}
}
