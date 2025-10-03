<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Download de documenten
 * 
 * @author    Casteels Pieter-Jan
 * @copyright 2020 Casteels Pieter-Jan
 * @version   0.5
 */

class Downloads extends MY_Controller 
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
	 * Genereer het s627 document
	 * 
	 * @param $document_id
	 */
	public function s627($document_id)
	{
		$opgemaaktDoor = $this->document_model->getDocumentCreatorName($document_id);
		$documentS627enData = $this->document_model->getDocumentS627en($document_id);
		$docNeeded = $this->input->post('S627type');

		$baseURL = './assets/base/';
		
		switch($docNeeded) 
		{
			case 'S627':
				$sourceFile = $baseURL . 'S627.pdf';
			break;
			case 's627bLvhw':
				$sourceFile = $baseURL . 'S627-bis-lvhw.pdf';
			break; 
			case 's627bWl':
				$sourceFile = $baseURL . 'S627-bis-wl.pdf';
			break;
			default:
				$sourceFile = $baseURL . 'S627.pdf';
		}

		$single = array();
		$textbox = array();
		foreach($documentS627enData as $s627)
		{
			if($s627['s627_name'] != 'documentNaam') ($s627['s627_align'] == null) ? array_push($single, $s627) : array_push($textbox, $s627);
		}

		$data['single'] = $single;
		$data['textbox'] = $textbox;
		$data['hoeveelDagen'] = $this->collectHoeveelDagen();
		$data['overdracht'] = $this->input->post('overdracht');
		$data['opgemaaktDoor'] = $opgemaaktDoor;

		$this->load->library('CreateS627Pdf');
		($this->creates627pdf->create($data, $sourceFile)) ?
			$this->logging->Log($this->session->userdata('user_id'), '501', 'S627 ' . $document_id . ' gedownload') :
			$this->logging->Log($this->session->userdata('user_id'), '511', 'S627 ' . $document_id . ' kon niet gedownload worden');
	}

	/**
	 * Genereer het verdeler document
	 * 
	 * @param $document_id
	 */
	public function verdeler($document_id)
	{
		$opgemaaktDoor = $this->document_model->getDocumentCreatorName($document_id);
		$docNeeded = $this->input->post('verdelertype');
		$hoeveelDagen = $this->collectHoeveelDagen();
		$data = $this->document_model->getDocumentVerdelers($document_id);
		$name = (!empty($opgemaaktDoor)) ? '.' . $opgemaaktDoor : '';

		switch ($docNeeded)
		{
			case 'verdeler':
				$sourceFile = 'create/table_verdeler';
				$docName = 'verdeler';
			break;
			case 'overdracht':
				$sourceFile = 'create/table_verdeler_overdracht';
				$docName = 'overdracht';
				$hoeveelDagen = 1;
			break;
			default:
				$sourceFile = 'create/table_verdeler';
				$docName = 'verdeler';
		}

		// $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-P']);
		$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-P','tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf']);
		$mpdf->use_kwt = true;
		$mpdf->shrink_tables_to_fit = 1;

		for($i = 0; $i < $hoeveelDagen; $i++ )
		{
			$interval = new DateInterval('P1D');

			$dateStart = new DateTime($data['verdeler_aanvangsDatum']);
			$dateEnd = new DateTime($data['verdeler_eindDatum']);
		
			if($i > 0) {
				$dateStart->add($interval);
				$dateEnd->add($interval);
			}

			$data['verdeler_aanvangsDatum'] = $dateStart->format('d-m-Y');
			$data['verdeler_eindDatum'] = $dateEnd->format('d-m-Y');

			$html = $this->load->view($sourceFile, $data, true);
			$mpdf->addPage();
			$mpdf->WriteHTML($html);
		}

		$mpdf->Output(date("Y-m-d_H-i-s") . $name . '.' . $docName . '.pdf', 'D');
		$this->logging->Log($this->session->userdata('user_id'), '502', 'Verdeler ' . $document_id . ' gedownload');
	}

	/**
	 * Genereer het s460document
	 * 
	 * @param $document_id
	 */
	public function s460($document_id)
	{
		$this->load->model('document_model');

		$data['input'] = $this->document_model->getDocumentS460en($document_id);
		$data['locaties'] = $this->document_model->getS460Locaties();
		$data['startDatum'] = (!empty($this->input->post('startDate'))) ? $this->input->post('startDate') : date("d-m-Y");
		$data['hoeveelDagen'] = $this->collectHoeveelDagen();
		$data['opgemaaktDoor'] = $this->document_model->getDocumentCreatorName($document_id);
		$data['wissel'] = (!empty($this->input->post('wissel'))) ? '0' : '1';

		if(empty($data)) return NULL;

		$sourceFile = './assets/base/S460.pdf';
		$this->load->library('CreateS460Pdf');
		($this->creates460pdf->create($data, $sourceFile)) ?
			$this->logging->Log($this->session->userdata('user_id'), '503', 'S460 ' . $document_id . ' gedownload') :
			$this->logging->Log($this->session->userdata('user_id'), '513', 'S460 ' . $document_id . ' kon niet gedownload worden');
	}

	/**
	 * Genereer het s505 document
	 * 
	 * @param $document_id
	 */
	public function s505($document_id)
	{
		$opgemaaktDoor = $this->document_model->getDocumentCreatorName($document_id);
		$documentS505enData = $this->document_model->getDocumentS505en($document_id);

		$sourceFile = './assets/base/S505.pdf';

		$single = array();
		$textbox = array();
		foreach($documentS505enData as $s505)
		{
			($s505['s505_align'] == null) ? array_push($single, $s505) : array_push($textbox, $s505);
		}

		$data['single'] = $single;
		$data['textbox'] = $textbox;
		$data['hoeveelDagen'] = $this->collectHoeveelDagen();
		$data['overdracht'] = $this->input->post('overdracht');
		$data['opgemaaktDoor'] = $opgemaaktDoor;

		$this->load->library('CreateS505Pdf');
		($this->creates505pdf->create($data, $sourceFile)) ?
			$this->logging->Log($this->session->userdata('user_id'), '501', 'S505 ' . $document_id . ' gedownload') :
			$this->logging->Log($this->session->userdata('user_id'), '511', 'S505 ' . $document_id . ' kon niet gedownload worden');
	}

	/**
	 * Verzamel en controleer het aantal dagen bedoeld voor een document
	 * 
	 * @return hoeveelDagen
	 */
	private function collectHoeveelDagen()
	{
		$hoeveelDagen = $this->input->post('hoeveelDagen');
		if(empty($hoeveelDagen) || $hoeveelDagen <= 0) $hoeveelDagen = "1";
		if($hoeveelDagen >= 8) $hoeveelDagen = "7";

		return $hoeveelDagen;
	}
}
