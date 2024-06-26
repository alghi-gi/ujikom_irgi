<?php 

	require 'koneksi.php';

	session_destroy();
	header('location: home.php');
	exit;
 ?>