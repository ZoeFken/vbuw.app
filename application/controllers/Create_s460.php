<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * De aanmaak documenten controller
 * 
 * @author    Casteels Pieter-Jan
 * @copyright 2020 Casteels Pieter-Jan
 * @version   0.5
 */

class Create_s460 extends MY_Controller 
{
	public function __construct() 
    {
		parent::__construct();
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login');
		}
	}
	
	/**
	 * Hoofdpagina aanmaak S 460
	 */
	public function index()
	{
		$this->loadLang(S460);

		$data = [
			'title' => $this->lang->line('titel')
		];

		$this->load->view('templates/header', $data);
		$this->load->view('pages/create_s460');
		$this->load->view('templates/footer');
	}

	/**
	 * Verzamel de s627 data en schrijf deze weg
	 * 
	 * @param document_id if edit
	 */
	public function s460($document_id = false)
	{
		$this->load->model('document_model');

		if($document_id != false)
		{
			$this->document_model->deleteS460enInputData($document_id);
		}

		$type = 's460';
		$inputData = $this->collectS460Data();
		if($document_id === false)
		{
			$documentData = $this->collectDocumentData($type);
			$docId = $this->document_model->setDocument($documentData);
		}
		else
		{
			$docId = $document_id;
		}
		
		if(empty($docId) || empty($inputData)) return null;

		foreach($inputData as $element)
		{
			$data['document_id'] = $docId;
			$data['s460_input_melding'] = $element['s460_input_melding'];
			$data['s460_input_verzender'] = $element['s460_input_verzender'];

			$data['s460_input_created_at'] = date('Y-m-d H:i:s');
			$this->document_model->setS460enInputData($data);	
		}
		
		redirect(base_url('documents'));
	}

	/**
	 * Editeer het document
	 * 
	 * @param document_id
	 */
	public function editDocument($document_id)
	{
		$this->load->model('document_model');
		$this->checkIfOwner($document_id);
		$info['document_id'] = $document_id;
		$s460en = $this->document_model->getEditDocumentS460en($document_id);

		$info['fields'] = array();
		foreach($s460en as $s460)
		{
			$add = array($s460['s460_input_id'], $s460['s460_input_melding'], $s460['s460_input_verzender']);
			array_push($info['fields'], $add);
		}

		$this->loadLang(S460);

		$data = [
			'title' => $this->lang->line('titel')
		];

		$this->load->view('templates/header', $data);
		$this->load->view('pages/edit_s460', $info);
		$this->load->view('templates/footer');
	}

	/**
	 * Krijg de gegevens voor de S460
	 */
	private function collectS460Data()
	{
		if(!empty($this->input->post('s460Melding')))
		{
			$meldingen = $this->reOrdenArray($this->input->post('s460Melding'));          
		}
		if(!empty($this->input->post('s460verzender')))
		{
			$verzendingen = $this->reOrdenArray($this->input->post('s460verzender'));   
		}

		for($i = 0; $i < count($meldingen); $i++)
		{
			$data[$i]['s460_input_melding'] = $meldingen[$i]['s460_input_melding'];
			$data[$i]['s460_input_verzender'] = $verzendingen[$i]['s460_input_verzender'];
		}
		
		return $data;
	}

	/**
	 * Reset de key values van een array 0,1,2,3,...
	 * 
	 * @param $array
	 * @return $newArray
	 */
	private function reOrdenArray($array)
	{
		$newArray = array();
		$keyValue = 0;
		foreach($array as $item)
		{
			$newArray[$keyValue] = $item;
			$keyValue++;
		}

		return $newArray;
	}

	/**
	 * Verzamel de data voor een document
	 * 
	 * @param $type of document
	 * @retrun array of data
	 */
	private function collectDocumentData($type)
	{
		$data = [
			'user_id' => $this->session->userdata('user_id'),
			'document_type' => $type,
			'document_created_at' => date('Y-m-d H:i:s')
		];

		return $data;
	}
}
