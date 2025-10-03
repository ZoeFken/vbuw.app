<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * redirect to main pagina
 * 
 * @author    Casteels Pieter-Jan
 * @copyright 2020 Casteels Pieter-Jan
 * @version   0.5
 */

class Test extends MY_Controller 
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
		redirect(base_url());
	}
}
