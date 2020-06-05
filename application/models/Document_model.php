<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Het documenten model voor de data te behandelen
 * 
 * @author    Casteels Pieter-Jan
 * @copyright 2020 Casteels Pieter-Jan
 * @version   0.5
 */

class Document_model extends CI_Model
{
    public function __construct() 
    {
		parent::__construct();
	}

	/*****************
	 *   Documenten  *
	 ****************/

	/**
	 * Creeer een document in de database
	 * 
	 * @param documentData
	 * @return insert_id
	 */
	public function setDocument($documentData)
	{
		$this->db->insert('documents', $documentData);
        return $this->db->insert_id();
	}

	/**
	 * Krijg de laatste aangemaakte documenten terug 
	 * 
	 * @param limit aantal of standaard 25
	 * @return array van documenten
	 */
	public function getLatestDocuments($limit = 25)
	{
		$this->db->select('documents.*, users.first_name, users.last_name');
		$this->db->from('documents');
		$this->db->join('users', 'documents.user_id = users.id');
		$this->db->limit($limit);
		
		$query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : NULL;
	}

	/**
	 * Krijg de laatste aangemaakte documenten terug 
	 * 
	 * @param limit aantal of standaard 25
	 * @return array van documenten
	 */
	public function getLatestUserDocuments($limit = 25, $user_id)
	{
		if(!empty($user_id))
		{
			$this->db->select('documents.*, users.first_name, users.last_name');
			$this->db->from('documents');
			$this->db->join('users', 'documents.user_id = users.id');
			$this->db->where('users.id', $user_id);
			$this->db->limit($limit);
			
			$query = $this->db->get();
	
			return ($query->num_rows() > 0) ? $query->result_array() : NULL;
		}
		return NULL;
	}

	/**
	 * Krijg de alle documenten van een gebruiker
	 * 
	 * @param user_id
	 * @return array van documenten
	 */
	public function getAllUsersDocuments($user_id)
	{
		$this->db->select('*');
		$this->db->from('documents');
		$this->db->where('user_id', $user_id);
		
		$query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : NULL;
	}

	/**
	 * Krijg een specifiek document terug
	 * 
	 * @param document_id
	 * @return array van een specifiek document
	 */
	public function getDocument($document_id)
	{
		$this->db->select('*');
		$this->db->from('documents');
		$this->db->where('document_id', $document_id);
		
		$query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->row_array() : FALSE;
	}

	/**
	 * Krijg een specifiek document aanmaker terug
	 * 
	 * @param document_id
	 * @return array van een specifiek gebruiker
	 */
	public function getDocumentCreatorName($document_id)
	{
		$this->db->select('users.first_name, users.last_name');
		$this->db->from('documents');
		$this->db->join('users', 'documents.user_id = users.id');
		$this->db->where('document_id', $document_id);
		
		$query = $this->db->get();

		if($query->num_rows() > 0)
		{
			$data = $query->row_array();
			return $data['first_name'] . '-' . $data['last_name'];
		}
		else return ' ';
	}

	/**
	 * Krijg alle documenten van een specifieke gebruiker
	 * 
	 * @param user_id
	 * @return array van een gebruikers documenten
	 */
	public function getUserDocuments($user_id)
	{
		$this->db->select('*');
		$this->db->from('documents');
		$this->db->where('user_id', $user_id);
		
		$query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->row_array() : FALSE;
	}

	/**
	 * Wie is de eigenaar van een document
	 * 
	 * @param document_id
	 */
	public function ownerDocument($document_id)
	{
		$this->db->select('user_id');
		$this->db->from('documents');
		$this->db->where('document_id', $document_id);
		
		$query = $this->db->get();

        return ($query->num_rows() > 0) ? (int) $query->row()->user_id : FALSE;
	}

	/**
     * Kijk of een gebruiker de eigenaar is van een document
	 * 
     * @param $document_id
     * @param $user_id
     * @return true of false
     */
    public function isUserOwnerDocument($document_id, $user_id)
    {
        $this->db->select('user_id');
        $this->db->from('documents');
        $this->db->where('user_id', $user_id);
        $this->db->where('document_id', $document_id);

        $query = $this->db->get();

        return ($query->num_rows() > 0) ? TRUE : FALSE;
	}
	
	/**
	 * Verwijder het document
	 * 
	 * @param document_id
	 * @return success or fail
	 */
	public function deleteDocument($document_id)
	{
		$this->db->where('document_id', $document_id);
        return $this->db->delete('documents');
	}

	/*****************
	 *     S627      *
	 ****************/

