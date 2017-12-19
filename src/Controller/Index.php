<?php
namespace App\Controller;

class Index
{
    public function index(){
			\dmy\logger\Log::add('debug', '测试', []);
			
        dump(__FILE__);
    }
}
