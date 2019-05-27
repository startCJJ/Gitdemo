<?php

namespace app\admin\model;

use think\Model;

/**
 * 后台商品模型
 */
class Product extends Model {
	protected $autoWriteTimestamp = true;
	protected $updateTime = "updated_at";
	protected $createTime = "created_at";

	// 普通字段的自动完成
	protected $insert = [
		'aid',
		'view' => 1,
	];

	// 通过修改器设置aid的值
	public function setAidAttr() {
		return session('admin.id');
	}

	/**
	 * 查询商品列表
	 *
	 * @param array $where 查询条件,如果没有查询条件,则查询所有数据
	 * @return array
	 */
	public function getList($where = []) {
		$cond = input('param.');

		if (isset($cond['title']) && !empty($cond['title'])) {
			$where['title'] = ['like', '%' . $cond['title'] . '%'];
		}

		if (isset($cond['recommend']) && is_numeric($cond['recommend'])) {
			$where['recommend'] = ['eq', $cond['recommend']];
		}

		if (isset($cond['minPrice']) && isset($cond['maxPrice']) && $cond['minPrice'] < $cond['maxPrice']) {
			$where['price'] = [
				'between',
				[
					$cond['minPrice'],
					$cond['maxPrice'],
				],
			];
		} else if (isset($cond['minPrice']) && is_numeric($cond['minPrice'])) {
			$where['price'] = ['gt', $cond['minPrice']];
		} else if (isset($cond['maxPrice']) && is_numeric($cond['maxPrice'])) {
			$where['price'] = ['lt', $cond['maxPrice']];
		}

		$list = $this
			->field('*')
			->where($where)
			->orderRaw('online=1 desc,created_at desc')
			->paginate(5, false, ['query' => $cond]);

		return $list;
	}

	/**
	 * 查看商品作者,当前模型是 Product
	 */
	public function author() {
		return $this->belongsTo('Admin', 'aid');
	}

	/**
	 * 查看商品的所属分类,当前模型是 Product
	 */
	public function type() {
		return $this->belongsTo('Type', 'tid');
	}

	/**
	 * 转换是否上线字段
	 *
	 * @param int $value 原始值
	 * @return string
	 */
	public function getOnlineAttr($value) {
		$status = [
			0 => "<span class='layui-btn layui-btn-mini layui-btn-danger'>下线</span>",
			1 => "<span class='layui-btn layui-btn-mini layui-btn-normal'>上线</span>",
		];
		return $status[$value];
	}

	/**
	 * 转换是否推荐字段
	 *
	 * @param int $value 原始值
	 * @return string
	 */
	public function getRecommendAttr($value) {
		$status = [
			0 => "<span class='layui-btn layui-btn-mini layui-btn-danger'>不推荐</span>",
			1 => "<span class='layui-btn layui-btn-mini layui-btn-normal'>推荐</span>",
		];
		return $status[$value];
	}
}
