<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Het remming model voor de data te behandelen
 * 
 * @author    Casteels Pieter-Jan
 * @copyright 2020 Casteels Pieter-Jan
 * @version   0.5
 */

class Remming_model extends CI_Model
{
    public function __construct() 
    {
		parent::__construct();
	}

    /**
     * Zet de trein data
     * 
     * @param $trein
     */
    public function setTrein($trein)
    {
        $this->db->insert('treinen', $trein);
        return $this->db->insert_id();
    }

    /**
     * Zet enkele wagens van een trein
     * 
     * @param $data wagons data
     */
    public function setWagens($wagens)
    {
        foreach($wagens as $wagen)
        {
            $this->setWagen($wagen);
        }
    }

    /**
     * Zet een enkele wagen
     * 
     * @param $wagen
     */
    public function setWagen($wagen)
    {
        $this->db->insert('wagens', $wagen);
    }

    /**
     * Krijg een enkele trein terug
     * 
     * @param $trein_id
     * @return een trein
     */
    public function getTrein($trein_id)
    {
        $this->db->select('*');
		$this->db->from('treinen');
		$this->db->where('trein_id', $trein_id);
		
		$query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->row_array() : NULL;
    }

    /**
     * Krijg een alle wagens van een trein
     * 
     * @param $trein_id
     * @return Alle wagens van een trein
     */
    public function getWagens($trein_id)
    {
        $this->db->select('*');
		$this->db->from('wagens');
		$this->db->where('trein_id', $trein_id);
		
		$query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : NULL;
    }

    /**
     * Krijg de volledige trein terug
     * 
     * @param $trein_id
     * @return volledige trein
     */
    public function getFullTrein($trein_id) 
    {
        $trein = $this->getTrein($trein_id);
        $wagens = $this->getWagens($trein_id);

        $data['trein'] = $trein;
        $data['wagens'] = $wagens;

        return $data;
    }
}