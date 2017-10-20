<?php
if(isset($_SESSION['SES_ADMIN'])) {
	include "barang_warning.php";
	exit;
}
if(isset($_SESSION['SES_CASHIER'])) {
	include "barang_warning.php";
	exit;
}
else {
	echo "<h2>Welcome ....!</h2>";
	echo "<b>Please <a href='?page=Login' alt='Login'>Login</a> to access the system! </b>";
	exit;
}
?>