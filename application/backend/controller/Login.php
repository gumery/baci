<?php
namespace app\backend\controller;

use think\Controller;
use app\model\User as UserModel; 
use app\plugin\Auth as Auth;
use think\Session as Session;

class Login extends Controller
{
	public function index()
	{
		$token = Session::get('access_token');
		if ($token) $this->redirect('/backend/index');
		return view();
	}

	public function login()
	{
		if (!request()->isPost()) return $this->error('请求方式错误！');
		
		$form = input('post.');
		$account = isset($form['username']) ? $form['username'] : '';
		$password = trim(isset($form['password']) ? $form['password'] : '');

		if (!$account) return json(['code'=>0, 'msg'=>'请输入用户名']);
		if (!$password) return json(['code'=>0, 'msg'=>'请输入用户名']);

		$user = new UserModel;
		$res = $user->getUserInfo($account);
		if (!$res) return json(['code'=>0, 'msg'=>'用户不存在']);

		$auth = new Auth();
		if (!$auth->checkPassword($password)) {
			return json(['code'=>0, 'msg'=>'密码不正确']);
		}

		if ($res['status'] == $user::STATUS_DISABLED) {
			return json(['code'=>0, 'msg'=>'用户已禁用']);
		}

		Session::set('access_token', $res['token']);

		return json(['code'=>200, 'msg'=>'登录成功']);
	}

}
