<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * De aanmaak documenten controller
 * 
 * @author    Casteels Pieter-Jan
 * @copyright 2020 Casteels Pieter-Jan
 * @version   0.5
 */

class Create_s627 extends CI_Controller {

	public function __construct() 
    {
        parent::__construct();
    }

	/**
	 * Hoofdpagina aanmaak S 627
	 */
	public function index()
	{
		$data = [
			'title' => 'S 627 Generator'
		];
		$this->load->view('templates/header', $data);
		$this->load->view('pages/create_s627');
		$this->load->view('templates/footer');
	}

	/**
	 * Verzamel alle data en creeër de documenten
	 */
	public function create_s627()
	{
		$sourceFiles = $this->getSourceFiles();
		if($sourceFiles != NULL)
		{
			foreach($sourceFiles as $sourceFile)
			{
				switch($sourceFile) {
					case "./assets/base/S627.pdf":
						$input = $this->collectS627Input();
					break;
					case "./assets/base/S627-bis-lvhw.pdf":
					case "./assets/base/S627-bis-wl.pdf":
						$input = $this->collectS627bInput();
					break;
					default:
						redirect(base_url('downloads'));
				}
				$this->createpdf->create($input, $sourceFile);
			}

			redirect(base_url('downloads'));
		}
		else
		{
			echo "Data was leeg";
			redirect(base_url('welcome'));
		}
	}

	/**
	 * Verzamel alle data in een array met key
	 * @return array met key
	 */
	private function collectData()
	{
		$vermoedelijkeDuur = $this->input->post('vermoedelijkeDuur');
		if(empty($vermoedelijkeDuur)) $vermoedelijkeDuur = $this->calculateDiffrence();
		
		$data = [
			'ingediendDoor' => $this->input->post('ingediendDoor'),
			'specialiteit' => $this->input->post('specialiteit'),
			'aan' => $this->input->post('aan'),
			'post' => $this->input->post('post'),
			'station' => $this->input->post('station'),
			'aanvraag' => $aanvraag = $this->input->post('aanvraag'),
			'aanvangDatum' => $this->input->post('aanvraag'),
			'aanvangDatum' => $this->input->post('aanvangDatum'),
			'aanvangUur' => $this->input->post('aanvangUur'),
			'vermoedelijkeDuur' => $this->input->post('vermoedelijkeDuur'),
			'hoeveelDagen' => $this->input->post('hoeveelDagen'),
			'vermoedelijkeDuur' => $vermoedelijkeDuur,
			'rubriek2ARMS' => $this->input->post('rubriek2ARMS'),
			'rubriek2AAndere' => $this->input->post('rubriek2AAndere'),
			'metOverdracht' => $this->input->post('metOverdracht')
		];

		return $data;
	}

    /**
     * Verzamel de data s627
     */
    private function collectS627Input() 
    {
		$input = $this->collectData();
        // $ingediendDoor = $this->input->post('ingediendDoor');
        // $specialiteit = $this->input->post('specialiteit');
        // $aan = $this->input->post('aan');
        // $post = $this->input->post('post');
        // $station = $this->input->post('station');
		// $aanvraag = $this->input->post('aanvraag');
		// $aanvangDatum = $this->input->post('aanvangDatum');
        // $aanvangUur = $this->input->post('aanvangUur');
		// $vermoedelijkeDuur = $this->input->post('vermoedelijkeDuur');
		// $hoeveelDagen = $this->input->post('hoeveelDagen');

		// if(empty($vermoedelijkeDuur)) $vermoedelijkeDuur = $this->calculateDiffrence();

        // $rubriek2ARMS = $this->input->post('rubriek2ARMS');
		// $rubriek2AAndere = $this->input->post('rubriek2AAndere');
        // $metOverdracht = $this->input->post('metOverdracht');

		// if(empty($input['metOverdracht']))
		// {
			$singleData = array(
				array(40.5, 32.3, $input['ingediendDoor']),
				array(109, 32.3, $input['specialiteit']),
				array(26, 37.5, $input['aan']),
				array(79.2, 37.5, $input['post']),
				array(109, 37.5, $input['station']),
				array(50.5, 88, $input['aanvangDatum']),
				array(78, 88, $input['aanvangUur']),
				array(125.5, 88, $input['vermoedelijkeDuur']),
				// array(174, 171.7, $input['ingediendDoor'])
			);
			if(empty($input['metOverdracht'])) array_push($singleData, array(174, 171.7, $input['ingediendDoor']));
		// }
		// else
		// {
		// 	$singleData = array(
		// 		array(40.5, 32.3, $input['ingediendDoor']),
		// 		array(109, 32.3, $specialiteit),
		// 		array(26, 37.5, $aan),
		// 		array(79.2, 37.5, $post),
		// 		array(109, 37.5, $station),
		// 		array(50.5, 88, $aanvangDatum),
		// 		array(78, 88, $aanvangUur),
		// 		array(125.5, 88, $vermoedelijkeDuur)
		// 	);
		// }
        

		$textboxData = array(
				array(19.7, 45, $input['aanvraag'], 127, 39.7, 'L', 'T', 0),
				array(36.5, 119, $input['rubriek2ARMS'], 127, 39.7, 'L', 'T', 0),
				array(36.5, 142, $input['rubriek2AAndere'], 94, 14, 'L', 'T', 0)
		);

		$checkBoxData = [
			'metOverdracht' => $input['metOverdracht'],
		];

		if(empty($input['hoeveelDagen']) || $input['hoeveelDagen'] <= 0) $input['hoeveelDagen'] = "1";
		if($input['hoeveelDagen'] >= 8) $input['hoeveelDagen'] = "7";

		$data = [
			'hoeveelDagen' => $input['hoeveelDagen'],
			'ingediendDoor' => $input['ingediendDoor'],
			'single' => $singleData,
			'textbox' => $textboxData,
			'checkbox' => $checkBoxData
		];

        return $data;
	}

