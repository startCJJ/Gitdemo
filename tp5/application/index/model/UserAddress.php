<?php

namespace app\index\model;

use think\Model;

class UserAddress extends Model {
	// 时间自动完成
	protected $autoWriteTimestamp = true;
	protected $updateTime = "updated_at";
	protected $createTime = "created_at";

	public function province() {
		return $this->belongsTo('Region', 'province_id');
	}

	public function city() {
		return $this->belongsTo('Region', 'city_id');
	}

	public function district() {
		return $this->belongsTo('Region', 'district_id');
	}

	public function getStatusAttr($value) {
		$status = [
			0 => '<span class="text-danger">非默认地址</span>',
			1 => '<span class="text-success">默认地址</span>',
		];

		return $status[$value];
	}

}
