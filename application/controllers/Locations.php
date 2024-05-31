<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * De locaties controller
 * 
 * @author    Casteels Pieter-Jan
 * @copyright 2023 Casteels Pieter-Jan
 * @version   0.5
 */

class Locations extends MY_Controller 
{
	public function __construct() 
    {
		parent::__construct();
		// if (!$this->ion_auth->logged_in())
		// {
		// 	redirect('auth/login');
		// }
    }

	/**
	 * Hoofdpagina locaties
	 */
	public function index()
	{
		$this->loadLang('locations');

		$data = [
			'title' => $this->lang->line('titel')
		];

		$this->load->model('locations_model');
		$info['locations'] = $this->locations_model->getLocations();

		$this->load->view('templates/header', $data);
		$this->load->view('pages/locations', $info);
		$this->load->view('templates/footer');
	}
}