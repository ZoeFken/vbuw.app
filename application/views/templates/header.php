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
<body class="bg-dark">
<main class="container bg-dark">
<nav><?php $this->load->view('templates/nav'); ?></nav>
<section class="container main-section">
