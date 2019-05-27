<?php

namespace app\admin\model;

use think\Model;

/**
 * 后台订单模板
 */
class Orders extends Model {
	protected $autoWriteTimestamp = true;
	protected $updateTime = "updated_at";
	protected $createTime = "created_at";

	/**
	 * 查询订单列表
	 *
	 * @param  array  $where 查询条件,如果没有查询条件,则查询所有数据
	 * @return array
	 */
	public function getList($where = []) {
		$cond = input('param.');

		if (isset($cond['username']) && !empty($cond['username'])) {

			$user['username'] = ['like', '%' . $cond['username'] . '%'];
			$uid = Model('User')->field('id')->where($user)->find();
			$where['uid'] = ['=', $uid['id']];

		}

		$list = $this
			->field('*')
			->where($where)
			->order('created_at DESC')
			->paginate(5, false, ['query' => $cond]);

		return $list;
	}

	/**
	 * 查看订单的用户名,当前模型是 Orders
	 */
	public function user() {
		return $this->belongsTo('User', 'uid');
	}

	/**
	 * 查看订单的商品,当前模型是 Orders
	 */
	public function product() {
		return $this->belongsTo('Product', 'product_id');
	}

	/**
	 * 查看订单的收货地址,当前模型是 Orders
	 */
	public function user_address() {
		return $this->belongsTo('UserAddress', 'address_id');
	}

	/**
	 * 转换是否付款字段
	 *
	 * @param int $value 原始值
	 * @return string
	 */
	public function getStatusAttr($value) {
		$status = [
			0 => "<span class='layui-btn layui-btn-mini layui-btn-danger'>未付款</span>",
			1 => "<span class='layui-btn layui-btn-mini layui-btn-normal'>已付款</span>",
		];

		return $status[$value];
	}

}
