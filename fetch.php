<?php
	include '/core/user.php';

	$user = new users();

	print_r($user->fetch());
?>