<?php
//This file initializes the database activities and other page load events.
	include "database.php";
	$db = new database();

	if(!$db->connect()) {
		echo "Connection Error";
		exit();
	}
?>