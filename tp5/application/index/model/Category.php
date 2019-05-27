<?php

namespace app\index\model;

use think\Model;

/**
 * 文章分类模板
 */
class Category extends Model {
	protected $autoWriteTimestamp = true;
	protected $updateTime = "updated_at";
	protected $createTime = "created_at";

	/**
	 * 获取文章分类
	 *
	 * @param  int   $num   显示分类的数量
	 * @return array
	 */
	public function getCategory($num = 5) {
		return $this
			->field('id,category_name')
			->order('created_at', 'DESC')
			->limit($num)
			->select();
	}
}
