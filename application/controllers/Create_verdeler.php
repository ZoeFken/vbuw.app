<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * De aanmaak documenten controller
 * 
 * @author    Casteels Pieter-Jan
 * @copyright 2020 Casteels Pieter-Jan
 * @version   0.5
 */

class Create_verdeler extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login');
		}
	}

	public function index()
	{
		$data = [
			'title' => $this->lang->line('titel')
		];

		$this->loadLang(VERDELER);

		$this->load->view('templates/header', $data);
		$this->load->view('pages/create_verdeler');
		$this->load->view('templates/footer');
	}

	/** ------------------------------------
	 *               Verdeler              |
	 * -----------------------------------*/

	/**
	 * Verzamel de verdeler data en schrijf deze weg
	 * 
	 * @param type verdeler
	 */
	public function verdeler($document_id = false)
	{
		$type = 'verdeler';
		$this->load->model('document_model');
		$validated = $this->validateVerdeler();

		if ($validated == TRUE) {
			$inputData = $this->collectVerdelerData();

			if ($document_id === false) {
				$documentData = $this->collectDocumentData($type);
				$inputData['document_id'] = $this->document_model->setDocument($documentData);
				$inputData['verdeler_created_at'] = date('Y-m-d H:i:s');
			} else {
				$inputData['document_id'] = $document_id;
				$inputData['verdeler_updated_at'] = date('Y-m-d H:i:s');
			}

			if (empty($inputData['document_id']) || empty($inputData)) return null;

			if ($document_id === false) {
				$this->document_model->setVerdelersData($inputData);
			} else {
				$this->document_model->updateVerdelersData($inputData);
			}

			$this->logging->Log($this->session->userdata('user_id'), '301', 'Verdeler aangemaakt of aangepast ' . $inputData['document_id']);
			redirect(base_url('documents'));
		} else {
			$this->logging->Log($this->session->userdata('user_id'), '302', 'Verdeler validatie gefaald');
			redirect(base_url('create_verdeler'));
		}
	}

	/**
	 * Editeer een specifiek document
	 * 
	 * @param document_id
	 */
	public function editDocument($document_id)
	{
		$this->load->model('document_model');
		$this->checkIfOwner($document_id);
		$info['document_id'] = $document_id;

		$info['verdelers'] = $this->document_model->getDocumentVerdelers($document_id);

		// echo '<pre>';
		// var_dump($info);
		// echo '</pre>';

		$data = [
			'title' => $this->lang->line('titel')
		];

		$this->loadLang(VERDELER);

		$this->load->view('templates/header', $data);
		$this->load->view('pages/edit_verdeler', $info);
		$this->load->view('templates/footer');
	}

	/**
	 * Validatie van het verdeler document
	 * 
	 * @return form_validation
	 */
	private function validateVerdeler()
	{
		$this->form_validation->set_error_delimiters('<div class="p-3 mb-2 bg-danger text-white">', '</div>');
		$this->form_validation->set_rules('aanvangsDatum', 'Aanvangs datum', 'trim|min_length[10]|max_length[10]|valid_date[d-m-Y]');
		$this->form_validation->set_rules('aanvangUur', 'Aanvang uur', 'trim|min_length[5]|max_length[5]|valid_time');
		$this->form_validation->set_rules('eindDatum', 'Eind datum', 'trim|min_length[10]|max_length[10]|valid_date[d-m-Y]');
		$this->form_validation->set_rules('eindUur', 'Eind uur', 'trim|min_length[5]|max_length[5]|valid_time');

		return $this->form_validation->run();
	}

	/**
	 * Verzamel al de ingevulde verdeler data
	 * 
	 * @return data array
	 */
	private function collectVerdelerData()
	{
		$data['verdeler_bnx'] = $this->input->post('bnx');
		$data['verdeler_aanvangsDatum'] = $this->input->post('aanvangsDatum');
		$data['verdeler_aanvangUur'] = $this->input->post('aanvangUur');
		$data['verdeler_eindDatum'] = $this->input->post('eindDatum');
		$data['verdeler_eindUur'] = $this->input->post('eindUur');
		$data['verdeler_lijn'] = $this->input->post('lijn');
		$data['verdeler_spoor'] = $this->input->post('spoor');
		// $data['verdeler_kpVan'] = $this->input->post('kpVan');
		// $data['verdeler_kpTot'] = $this->input->post('kpTot');
		$data['verdeler_tpo'] = $this->input->post('tpo');
		$data['verdeler_gevallen'] = $this->input->post('gevallen');
		$data['verdeler_uiterstePalen'] = $this->input->post('uiterstePalen');
		$data['verdeler_geplaatstePalen'] = $this->input->post('geplaatstePalen');
		$data['verdeler_documentNaam'] = $this->input->post('documentNaam');

		return $data;
	}

	/** ------------------------------------
	 *                Andere               |
	 * -----------------------------------*/

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
