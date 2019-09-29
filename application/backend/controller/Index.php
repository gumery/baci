<?php
namespace app\backend\controller;

use think\Session as Session;

class Index extends Base
{
	//判断用户是否登录状态
	public function __construct()
	{
		parent::__construct();
		$this->checkLogin();
	}

	//首页
    public function index()
	{
		return view();
	}

	//登出
	public function logout()
	{
		Session::clear();
		$this->redirect('/backend/login');
	}	
}
