<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * De aanmaak documenten controller
 * 
 * @author    Casteels Pieter-Jan
 * @copyright 2020 Casteels Pieter-Jan
 * @version   0.5
 */

class Create_s627 extends MY_Controller 
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
	 * Hoofdpagina aanmaak S 627
	 */
	public function index()
	{
		$this->loadLang(S627);

		$data = [
			'title' => $this->lang->line('titel')
		];

		$this->load->view('templates/header', $data);
		$this->load->view('pages/create_s627');
		$this->load->view('templates/footer');
	}

	/** ------------------------------------
	 *                 S 627               |
	 * -----------------------------------*/

	/**
	 * Verzamel de s627 data en schrijf deze weg
	 * 
	 * @param document_id if edit
	 */
	public function s627($document_id = false)
	{
		$this->load->model('document_model');
		$validated = $this->validateS627();

		if($validated == TRUE)
		{
			$type = 's627';
			$inputData = $this->collectS627Data();
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
				$data['s627_input_name'] = $element[0];
				$data['s627_input_input'] = $element[1];

				if($document_id === false)
				{
					$data['s627_input_created_at'] = date('Y-m-d H:i:s');
					$this->document_model->setS627enInputData($data);
				}
				else
				{
					$data['s627_input_updated_at'] = date('Y-m-d H:i:s');
					$this->document_model->updateS627enInputData($data);
				}

			}

			redirect(base_url('documents'));
		}

		else redirect(base_url('create_s627'));
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
		$s627en = $this->document_model->getEditDocumentS627en($document_id);

		foreach($s627en as $s627)
		{
			if(!empty($s627['s627_input_name']) || !empty($s627['s627_input_input'])) $info[$s627['s627_input_name']] = $s627['s627_input_input']; 			
		}

		$this->loadLang(S627);

		$data = [
			'title' => $this->lang->line('titel')
		];

		$this->load->view('templates/header', $data);
		$this->load->view('pages/edit_s627', $info);
		$this->load->view('templates/footer');
	}

	/**
	 * Validatie van het s627 document
	 * 
	 * @return form_validation
	 */
	private function validateS627()
	{
		$this->form_validation->set_error_delimiters('<div class="p-3 mb-2 bg-danger text-white">', '</div>');
		$this->form_validation->set_rules('vermoedelijkeDuur','Vermoedelijke duur','trim|min_length[5]|valid_hours_minutes');
		$this->form_validation->set_rules('aanvangDatum','Aanvangs datum','trim|min_length[10]|max_length[10]|valid_date[d-m-Y]');
		$this->form_validation->set_rules('aanvangUur','Aanvang uur','trim|min_length[5]|max_length[5]|valid_time');
		$this->form_validation->set_rules('eindDatum','Eind datum','trim|min_length[10]|max_length[10]|valid_date[d-m-Y]');
		$this->form_validation->set_rules('eindUur','Eind uur','trim|min_length[5]|max_length[5]|valid_time');

		return $this->form_validation->run();
	}

		/**
	 * Verzamel al de ingevulde s627 data
	 * 
	 * @return array met key
	 */
	private function collectS627Data()
	{
		$vermoedelijkeDuur = (empty($this->input->post('vermoedelijkeDuur'))) ? $this->calculateDiffrence() : $this->input->post('vermoedelijkeDuur');
		
		$data = array(
			array('ingediendDoor', $this->input->post('ingediendDoor')),
			array('specialiteit', $this->input->post('specialiteit')),
			array('aan', $this->input->post('aan')),
			array('post', $this->input->post('post')),
			array('station', $this->input->post('station')),
			array('aanvraag', $this->input->post('aanvraag')),
			array('aanvangDatum', $this->input->post('aanvangDatum')),
			array('aanvangUur', $this->input->post('aanvangUur')),
			array('vermoedelijkeDuur', $vermoedelijkeDuur),
			array('rubriek2ARMS', $this->input->post('rubriek2ARMS')),
			array('rubriek2AAndere', $this->input->post('rubriek2AAndere')),
			array('rubriek5VVHW', $this->input->post('rubriek5VVHW'))
		);

		return $data;
	}

	/** ------------------------------------
	 *                Andere               |
	 * -----------------------------------*/

	/**
	 * Bereken het verschil tussen ingevoerde data
	 * @return tijdsverschil
	 */
	private function calculateDiffrence()
	{
		$data = [
			'aanvangDatum' => $this->input->post('aanvangDatum'),
			'aanvangUur' => $this->input->post('aanvangUur'),
			'eindDatum' => $this->input->post('eindDatum'),
			'eindUur' => $this->input->post('eindUur')
		];
        
		foreach($data as $input)
		{
			if(empty($input)) return NULL;
		}

		$from = strtotime($data['aanvangDatum'] . " " . $data['aanvangUur']);
		$to = strtotime($data['eindDatum'] . " " . $data['eindUur']);
		$time = round(abs($to - $from) / 60,2); 

		$hours = floor($time / 60);
		$minutes = ($time % 60);

		if($hours == 0 && $minutes == 0) return " ";

		while(strlen($hours) < 2)
		{
			$hours = '0' . $hours;
		}
		while(strlen($minutes) < 2)
		{
			$minutes = '0' . $minutes;
		}

		return $hours . ":" . $minutes;
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
