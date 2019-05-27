<?php

namespace app\admin\model;

use think\Model;

/**
 * 后台商品分类模型
 */
class Type extends Model {
	protected $autoWriteTimestamp = true;
	protected $updateTime = "updated_at";
	protected $createTime = "created_at";

	/**
	 * 查看分类的树形结构
	 *
	 * @param  integer $pid    父类id
	 * @param  array   $target 结果变量
	 * @return array
	 */
	public function getTree($pid = 0, $target = []) {
		$ts = $this
			->where('pid', 'eq', $pid)
			->select();

		static $n = 1;
		foreach ($ts as $k => $v) {
			$target[$v->id] = $v->toArray();
			$target[$v->id]['level'] = $n;

			$n++;
			$target = $this->getTree($v->id, $target);
			$n--;
		}

		return $target;
	}

	/**
	 * 转换是否上线
	 *
	 * @param  integer $value 原始值
	 *
	 * @return string
	 */
	public function getOnlineAttr($value) {
		$status = [
			0 => "<span class='layui-btn layui-btn-mini layui-btn-danger'>下线</span>",
			1 => "<span class='layui-btn layui-btn-mini layui-btn-normal'>上线</span>",
		];

		return $status[$value];
	}
}
