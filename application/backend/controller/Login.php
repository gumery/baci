<?php
namespace app\backend\controller;

class Login extends Base
{
	public function index()
	{
		return view();
	}

	public function login()
	{
		if (!request()->isPost()) return $this->error('验证码错误！');
	}
}
