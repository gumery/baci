<?php
namespace app\backend\controller;

use think\Controller;
use think\Db;
use think\Cookie;
use think\Session;
use app\model\User as userModel;

class Base extends Controller
{
	protected $user_id;
	protected $token;
	protected $user_info;
	protected $web_title;

    protected $messge = [
        '400' => 'Bad Request',
        '404' => 'Not Found',
        '500' => 'Internal Server Error',
        '200' => 'OK'
	];

    protected function response($code = 400, $msg = '', $data = [])
    {
        $response = [
            'code'  => $code,
            'msg'   => $msg ?: $this->messge[$code]
        ];
        if (!empty($data)) {
            $response = array_merge($response, $data);
        }

        return $response;
    }

	public function __construct()
	{
		parent::__construct();
		$this->init();	
	}

	public function init(){
		$this->token = Session::get('access_token');

		$userModel = new userModel;
		$userInfo = $userModel->getUserInfo($this->token);
		$this->user_id = $userInfo['id'];
		$this->user_info = $userInfo;
		$this->web_title = '投票系统';

		$this->assign('user_id', $this->user_id);
		$this->assign('token', $this->token);
		$this->assign('user_info', $this->user_info);
		$this->assign('web_title', $this->web_title);
	}

	public function checkLogin()
	{
		if (!$this->token) {
			$this->redirect('/backend/login');
		} 
	}
}
