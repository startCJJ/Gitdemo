<?php

namespace app\index\model;

use think\Model;

/**
 * 前台文章模形
 */
class Article extends Model {
	protected $autoWriteTimestamp = true;
	protected $updateTime = "updated_at";
	protected $createTime = "created_at";

	/**
	 * 获取最新的文章
	 *
	 * @param  int $num 返回结果数量
	 *
	 * @return array
	 */
	public function getArticles($num = 4) {
		return $this
			->field('id,subject,content,subject_picture,created_at')
			->where('is_online', '=', 1)
			->order('created_at', 'DESC')
			->limit($num)
			->select();
	}

	/**
	 * 查询文章列表
	 *
	 * @param   array $where 查询条件,如果没有查询条件,则查询所有数据
	 * @return  array
	 */
	public function getList($where = []) {
		$cond = input('param.');

		if (isset($cond['subject']) && !empty($cond['subject'])) {
			$where['subject'] = ['like', '%' . $cond['subject'] . '%'];
		}

		if (isset($cond['category_id']) && is_numeric($cond['category_id'])) {
			$where['category_id'] = ['eq', $cond['category_id']];
		}

		$where['is_online'] = ['eq', 1];

		$list = $this
			->field('*')
			->where($where)
			->order('created_at DESC')
			->paginate(10, false, ['query' => $cond]);

		return $list;
	}

	/**
	 * 查询文章详情
	 *
	 * @param  int  $id 文章的id
	 * @return array
	 */
	public function getArticle($id) {
		return $this
			->field('*')
			->where('id', 'eq', $id)
			->find();
	}

	/**
	 * 文章的所属分类,当前模型是 Article
	 */
	public function category() {
		return $this->belongsTo('Category');
	}
}
