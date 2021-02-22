<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * De documenten controller
 * 
 * @author    Casteels Pieter-Jan
 * @copyright 2020 Casteels Pieter-Jan
 * @version   0.5
 */

class Documents extends MY_Controller 
{
	public function __construct() 
    {
		parent::__construct();
		$this->load->model('document_model');
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login');
		}
	}

	/**
	 * Hoofdpagina documenten
	 */
	public function index()
	{
		$this->personal();
	}

	/**
	 * Hoofdpagina documenten
	 */
	public function personal()
	{
		$user_id = $this->session->userdata('user_id');
		$documents = [
			'documents' => $this->getLatestUserDocuments(10, $user_id),
			'persoonlijk' => TRUE
		];
		$data = ['title' => 'Download bestanden'];

		$this->loadLang(DOCUMENT);

		$this->load->view('templates/header', $data);
		$this->load->view('pages/documents', $documents);
		$this->load->view('templates/footer');
	}

	/**
	 * Krijg alle documenten terug indien admin
	 */
	public function all()
	{
		$documents = [
			'documents' => $this->getLatestDocuments(25),
			'persoonlijk' => FALSE
		];	
		$data = ['title' => 'Download bestanden'];

		$this->loadLang(DOCUMENT);

		$this->load->view('templates/header', $data);
		$this->load->view('pages/documents', $documents);
		$this->load->view('templates/footer');
	}

	/**
	 * Krijg alle documenten van een specifieke gebruiker
	 * 
	 * @param $user_id
	 */
	public function specific($user_id)
	{
		if (!$this->ion_auth->is_admin())
		{
			redirect('auth/login');
		}
		$documents = [
			'documents' => $this->getLatestUserDocuments(10, $user_id),
			'persoonlijk' => FALSE
		];	
		$data = ['title' => 'Download bestanden'];

		$this->loadLang(DOCUMENT);

		$this->load->view('templates/header', $data);
		$this->load->view('pages/documents', $documents);
		$this->load->view('templates/footer');
	}

	/**
	 * Krijg de laatste documenten terug
	 * 
	 * @param limit de aantal nodige documenten standaard 25
	 * @return array van documenten
	 */
	private function getLatestDocuments($limit = 25)
	{
		// $this->load->model('document_model');
		return $this->document_model->getLatestDocuments($limit);
	}

	/**
	 * Krijg de laatste documenten terug van een gebruiker
	 * 
	 * @param limit de aantal nodige documenten standaard 25
	 * @param user_id
	 * @return array van documenten
	 */
	private function getLatestUserDocuments($limit = 25, $user_id)
	{
		// $this->load->model('document_model');
		return $this->document_model->getLatestUserDocuments($limit, $user_id);
	}

	/**
	 * Verwijder een document en geassocieerde velden
	 * 
	 * @param document_id
	 */
	public function removeDocument($document_id, $redirect = true)
	{
		if (!$this->checkIfOwner($document_id))
		{
			if(!$this->ion_auth->is_admin()) redirect('auth/login');
		}

		// $this->load->model('document_model');

		$document = $this->document_model->getDocument($document_id);
		$document_type = $document['document_type'];

		switch($document_type)
		{
			case "s627":
				$this->document_model->deleteS627enInputData($document_id);
			break;
			case "verdeler":
				$this->document_model->deleteVerdelersData($document_id);
			break;
			case "s460":
				$this->document_model->deleteS460enInputData($document_id);
			break;
			case "s505":
				$this->document_model->deleteS505enInputData($document_id);
			break;
		}

		$this->document_model->deleteDocument($document_id);
		$this->logging->Log($this->session->userdata('user_id'), '401', 'Document ' . $document['document_type'] .' ' . $document_id . ' verwijderd');
		if($redirect) redirect(base_url() . 'documents/personal');
	}

	/**
	 * Verwijder alle gebruikers hun teveel aan documenten
	 */
	public function removeAllExtraDocuments()
	{
		if (!$this->ion_auth->is_admin())
		{
			redirect('auth/login');
		}

		$allUsers = $this->document_model->getAllUsers();

		foreach($allUsers as $user_id) $this->removeExtraDocuments($user_id['id'], false);

		redirect(base_url() . 'auth');
	}

	/**
	 * Verwijder alle oude documenten en geassocieerde velden
	 * 
	 * @param user_id
	 * @param singleUser = true
	 */
	public function removeExtraDocuments($user_id, $singleUser = true)
	{
		if (!$this->ion_auth->is_admin())
		{
			redirect('auth/login');
		}

		// $this->load->model('document_model');

		$allUserDocuments = $this->document_model->getAllUsersDocuments($user_id);

		if(!empty($allUserDocuments))
		{
			if(count($allUserDocuments) > 10)
			{
				// Zet document als referentie en niet als nieuwe variabele
				foreach($allUserDocuments as &$document)
				{
					if($document['document_updated_at'] != '0000-00-00 00:00:00') 
					{
						$document['document_created_at'] = $document['document_updated_at'];
					}
				}
	
				// Callback voor het sorteren van de array
				usort($allUserDocuments, array($this, 'date_compare'));
				$reversedArray = array_reverse($allUserDocuments);
	
				for($i = 9; $i < count($reversedArray); $i++)
				{
					var_dump($reversedArray[$i]);
					$this->removeDocument($reversedArray[$i]['document_id'], false);
				}
			}
		}

		$this->logging->Log($this->session->userdata('user_id'), '402', 'Extra documenten verwijderd (max 10)');
		if ($singleUser === true) redirect(base_url() . 'auth');
	}

	/**
	 * Callback functie voor het vergelijken van twee datums
	 */
	private function date_compare($a, $b)
	{
		$t1 = strtotime($a['document_created_at']);
		$t2 = strtotime($b['document_created_at']);
		return $t1 - $t2;
	}
	
}
