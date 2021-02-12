<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * De aanmaak documenten controller
 * 
 * @author    Casteels Pieter-Jan
 * @copyright 2021 Casteels Pieter-Jan
 * @version   0.5
 */

class Create_s505 extends MY_Controller 
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
		$this->loadLang(S505);

		$data = [
			'title' => $this->lang->line('titel')
		];

		$this->load->view('templates/header', $data);
		$this->load->view('pages/create_s505');
		$this->load->view('templates/footer');
	}

	/** ------------------------------------
	 *                 S 505               |
	 * -----------------------------------*/

	/**
	 * Verzamel de s505 data en schrijf deze weg
	 * 
	 * @param document_id if edit
	 */
	public function s505($document_id = false)
	{
		$this->load->model('document_model');
		$validated = $this->validateS505();

		if($validated == TRUE)
		{
			$type = 's505';
			$inputData = $this->collectS505Data();

			// echo '<pre>';
			// var_dump($inputData);
			// echo '</pre>';
		
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
				$data['s505_input_name'] = $element[0];
				$data['s505_input_input'] = $element[1];

				if($document_id === false)
				{
					$data['s505_input_created_at'] = date('Y-m-d H:i:s');
					$this->document_model->setS505enInputData($data);
				}
				else
				{
					$data['s505_input_updated_at'] = date('Y-m-d H:i:s');
					$this->document_model->updateS505enInputData($data);
				}

			}

			$this->logging->Log($this->session->userdata('user_id'), '201', 'S505 aangemaakt of aangepast ' . $data['document_id']);
			redirect(base_url('documents'));
		}

		else 
		{
			// Voeg repopulatie toe
			$this->logging->Log($this->session->userdata('user_id'), '202', 'S505 validatie gefaald');
			redirect(base_url('create_s505'));
		}
	}

	/**
	 * Validatie van het s505 document
	 * 
	 * @return form_validation
	 */
	private function validateS505()
	{
		$this->form_validation->set_error_delimiters('<div class="p-3 mb-2 bg-danger text-white">', '</div>');
		$this->form_validation->set_rules('vermoedelijkeDuur','Vermoedelijke duur','trim|min_length[5]|valid_hours_minutes');
		$this->form_validation->set_rules('eindDatum','Eind datum','trim|min_length[10]|max_length[10]|valid_date[d-m-Y]');
		$this->form_validation->set_rules('eindUur','Eind uur','trim|min_length[5]|max_length[5]|valid_time');

		return $this->form_validation->run();
	}

	/**
	 * Verzamel al de ingevulde s505 data
	 * 
	 * @return array met key
	 */
	private function collectS505Data()
	{
		$data = array(
			array('houderS627', $this->input->post('houderS627')),
			array('verantwoordelijkeBss', $this->input->post('verantwoordelijkeBss')),
			array('gevallen', $this->input->post('gevallen')),
			array('lijn1', $this->input->post('lijn1')),
			array('spoor1', $this->input->post('spoor1')),
			array('ap1', $this->input->post('ap1')),
			array('lijn2', $this->input->post('lijn2')),
			array('spoor2', $this->input->post('spoor2')),
			array('ap2', $this->input->post('ap2')),
			array('tpoBnx', $this->input->post('tpoBnx')),
			array('eindDatum', $this->input->post('eindDatum')),
			array('eindUur', $this->input->post('eindUur'))
		);

		return $data;
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