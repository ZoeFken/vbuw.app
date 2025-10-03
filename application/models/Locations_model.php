<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Het locations model voor de data te behandelen
 * 
 * @author    Casteels Pieter-Jan
 * @copyright 2020 Casteels Pieter-Jan
 * @version   0.5
 */

class Locations_model extends CI_Model
{
    public function __construct() 
    {
		parent::__construct();
	}

    /**
     * Get all the locations in one data file
     * 
     * @return data of locations
     */
    public function getLocations() 
    {
        $fileNames = $this->getAllFileNames();
        $locationsCollection = $this->getLocationsCollections($fileNames);
        
        return $locationsCollection;
    }

    /**
     * Get the file names of the directory
     * 
     * @return list of directory files
     */
    public function getAllFileNames()
    
    {
        $dir = DOCROOT . 'public_html/assets/locaties/';
        $files = scandir($dir);
        $allFiles = array();
        
        foreach($files as $file) 
        {
          // Ignore the current directory and parent directory entries
          if ($file == '.' || $file == '..') {
            continue;
          }
          
          array_push($allFiles, $file);
        }

        return $allFiles;
    }

    /**
     * Get all the associated locations from the list file
     * 
     * @param fileNames
     * @return collection of filename + locations
     */
    public function getLocationsCollections($fileNames)
    {
        $locations = array();

        foreach($fileNames as $fileName)
        {
            $array = array();

            $kmlFile = DOCROOT . 'public_html/assets/locaties/' . $fileName;
            $kml = simplexml_load_file($kmlFile);
            $json = json_encode($kml);
            $kmlArray = json_decode($json, true);
            $docuemntArray = $kmlArray['Document'];
            $newArray = array_values($docuemntArray["Placemark"]);

            $array[substr($fileName, 0, strpos($fileName, "."))] = $newArray;

            array_push($locations, $array);

            // return $newArray;

            // foreach ($newArray as $entry) 
            // {
            //     echo '<pre>';
            //     var_dump($entry['name']);
            //     var_dump(trim($entry['Point']['coordinates']));
            //     echo '</pre>';
            // }
        }

        return $locations;

        // // Build the Waze link URL
        // $baseUrl = 'https://www.waze.com/ul?';
        // $params = array(
        //     'll' => $startPoint,
        //     'navigate' => 'yes',
        //     'llf' => $endPoint,
        //     'z' => 10,
        //     'from_latlng' => $startPoint,
        //     'to_latlng' => $endPoint,
        // );
        // $wazeLink = $baseUrl . http_build_query($params);

        // // Output the Waze link
        // echo '<a href="' . htmlspecialchars($wazeLink) . '">Navigate with Waze</a>';
    }
}