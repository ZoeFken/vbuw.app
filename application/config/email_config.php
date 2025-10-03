<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * De email configuratie
 * 
 * @author    Casteels Pieter-Jan
 * @copyright 2020 Casteels Pieter-Jan
 * @version   1
 */

$config['email_address'] = 'no-reply@vbuw.be';
$config['owner']         = 'Pieter-Jan Casteels';
$config['email_owner']   = 'no-reply@vbuw.be';
$config['charset']       = 'utf-8';
$config['mailtype']      = 'html';
$config['protocol']      = 'smtp';
$config['smtp_host']     = 'mail.vbuw.be';
$config['smtp_crypto']   = 'tls';
$config['smtp_port']     = '587'; // 465, 25, 587
$config['smtp_timeout']  = '7';
$config['smtp_user']     = 'no-reply@vbuw.be';
$config['smtp_pass']     = '5z3TD3xpTmYo';
$config['validation']    = TRUE;