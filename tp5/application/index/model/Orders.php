<?php

namespace app\index\model;

use think\Model;

/**
 * 前台订单模型
 */
class Orders extends Model {
	protected $autoWriteTimestamp = true;
	protected $updateTime = "updated_at";
	protected $createTime = "created_at";

	/**
	 * 订单中的商品,当前模型是 Carts
	 */
	public function product() {
		return $this->belongsTo('Product', 'product_id');
	}

	/**
	 * 订单中的收货地址,当前模型是 Carts
	 */
	public function userAddress() {
		return $this->belongsTo('UserAddress', 'address_id');
	}

	/**
	 * 转换是否付款字段
	 *
	 * @param integer $value 原始值
	 * @return string
	 */
	public function getStatusAttr($value) {
		$status = [
			0 => '<span class="text-danger">未付款</span>',
			1 => '<span class="text-success">已付款</span>',
		];

		return $status[$value];
	}
}
