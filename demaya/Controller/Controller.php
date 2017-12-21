<?php

namespace demaya\Controller;

use demaya\Http\Request;
use demaya\Http\Response;

class Controller
{

	/**
	 *
	 * @var \demaya\Http\Request;
	 */
	public $request;
	public $response;

	public function __construct(Request $request = null, Response $response = null)
	{

		$this->setRequest($request !== null ? $request : new Request);
		$this->response = $response !== null ? $response : new Response;


		$this->initialize();
	}

	public function initialize()
	{
		
	}

	public function setRequest(Request $request)
	{
		$this->request = $request;
	}

}
