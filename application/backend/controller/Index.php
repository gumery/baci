<?php
namespace app\backend\controller;

use app\index\model\Round as Round;
use app\index\model\Plan as Plan;
use think\Validate as Validate;

class Index extends Base
{
    public function index()
	{
		return view();
	}
}
