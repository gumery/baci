<?php

namespace app\model;

use think\Model;

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

		$data = $this->where('round_id', $roundId)->paginate($pagesize, false, $condition);

		return $data;
	}
}

?>
