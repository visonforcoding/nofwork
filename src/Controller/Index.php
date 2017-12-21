<?php

namespace App\Controller;

use demaya\Controller\Controller;

class Index extends Controller
{

	public function index()
	{
//        \dmy\logger\Log::add('debug', '测试', []);
		dump(__FILE__);
		var_dump($this->request);
	}

}
