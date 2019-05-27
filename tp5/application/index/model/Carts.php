<?php

namespace app\index\model;

use think\Model;

/**
 * 购物车的模形
 */
class Carts extends Model {
	// 时间自动完成
	protected $autoWriteTimestamp = true;
	protected $updateTime = "updated_at";
	protected $createTime = "created_at";

	/**
	 * 购物车中的商品的所属分类,当前模型是 Carts
	 */
	public function product() {
		return $this->belongsTo('Product', 'product_id');
	}
}
