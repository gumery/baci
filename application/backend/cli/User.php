<?php
namespace app\backend\cli;

use think\console\Command;
use think\console\Input;
use think\console\Output;
use app\plugin\Auth as auth;
use app\model\User as UserModel;

class User extends Command
{
    protected function configure()
    {
        $this->setName('user')->setDescription('Here is the remark ');
    }

    protected function execute(Input $input, Output $output)
    {
			$account = 'gumery';
			$name = '高小相';
			$password = 'gaoyx123';
			$status = 1;
			$type = 1;
			
			$auth = new auth;
			$data = [
					'account' => $account,
					'name'    => $name,
					'password'=> $auth->getPassword($password),
					'status'  => $status,
					'type'    => $type
			];

			var_dump($data);
			$user = new UserModel;
			$retval = $user->add($data);

			echo $retval ? 'success' : 'failed';
    }
}
