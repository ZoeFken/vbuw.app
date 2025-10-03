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
    }

	/**
	 * Hoofdpagina download
	 */
	public function index()
	{
		$this->deleteOldFiles();
		$data = $this->getFolderData();
		// $folderData = $this->splitUpFileNames($data);

		$folderData = [
			'folderData' => $this->splitUpFileNames($data)
		];
		
		$data = [
			'title' => 'Download bestanden'
		];
		$this->load->view('templates/header', $data);
		$this->load->view('pages/downloads', $folderData);
		$this->load->view('templates/footer');

	}

	/**
	 * Krijg alle bestanden uit de download (doc) folder
	 */
	private function getFolderData()
	{
		$this->load->helper('directory');
		$map = directory_map(APPPATH . '../docs/', 1); // recursief enkel bovenste folder
		return $map;
	}

	/**
	 * Maak een array met de correcte instellingen
	 * @param $data een verzameling van namen uit de download folder
	 * @return $folderData een array van file data
	 */
	public function splitUpFileNames($data)
	{
		$data = $this->getFolderData();
		$filenames = array();

		foreach($data as $file)
		{
			$pieces = $this->multiexplode(array('.','_'), $file);
			array_pop($pieces);
			$pieces[1] = str_replace('-', ':', $pieces[1]);
			array_push($pieces, $file);
			array_push($filenames, $pieces);
		}

		return $filenames;
	}

	/**
	 * Delete files older then 2 days
	 */
	private function deleteOldFiles()
	{
		$folderName = APPPATH . '../docs/';
		if (file_exists($folderName)) {
			foreach (new DirectoryIterator($folderName) as $fileInfo) {
				if ($fileInfo->isDot()) {
				continue;
				}
				if ($fileInfo->isFile() && time() - $fileInfo->getMTime() >= 2*24*60*60) {
					unlink($fileInfo->getRealPath());
				}
			}
		}
	}

	/**
	 * Explode on multiple locations
	 */
	private function multiexplode ($delimiters,$string) 
	{
		$ready = str_replace($delimiters, $delimiters[0], $string);
		$launch = explode($delimiters[0], $ready);
		return  $launch;
	}
}