	/**
	 * Schrijf de velden weg naar de db
	 * 
	 * @param s627enInputData om weg te schrijven naar de db
	 * @return success or fail
	 */
	public function setS627enInputData($s627enInputData)
	{
		return $this->db->insert('s627en_input', $s627enInputData);
	}

	/**
	 * Verwijder de velden
	 * 
	 * @param document_id
	 * @return success or fail
	 */
	public function deleteS627enInputData($document_id)
	{
		$this->db->where('document_id', $document_id);
        return $this->db->delete('s627en_input');
	}

	/**
	 * Schrijf de velden weg naar de db
	 * 
	 * @param s627enInputData om weg te schrijven naar de db
	 * @return success or fail
	 */
	public function updateS627enInputData($s627enInputData)
	{
		$this->db->where('document_id', $s627enInputData['document_id']);
		$this->db->where('s627_input_name', $s627enInputData['s627_input_name']);
        return $this->db->update('s627en_input', $s627enInputData);
	}

	/**
	 * Krijg velden terug van een specifiek document
	 * 
	 * @param document_id
	 * @return array van een specifiek document
	 */
	public function getEditDocumentS627en($document_id)
	{
		$this->db->select('s627en_input.s627_input_name, s627en_input.s627_input_input');
		$this->db->from('s627en_input');
		$this->db->join('s627en', 's627en_input.s627_input_name = s627en.s627_name');
		$this->db->where('document_id', $document_id);
		
		$query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
	}

	/**
	 * Krijg velden terug van een specifiek document
	 * 
	 * @param document_id
	 * @return array van een specifiek document
	 */
	public function getDocumentS627en($document_id)
	{
		$this->db->select('*');
		$this->db->from('s627en_input');
		$this->db->join('s627en', 's627en_input.s627_input_name = s627en.s627_name');
		$this->db->where('document_id', $document_id);
		
		$query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
	}

	/*****************
	 *      S460     *
	 ****************/

	/**
	 * Schrijf de velden weg naar de db
	 * 
	 * @param s460enInputData om weg te schrijven naar de db
	 * @return success or fail
	 */
	public function setS460enInputData($s460enInputData)
	{
		return $this->db->insert('s460en_input', $s460enInputData);
	}

	/**
	 * Verwijder de velden
	 * 
	 * @param document_id
	 * @return success or fail
	 */
	public function deleteS460enInputData($document_id)
	{
		$this->db->where('document_id', $document_id);
        return $this->db->delete('s460en_input');
	}

	/**
	 * Krijg de velden terug voor een s460 document
	 */
	public function getDocumentS460en($document_id)
	{
		$this->db->select('*');
		$this->db->from('s460en_input');
		$this->db->where('document_id', $document_id);
		
		$query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
	}

	/**
	 * Krijg de velden terug voor een s460 document
	 */
	public function getS460Locaties()
	{
		$this->db->select('*');
		$this->db->from('s460en');
		
		$query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
	}

	/**
	 * Krijg velden terug van een specifiek document
	 * 
	 * @param document_id
	 * @return array van een specifiek document
	 */
	public function getEditDocumentS460en($document_id)
	{
		$this->db->select('*');
		$this->db->from('s460en_input');
		$this->db->where('document_id', $document_id);
		
		$query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
	}

	/*****************
	 *    Verdeler   *
	 ****************/

	/**
	 * Schrijf de velden weg naar de db
	 * 
	 * @param verdelerData
	 * @return success or fail
	 */
	public function setVerdelersData($verdelersData)
	{
		return $this->db->insert('verdelers', $verdelersData);
	}

	/**
	 * Schrijf de velden weg naar de db
	 * 
	 * @param verdelerData
	 * @return success or fail
	 */
	public function updateVerdelersData($verdelersData)
	{
		$this->db->where('document_id', $verdelersData['document_id']);
        return $this->db->update('verdelers', $verdelersData);
	}

	/**
	 * Krijg verdeleren terug van een specifiek document
	 * 
	 * @param document_id
	 * @return array van een specifiek document
	 */
	public function getDocumentVerdelers($document_id)
	{
		$this->db->select('*');
		$this->db->from('verdelers');
		$this->db->where('document_id', $document_id);
		
		$query = $this->db->get();

        return ($query->num_rows() > 0) ? $query->row_array() : NULL;
	}

	/**
	 * Verwijder de velden
	 * 
	 * @param document_id
	 * @return success or fail
	 */
	public function deleteVerdelersData($document_id)
	{
		$this->db->where('document_id', $document_id);
        return $this->db->delete('verdelers');
	}
}	
