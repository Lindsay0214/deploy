<?php
	$server_name = 'ubuntu';
	$username = 'root';
	$password = '';
	$db_name = 'ubuntu';

	$conn = new mysqli($server_name, $username, $password, $db_name);
	if ($conn->connect_error) {
		die("connection failed: " . $conn->connect_error);
	}

	$conn->query('SET NAMES UTF8');
	$conn->query('SET time_zone = "+8:00"');
?>


<!-- mtr04group3 -->
<!-- Lidemymtr04group3 -->