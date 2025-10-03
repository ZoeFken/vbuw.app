<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Applicatie procedure pagina
 * 
 * @author    Casteels Pieter-Jan
 * @copyright 2020 Casteels Pieter-Jan
 * @version   0.5
 */

class Request extends MY_Controller 
{
	public function __construct() 
    {
        parent::__construct();
    }

	/**
	 * Hoofdpagina applicatie
	 */
	public function index()
	{
		$data = [
			'title' => 'Application'
		];

		$this->load->view('templates/header', $data);
		$this->load->view('pages/request');
		$this->load->view('templates/footer');
	}
}
