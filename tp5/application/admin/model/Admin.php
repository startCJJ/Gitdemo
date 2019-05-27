<?php

namespace app\admin\model;

use think\Model;

/**
 * 后台管理员模板
 */
class Admin extends Model {
	protected $autoWriteTimestamp = true;
	protected $createTime = "created_at";
	protected $updateTime = "updated_at";

	/**
	 * 登录时查询当前管理员信息
	 *
	 * @param  array $data 管理员的账号和密码
	 * @return array
	 */
	public function getAdmin($data) {
		$admin = $this->field('*')->where('adminname', '=', $data['adminname'])->where('password', '=', md5($data['password']))->find();
		return $admin;
	}

	/**
	 * 查询管理员列表
	 *
	 * @param  array  $where 查询条件,如果没有查询条件,则查询所有数据
	 * @return array
	 */
	public function getList($where = []) {
		$cond = input('param.');

		if (isset($cond['adminname']) && !empty($cond['adminname'])) {

			$where['adminname'] = ['like', '%' . $cond['adminname'] . '%'];
		}

		$list = $this
			->field('*')
			->where($where)
			->order('created_at DESC')
			->paginate(5, false, ['query' => $cond]);
		return $list;
	}

	/**
	 * 查看管理员的权限,当前模型是 Admin
	 */
	public function role() {
		return $this->belongsTo('AdminRole', 'role_id');
	}
}
