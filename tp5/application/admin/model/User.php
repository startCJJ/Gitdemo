<?php

namespace app\admin\model;

use think\Model;

/**
 * 后台用户模型
 */
class User extends Model {
	protected $autoWriteTimestamp = true;
	protected $updateTime = "updated_at";
	protected $createTime = "created_at";

	/**
	 * 查询用户列表
	 *
	 * @param array $where 查询条件,如果没有查询条件,则查询所有数据
	 * @return array
	 */
	public function getList($where = []) {
		$cond = input('param.');

		if (isset($cond['username']) && !empty($cond['username'])) {
			$where['username'] = ['like', '%' . $cond['username'] . '%'];

		}

		$list = $this
			->field('*')
			->where($where)
			->order('created_at DESC')
			->paginate(5, false, ['query' => $cond]);

		return $list;
	}
}
