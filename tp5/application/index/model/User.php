<?php

namespace app\index\model;

use think\Model;

class User extends Model {
	// 时间自动完成
	protected $autoWriteTimestamp = true;
	protected $updateTime = "updated_at";
	protected $createTime = "created_at";

	public function setPasswordAttr($value) {
		return md5($value);
	}
}
