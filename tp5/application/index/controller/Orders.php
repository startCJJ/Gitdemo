<?php

namespace app\index\controller;

use think\Controller;
use think\Db;

/**
 * 前台订单控制器
 */
class Orders extends Controller {
	protected function _initialize() {
		if (!session('?user')) {
			$this->error("请先登录...", url('index/user/login'));
		}
	}

	/**
	 * 显示当前用户的所有订单
	 */
	public function index() {
		$list = model('Orders')->where('uid', '=', session('user.id'))
			->order('created_at', 'desc')
			->paginate(5);
		$this->assign('list', $list);

		return $this->fetch();
	}

	/**
	 * 显示添加购物车页面
	 *
	 * @return \think\Response
	 */
	public function confirm() {
		$pids = explode('_', input('param.pids'));
		$nums = explode('_', input('param.nums'));

		$products = [];
		foreach ($pids as $k => $pid) {
			$products[$pid] = model('Product')->find($pid);
			$products[$pid]->num = $nums[$k];
		}

		$data = model('UserAddress')->where('uid', '=', session('user.id'))->order('status', 'desc')->select();
		$arr = model('Carts')->where('uid', '=', session('user.id'))->whereIn('product_id', $pids)->select();
		$this->assign('data', $data);
		$this->assign('products', $products);

		return $this->fetch();
	}

	/**
	 * 添加购物车验证
	 */
	public function create() {
		$data = input('param.');
		$pids = explode('_', $data['pids']);
		$nums = explode('_', $data['nums']);

		// 开启事务
		Db::startTrans();

		foreach ($pids as $k => $pid) {
			$product = model('Product')->find($pid);
			$order = [
				'order_sn' => 'D' . date('YmdHis') . mt_rand(10000, 99999),
				'uid' => session('user.id'),
				'product_id' => $pid,
				'product_price' => $product->price,
				'product_number' => $nums[$k],
				'order_amount' => round($product->price * $nums[$k], 2),
				'pay_amount' => 0,
				'pay_id' => 0,
				'pay_time' => 0,
				'address_id' => $data['address_id'],
			];
			$res1 = model('Orders')->create($order);

			if ($res1) {
				if ($product['stock'] >= $nums[$k]) {
					// 减库存
					$res2 = model('Product')
						->where('id', '=', $pid)
						->setDec('stock', $nums[$k]);
					if (!$res2) {
						// 添加订单失败(事务回滚)
						Db::rollback();
						$this->error("库存不足");
					} else {
						// 判断提交订单的方式,如果直接购买不需要删除购物车,如果购物车购买就要删除购物车,这里选择的是超链接后面接一个值来确定提交方式
						if ($data['mode']) {
							//删除购物车
							$res3 = model('Carts')->where('product_id', '=', $pid)->where('uid', '=', session('user.id'))->delete();
							if (!$res3) {
								Db::rollback();
								$this->error("添加订单失败");
							}
						}
					}
				} else {
					Db::rollback();
					$this->error("库存不足");
				}
			} else {
				Db::rollback();
				$this->error("添加订单失败");
			}
		}
		// 事务提交
		Db::commit();
		$this->success('添加成功', url('index/orders/index'));
	}
}
