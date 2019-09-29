<?php
/*************************************************************************
    > File Name: Auth.php
    > Author: yuxiang.gao
    > Mail: jsjshan123@163.com
    > Created Time: Fri 27 Sep 2019 12:01:36 PM CST
	************************************************************************/

namespace app\plugin;

class Auth
{
		//Create a password hash:
		public function getPassword($password)
		{
				$phpass = self::getPhpass();
				return $phpass->hashPassword($password);
		}

		//verify a password hash:
		public function checkPassword($password)
		{
			$phpass = self::getPhpass();
			$passwordHash = $phpass->hashPassword($password);
			if ($phpass->checkPassword($password, $passwordHash)) {
    			return true;
			} else {
    			return false;
			}
		}

		//Use the default bcrypt adapter:
		//Use the PBKDF2 adapter:
		protected static function getPhpass()
		{
			// Customize hash adapter - PBKDF2 adapter, 15,000 iterations
			$adapter = new \Phpass\Hash\Adapter\Pbkdf2(array (
    			'iterationCount' => 15000
			));
			$phpassHash = new \Phpass\Hash($adapter);
			return $phpassHash;
		}
}

?>
