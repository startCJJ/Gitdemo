<?php

namespace app\index\model;

use think\Model;

/**
 * 前台商品模型
 */
class Product extends Model {
	protected $autoWriteTimestamp = true;
	protected $updateTime = "updated_at";
	protected $createTime = "created_at";

	/**
	 * 获取最新商品
	 *
	 * @param  int $num 返回结果数量
	 * @return array
	 */
	public function getProducts($num = 15) {
		return $this
			->field('id,image,title')
			->where('online', '=', 1)
			->order('created_at', 'DESC')
			->limit($num)
			->select();
	}

	/**
	 * 查询商品列表
	 *
	 * @param array $where 查询条件,如果没有查询条件,则查询所有数据
	 */
	public function getList($where = []) {
		$cond = input('param.');

		if (isset($cond['title']) && !empty($cond['title'])) {
			$where['title'] = ['like', '%' . $cond['title'] . '%'];
		}

		if (isset($cond['tid']) && is_numeric($cond['tid'])) {
			$where['tid'] = ['eq', $cond['tid']];
		}

		$where['online'] = ['eq', 1];

		$list = $this
			->field('*')
			->where($where)
			->order('created_at DESC')
			->paginate(15, false, ['query' => $cond]);

		return $list;
	}

	/**
	 * 查看商品的所属分类,当前模型 Product
	 */
	public function type() {
		return $this->belongsTo('Type', 'tid');
	}
}
