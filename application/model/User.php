<?php

namespace app\model;

use think\Model;
use think\Cache;

class User extends Model
{
	protected $table = 'user';

	//用户状态
	const STATUS_NORMAL = 1; //正常状态
	const STATUS_DISABLED = 0; //禁用

	//用户类型
	const TYPE_SUPER_ADMIN = 1;//超级管理员
	const TYPE_ADMIN = 2;//普通管理员

	public static $status_title = [
		self::STATUS_NORMAL => '正常',
		self::STATUS_DISABLED => '禁用'
	];

	public static $type_title = [
		self::TYPE_SUPER_ADMIN => '超级管理员',
		self::TYPE_ADMIN => '普通管理员'
	];

	//通过account/token获取用户的信息
	public function getUserInfo($sign)
	{
		if (!$sign) return false;
		$data = $this->where('account', $sign)->whereOr('token', $sign)->cache(true)->find(1)->toArray();
		return $data;
	}

	//单个添加
	public function add($data)
	{
		return $this->save($data);
	}

	//批量添加
	public function addAll($data)
	{
		return $this->saveAll($data);
	}
}

?>
