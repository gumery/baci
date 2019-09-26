<?php
namespace app\index\controller;

use app\index\model\Round as Round;
use app\index\model\Plan as Plan;
use think\Validate as Validate;

class Index extends Base
{
    public function index()
	{
		$model = new Round();
		$round = $model->where('status', 1)->order('id desc')->find();

		$range = $this->getDate($round['stime'], $round['etime']);
		$types = json_decode($round['types'], true);

		$this->assign('round', $round);
		$this->assign('range', $range);
		$this->assign('types', $types);
		$this->assign('weeks', $this->getWeek());
		return view();
	}
	public function add()
	{
		if (!request()->isPost()) return $this->fetch('index/index');
		$form = input("post.");
		$username = isset($form['username']) ? $form['username'] : '';
		$roundId = isset($form['round_id']) ? $form['round_id'] : 0;
		$weeks = isset($form['weeks']) ? $form['weeks'] : [];
		$types = isset($form['types']) ? $form['types'] : [];
		if (!$roundId) return json(['code'=>0, 'msg'=> '请求参数异常']);
		if (empty($username)) return json(['code'=>0, 'msg'=>'请填写姓名']);
		if (empty($weeks)) return json(['code'=>0, 'msg'=>'请选择就餐日期']); 

	
		$model = new Round();
		$round = $model->get($roundId);
		if (!$round) return json(['code'=>0, 'msg'=> '请求参数异常']);
		$unitPrice = $round['unit_price'] ?: 10;

		$plan = new Plan();
		$res = $plan->where(['round_id'=>$roundId, 'name'=>$username])->find();
		if (!empty($res)) return json(['code'=>0, 'msg'=> '您已经提交过了']);

		$dates = $this->getDate($round['stime'], $round['etime']);


		$data = [];

		foreach ($dates as $date) {
			if (empty($weeks[$date])) continue;
			$type = (int)$types[$date];
			$data[] = [
				'name'     => $username,
				'round_id' => $roundId,
				'day'      => $date,
				'type'     => $type,
				'price'    => $unitPrice ?: 10
			];
		}

		$retval = $plan->saveAll($data,true);
		if (!$retval) return json(['code'=>0, 'msg'=> '数据保存异常，请重试']);
		return json(['code'=>200, 'msg'=> '操作成功']);
	}

	public function getDate($sDate, $eDate)
	{

		$stime = strtotime($sDate);
		$etime = strtotime($eDate);
	
		$data = [];
		while ($stime <= $etime) {
			$data[] = date('Y-m-d', $stime);
			$stime = strtotime('+1 day', $stime);
		}

		return $data;
	}

	public function getWeek()
	{
		$data = [
			'Monday'=> '周一',
			'Tuesday'=> '周二',
			'Wednesday'=> '周三',
			'Thursday'=> '周四',
			'Friday'=> '周五',
			'Saturday'=> '周六',
			'Sunday'=> '周日',
		];
		return $data;
	}
}
