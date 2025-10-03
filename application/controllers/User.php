<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * De gebruiker controller
 * 
 * @author    Casteels Pieter-Jan
 * @copyright 2020 Casteels Pieter-Jan
 * @version   0.5
 */

class User extends MY_Controller 
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
		$data = [
			'title' => 'VBUW Document generator',
		];

		$this->loadLang(WELCOME);

		$this->load->view('templates/header', $data);
		$this->load->view('pages/welcome_message');
		$this->load->view('templates/footer');
	}
}
