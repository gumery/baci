<?php

namespace app\model;

use think\Model;
use think\Cache;

class Round extends Model
{
	protected $table = 'round';

	const TYPE_TABLE = 1;
	const TYPE_SELF_HELP = 2;

	const STATUS_ON = 1;
	const STATUS_DONE = 2;

	public static $type_title = [
		self::TYPE_TABLE = "餐桌";
		self::TYPE_SELF_HELP = "自助";
	];

	public static $status_title = [
		self::STATUS_ON = "开启";
		self::STATUS_ON = "关闭";
	];	

	public function getRound($id = 0)
	{
		if (!$id) return false;

		$data = $this->cache('round_info'.$id, 600, 'round')->get($id);
		return $data;
	}
}

?>
