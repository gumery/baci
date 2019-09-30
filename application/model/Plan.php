<?php

namespace app\model;

use think\Model;
use think\Cache;

class Plan extends Model
{
	protected $table = 'plan';

	public function getCreateTimeAttr($time)
	{
    	return $time;//返回create_time原始数据，不进行时间戳转换。
	}

	public function getList($roundId = 0, $pagesize = 10, $condition = [])
	{
		if (!$roundId) return;

		$query = J([$roundId, $pagesize, $condition]);

		$data = Cache::store('redis')->get('getPlanList'. $query);
		if (!empty($data)) return $data;
		$data = $this->where('round_id', $roundId)->paginate($pagesize, false, $condition);

		Cache::store('redis')->set('getPlanList'. $query, $data);
		return $data;
	}
}

?>
