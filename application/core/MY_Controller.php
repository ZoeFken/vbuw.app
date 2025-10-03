<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller 
{
    public function __construct() 
    {
		parent::__construct();
		$this->loadLang(NAV);
    }

    /**
     * Load het taal bestand
     * 
     * @param $page welke pagina wil je laden
     */
    protected function loadLang($page)
    {
        $lang = (!empty($this->session->userdata('lang'))) ? strtolower($this->session->userdata('lang')) : $this->config->item('language');
        $this->lang->load($page, $lang);
    }

    /**
     * Redirect de ingelogede gebruiker naar de juiste start pagina
     */
    protected function myRedirect()
    {
        if ($this->ion_auth->logged_in() && !$this->ion_auth->is_admin()) redirect(base_url() . 'user');
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) redirect(base_url() . 'admin');
        redirect(base_url() . 'auth/login');
	}

	/**
	 * Controle of de gebruiker ook de eigenaar is van een document
	 */
	protected function checkIfOwner($document_id)
	{
		$this->load->model('document_model');
		$user_id = $this->session->userdata('user_id');
		if(!$this->ion_auth->is_admin())
		{
			if(!$this->document_model->isUserOwnerDocument($document_id, $user_id)) $this->myRedirect();
		}
		return true;
	}
}
