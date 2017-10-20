<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.library.php";
include_once "../library/inc.connection.php";

date_default_timezone_set("Asia/Jakarta");

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $_SESSION['SES_NAME']; ?> / Purchase Transaction</title>
<link href="../styles/style.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php
if(isset($_GET['page'])) {
	switch($_GET['page']) {
		case 'Pembelian' :
			if(!file_exists("pembelian.php")) die ("Empty page!");
			include "pembelian.php"; break;
		case 'Pencarian-Barang' :
			if(!file_exists("search.php")) die ("Empty page!");
			include "search.php"; break;
		case 'Search' :
			if(!file_exists("search.php")) die ("Empty page!");
			include "search.php"; break;
		case 'Login-Validasi':
			include "../login_validasi.php"; break;
	}
}
else {
	include "pembelian.php";
}
?>
</body>
</html>