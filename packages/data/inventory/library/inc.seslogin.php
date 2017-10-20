<?php
if(empty($_SESSION['SES_LOGIN'])) {
	echo "<center>";
	echo "<br><br><b>Maaf akses anda ditolak!</b><br> Silahkan masuk untuk bisa mengakses sistem<br><br>";
	echo "</center>";
	if(file_exists ("login.php")) { 
	include_once "login.php";
	} else {
		include_once "../login.php";
	}
	exit;
}