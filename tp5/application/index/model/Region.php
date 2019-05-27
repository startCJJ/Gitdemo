<?php

namespace app\index\model;

use think\Model;

/**
 * 前台地址模型
 */
class Region extends Model {
	protected $autoWriteTimestamp = true;
	protected $updateTime = "updated_at";
	protected $createTime = "created_at";

	/**
	 * 查询子类地址
	 * @param  int    $parentid   父类的id
	 * @return array
	 */
	public function getRegion($parentid) {
		return $this->field('id,name,firstletter')->where('parentid', '=', $parentid)->order('firstletter', 'ASC')->select();
	}
}
