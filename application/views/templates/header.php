<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $title ?></title>
	<link href="<?php echo base_url('assets/css/main.css'); ?>" rel="stylesheet">
	<script src="<?php echo base_url('assets/js/jquery-3.4.1.min.js'); ?>"></script>
	<link rel="icon" href="<?php echo base_url('assets/ico/favicon.ico'); ?>">
</head>
<body class="bg-dark navbar-offset">
<main class="container bg-dark">
<nav><?php $this->load->view('templates/nav'); ?></nav>
<div class="alert alert-warning mt-3 mb-0 text-dark" role="alert">
	<strong>Let op:</strong> deze site gaat midden januari offline. Gebruik <a class="alert-link" href="https://vbuw-docs.pages.dev/" target="_blank" rel="noopener noreferrer">vbuw-docs.pages.dev</a> om verder te gaan; daar is geen login nodig en bestaande gemaakte documenten worden er niet opgeslagen.
</div>
<section class="container main-section">
