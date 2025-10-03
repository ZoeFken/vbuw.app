<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * De welcome controller
 * 
 * @author    Casteels Pieter-Jan
 * @copyright 2020 Casteels Pieter-Jan
 * @version   0.5
 */

class Welcome extends MY_Controller 
{
	public function __construct() 
    {
		parent::__construct();
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login');
		}
	}

	public function index()
	{
		$this->myRedirect();
	}
}
