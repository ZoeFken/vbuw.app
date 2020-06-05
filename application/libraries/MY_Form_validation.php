<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation 
{

	/**
	 * Constructor
	 */
	public function __construct($rules = array()) 
	{
		parent::__construct($rules);
	}

	/**
	 * Datum validatie
	 * 
	 * @param date, format
	 * @return controle
	 */
	public function valid_date($date, $format = 'd-m-Y') 
	{
		$d = DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) === $date;
	}

	/**
	 * Tijd validatie HH:MM (mag meer zijn dan 24h)
	 * 
	 * @param str the tijd string
	 * @return true or false
	 */
	public function valid_hours_minutes($str)
	{
		if (strrchr($str,":")) {
			list($hh, $mm) = explode(':', $str);
			if (!is_numeric($hh) || !is_numeric($mm)) return FALSE;
			elseif ((int) $mm > 59) return FALSE;
			elseif (mktime((int) $hh, (int) $mm) === FALSE) return FALSE;
			return TRUE;
		}
		else return FALSE; 
	}

	/**
	 * Validatie van tijd (max 24h)
	 * 
	 * @param str HH:MM
	 */
	public function valid_time($str)
	{
		if (strrchr($str,":")) {
			list($hh, $mm) = explode(':', $str);
			if (!is_numeric($hh) || !is_numeric($mm)) return FALSE;
			elseif ((int) $hh > 24 || (int) $mm > 59) return FALSE;
			elseif (mktime((int) $hh, (int) $mm) === FALSE) return FALSE;
			return TRUE;
		}
		else return FALSE; 
	}
}
