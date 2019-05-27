<?php

namespace app\index\model;

use think\Model;

/**
 * 前台商品分类模型
 */
class Type extends Model {
	protected $autoWriteTimestamp = true;
	protected $updateTime = "updated_at";
	protected $createTime = "created_at";

	/**
	 * 获取商品分类名称
	 * @param  integer $num [description]
	 * @return [type]       [description]
	 */
	public function getType($num = 5) {
		return $this
			->field('id,title')
			->where('online', '=', 1)
			->order('created_at', 'DESC')
			->limit($num)
			->select();
	}
}
