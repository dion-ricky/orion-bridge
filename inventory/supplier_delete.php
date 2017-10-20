<?php
include_once "library/inc.seslogin.php";

if(isset($_GET['Kode'])) {
	$mySql = "DELETE FROM supplier WHERE kd_supplier='".$_GET['Kode']."'";
	$myQry = mysqli_query($koneksidb, $mySql) or die ("<b>Error query: </b>".mysqli_error($koneksidb));
	if($myQry) {
		echo "<meta http-equiv='refresh' content='0;url=?page=Supplier-Data'>";
	}
}
else {
	echo "<b>Data tidak ditemukan!</b>";
}
?>