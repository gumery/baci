<?php
namespace app\backend\cli;

use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\Env;

class Test extends Command
{
    protected function configure()
    {
        $this->setName('test')->setDescription('Here is the remark ');
    }

    protected function execute(Input $input, Output $output)
    {
		echo Env::get('database.hostname', 'mysql');
    }
}
