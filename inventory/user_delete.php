<?php
include_once "library/inc.seslogin.php";

if(isset($_GET['Kode'])) {
	$mySql = "DELETE FROM user WHERE kd_user='".$_GET['Kode']."'";
	$myQry = mysqli_query($koneksidb, $mySql) or die ("Error delete: ".mysqli_error($koneksidb));
	if($myQry) {
		echo "<meta http-equiv='refresh' content='0;url=?page=User-Data'>";
	}
}
else {
	echo "Data tidak ditemukan!";
}
?>