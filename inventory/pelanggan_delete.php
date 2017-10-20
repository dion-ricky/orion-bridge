<?php
include_once "library/inc.seslogin.php";

if(isset($_GET['Kode'])) {
	$mySql = "DELETE FROM pelanggan WHERE kd_pelanggan='".$_GET['Kode']."'";
	$myQry = mysqli_query($koneksidb, $mySql) or die ("<b>Error delete: </b>".mysqli_error($koneksidb));
	if($myQry){
		echo "<meta http-equiv='refresh' content='0;url=?page=Pelanggan-Data'>";
	}
}
else {
	echo "Data tidak tersedia!";
}

?>