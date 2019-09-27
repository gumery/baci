<?php
namespace app\backend\controller;

use app\model\Round as Round;
use app\model\Plan as Plan;
use think\Validate as Validate;

class Count extends Base
{
	public function index($id='')
	{
		$round = new Round();
		$rounds = $round->order('id desc')->select();

		$this->assign('rounds', $rounds);
		return view();
	}

	public function getTypesValue($types)
	{
		$typeValue = [
			'1' => '餐桌',
			'2' => '自助'
		];
		
		$str = [];
		foreach ($types as $type) {
			$str[] = $typeValue[$type];
		}

		return implode(' / ', $str);
	}

	public function getValidate()
	{
		$rule = [
			'stime' => 'require|date',
			'etime' => 'require|date',
			'types' => 'require',
		];
		$msg = [
			'stime' => '请选择开始时间',
			'etime' => '请选择结束时间',
			'types' => '请选择类型',
		];
		$validate = new Validate($rule, $msg);
		return $validate;
	}

	public function add()
	{
		if (!request()->isPost()) return view();

		$round = new Round();
		$count = $round->where('status', 1)->count();
		if ($count) return json(['code'=>0, 'msg'=>'请结束正在启用中的计划']);

		$form = input('post.');
		$stime = isset($form['stime']) ? $form['stime'] : '';
		$etime = isset($form['etime']) ? $form['etime']: '';
		$dtime = isset($form['dtime']) ? $form['dtime']: '';
		$types = isset($form['type']) ? $form['type'] : [];
		$status  = isset($form['status']) ? $form['status'] : 0;
		$price  = isset($form['price']) ? $form['price'] : 10;

		if ($stime > $etime) return json(['code'=>0, 'msg'=>'开始时间不能大于截止时间']);

		$data = [
			'stime' => $stime,
			'etime' => $etime,
			'dtime' => $dtime,
			'types' => $this->getTypesValue($types),
			'status'  => $status,
			'unit_price' => $price
		];

		$validate = $this->getValidate();
		if(!$validate->check($data)){
			return json(['code'=>0, 'msg'=>$validate->getError()]);
		}

		$retval = $round->save($data);
		if (!$retval) {
			return json(['code'=>0, 'msg'=>'操作失败']);
		}

		return json(['code'=>200, 'msg'=>'操作成功']);
	}

	public function update()
	{
		if (!request()->isPost()) return json(['code'=>0, 'msg'=>'请求类型错误']);
		
		$form = input('post.');
		$id   = $form['id'];
		$stime = $form['start_time'] ?: '';
		$etime = $form['end_time'] ?: '';
		$types = $form['type'] ?: [];
		$open  = $form['open'] ?: 0;

		$round = new Round();
		$info = $round->get($id);
		if ($info['open'] == 1) return json(['code'=>0, 'msg'=>'不能修改正在启用中的计划']);
		if ($stime > $etime) return json(['code'=>0, 'msg'=>'开始时间不能大于截止时间']);

		$validate = $this->getValidate();
		if(!$validate->check($data)){
			return json(['code'=>0, 'msg'=>$validate->getError()]);
		}

		$data = [
			'stime' => $stime,
			'etime' => $etime,
			'types' => $this->getTypesValue($types),
			'open' => $open
		];

		$retval = $round->where('id', $id)->update($data);
		if (!$retval) {
			return json(['code'=>0, 'msg'=>'修改失败']);
		}

		return json(['code'=>200, 'msg'=>'修改成功']);
	}

	public function close()
	{
		$id = input('post.id', 0);
		if (!$id) return json(['code'=>0, 'msg'=>'参数异常']);

		$round = new round();
		$retval = $round->where('id', $id)->update('open', 0);
		if (!$retval) return json(['code'=>0, 'msg'=>'关闭失败']);

		return json(['code'=>200, 'msg'=>'已关闭']);	
	}

	public function delete()
	{
		$id = input('post.id', 0);
		if (!$id) return json(['code'=>0, 'msg'=>'参数异常']);

		$round = new round();
		$retval = $round->where('id', $id)->update('open', 2);
		if (!$retval) return json(['code'=>0, 'msg'=>'删除失败']);

		return json(['code'=>200, 'msg'=>'删除成功']);	
	}
}
