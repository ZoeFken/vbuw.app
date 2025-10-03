<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * De admin controller
 * 
 * @author    Casteels Pieter-Jan
 * @copyright 2020 Casteels Pieter-Jan
 * @version   0.5
 */

class Admin extends MY_Controller 
{
	public function __construct() 
    {
		parent::__construct();
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('auth/login');
		}
	}
	
	public function index()
	{
		redirect('auth');
	}
}