	/**
     * Verzamel de data voor een s627 bis (wl of lvhw)
     */
    private function collectS627bInput() 
    {
        $ingediendDoor = $this->input->post('ingediendDoor');
        $specialiteit = $this->input->post('specialiteit');
        $aan = $this->input->post('aan');
		$aanvraag = $this->input->post('aanvraag');
		$aanvangDatum = $this->input->post('aanvangDatum');
        $aanvangUur = $this->input->post('aanvangUur');
		$vermoedelijkeDuur = $this->input->post('vermoedelijkeDuur');
		$hoeveelDagen = $this->input->post('hoeveelDagen');

		if(empty($vermoedelijkeDuur))
		{
			$vermoedelijkeDuur = $this->calculateDiffrence();
		}

        $rubriek2ARMS = $this->input->post('rubriek2ARMS');
		$rubriek2AAndere = $this->input->post('rubriek2AAndere');
        $metOverdracht = $this->input->post('metOverdracht');
        
		if(empty($metOverdracht))
		{
			$singleData = array(

				array(40.5, 32.3, $ingediendDoor),
				array(109, 32.3, $specialiteit),
				array(26, 37.5, $aan),
				array(50.5, 88, $aanvangDatum),
				array(78, 88, $aanvangUur),
				array(125.5, 88, $vermoedelijkeDuur),
				array(174, 171.7, $ingediendDoor)
			);
		}
		else
		{
			$singleData = array(

				array(40.5, 32.3, $ingediendDoor),
				array(109, 32.3, $specialiteit),
				array(26, 37.5, $aan),
				array(50.5, 88, $aanvangDatum),
				array(78, 88, $aanvangUur),
				array(125.5, 88, $vermoedelijkeDuur)
			);
		}
        

		$textboxData = array(
				array(19.7, 45, $aanvraag, 127, 39.7, 'L', 'T', 0),
				array(36.5, 119, $rubriek2ARMS, 127, 39.7, 'L', 'T', 0),
				array(36.5, 142, $rubriek2AAndere, 94, 14, 'L', 'T', 0)
		);

		$checkBoxData = [
			'metOverdracht' => $metOverdracht,
		];

		if(empty($hoeveelDagen) || $hoeveelDagen <= 0) $hoeveelDagen = "1";
		if($hoeveelDagen >= 8) $hoeveelDagen = "7";

		$data = [
			'hoeveelDagen' => $hoeveelDagen,
			'ingediendDoor' => $ingediendDoor,
			'single' => $singleData,
			'textbox' => $textboxData,
			'checkbox' => $checkBoxData
		];

        return $data;
	}
	
	/**
	 * Bereken het verschil tussen ingevoerde data
	 * @return tijdsverschil
	 */
	private function calculateDiffrence()
	{
		// Tijd calculatie
        $aanvangDatum = $this->input->post('aanvangDatum');
        $aanvangUur = $this->input->post('aanvangUur');
        $eindDatum = $this->input->post('eindDatum');
		$eindUur = $this->input->post('eindUur');


		$from = strtotime($aanvangDatum ." " . $aanvangUur);
		$to = strtotime($eindDatum . " " . $eindUur);
		$time = round(abs($to - $from) / 60,2); 

		$hours = floor($time / 60);
		$minutes = ($time % 60);

		if($hours == 0 && $minutes == 0) return " ";

		return $hours . ":" . $minutes;
	}

	/**
	 * Verzamel de source bestanden die nodig zijn
	 * @return de sourcefiles in array vorm of null
	 */
	private function getSourceFiles()
	{
		$nodigLvhw = $this->input->post('nodigLvhw');
        $nodigLvhwBis = $this->input->post('nodigLvhwBis');
        $nodigWl = $this->input->post('nodigWl');

		$sourceFile = array();
		
		if($nodigLvhwBis == TRUE) array_push($sourceFile, './assets/base/S627-bis-lvhw.pdf');
		if($nodigWl == TRUE) array_push($sourceFile, './assets/base/S627-bis-wl.pdf');
		if($nodigLvhw == TRUE) array_push($sourceFile, './assets/base/S627.pdf');

		return $sourceFile;
	}
}
