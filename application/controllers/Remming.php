<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * De remming documenten controller
 * https://www.pdfparser.org/documentation
 * 
 * @author    Casteels Pieter-Jan
 * @copyright 2020 Casteels Pieter-Jan
 * @version   0.1
 */

class Remming extends MY_Controller 
{
	public function __construct() 
    {
		parent::__construct();
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login');
		}
		$this->load->model('remming_model');
	}

    /**
	 * Hoofdpagina remming
	 */
	public function index()
	{
		$this->loadLang(REMMING);

		$data = [
			'title' => $this->lang->line('titel')
		];

		$this->load->view('templates/header', $data);
		$this->load->view('pages/create_remming');
		$this->load->view('templates/footer');
	}

	/**
	 * Edit een trein en de wagens
	 * 
	 * @param $trein_id
	 */
	public function edit($trein_id)
	{
		$this->loadLang(REMMING);

		$data = [
			'title' => $this->lang->line('titel')
		];

		$trein = null;

		if($trein_id != null) $trein = $this->remming_model->getFullTrein($trein_id);

		$this->load->view('templates/header', $data);
		$this->load->view('pages/edit_remming', $trein);
		$this->load->view('templates/footer');
	}

	/**
	 * load a train
	 * 
	 * @param $train_id
	 */
	public function loadTrein($trein_id)
	{
		$trein = $this->remming_model->getTrein($trein_id);
		$wagens = $this->remming_model->getwagens($trein_id);
	}

	/**
	 * Lees de remmingsbulletin en extract de nuttige data
	 */
	public function readFile()
	{
		$config['upload_path']          = './temp_uploads/';
		$config['allowed_types']        = 'pdf';
		$config['max_size']             = 200;
		$config['file_name']            = rand(10000, 99999); 

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('userfile'))
		{
			$error = array('error' => $this->upload->display_errors());
			redirect(base_url('remming'));
		}

		$data = array('upload_data' => $this->upload->data());
		$page = $this->getPdfData($data);
		$trein = $this->collectTreinData();
		$trein_id = $this->remming_model->setTrein($trein);
		$wagensUnchecked = $this->treinWagens($page, $trein_id);
		$wagens = $this->checkWagens($wagensUnchecked);
		$this->remming_model->setWagens($wagens);
		
		$this->edit($trein_id);
	}

	/**
	 * Genereer data van de pdf
	 * 
	 * @param $pdfUpload een pdf bestand bestaande uit bulletin en listing
	 */
	private function getPdfData($pdfUpload) 
	{
		require_once(APPPATH . '../vendor/autoload.php');
		$parser = new \Smalot\PdfParser\Parser();
		$folder = APPPATH . '../temp_uploads/';

		$file_name = $pdfUpload['upload_data']['file_name'];
		$pdf = $parser->parseFile($folder . $file_name);
		$pages  = $pdf->getPages();

		// Controle hoeveel paginas in de pdf
		if(count($pages) == 2) {
			$pageText = $pages[1]->getText();
		} elseif (count($pages) == 1) {
			$pageText = $pages[0]->getText();
		} else {
			echo 'Sorry dit is geen correcte pdf';
		}

		$seperateLine = explode("\n", $pageText);

		// verwijder tijdelijk bestand
		unlink($folder . $file_name);

		return $seperateLine;
	}

	/**
	 * Genereer de exacte trein data
	 * 
	 * @param $page De enkele pagina met de wagon data
	 * @param $trein_id van welke trein zijn de wagens
	 */
	private function treinWagens($page, $trein_id) 
	{
		$startKey = array_search("(T) HL Loco", $page)+1;
		$endKey = array_search("Rame", $page);
		$elementenVanTrein = $endKey - $startKey;
		$wagens = array_slice($page, $startKey, $elementenVanTrein);

		$keys = array('trein_id', 'wagen_plaats', 'wagen_nummer', 'wagen_lengte', 'wagen_massa_netto', 'wagen_totaal', 'wagen_frein', 'wagen_snelheid', 'wagen_handrem');
		$trein = array();

		foreach ($wagens as $wagenString) {
			$values = explode(" ", $wagenString);

			// 6 string elementen voor locomotief
			if(count($values) == 6) {
				array_unshift($values, 'HL');
				array_push($values, '0');
			}

			// normale aantal elementen voor een wagen
			if (count($values) == 8) {
				array_unshift($values, $trein_id);
				$wagen = array_combine($keys, $values);
				if($wagen['wagen_handrem'] == 'Inc./Onbek.') {
					$wagen['wagen_handrem'] = '0';
				}
				array_push($trein, $wagen);
			}
		}

		return $trein;
	}

	/**
	 * Verzamel de data voor een document
	 * 
	 * @param $type of document
	 * @retrun array of data
	 */
	private function collectTreinData()
	{
		$data = [
			'trein_created_at' => date('Y-m-d H:i:s')
		];

		return $data;
	}

	/**
	 * Controle van de wagens
	 * 
	 * @param $wagens array
	 */
	private function checkWagens($wagens)
	{
		$newWagens = array();
		foreach($wagens as $wagen) {
			if(!array_key_exists('wagen_tarra', $wagen)) {
				$wagen['wagen_tarra'] = $wagen['wagen_totaal'] - $wagen['wagen_massa_netto'];
			}

			array_push($newWagens, $wagen);
		}

		return $newWagens;
	}
}