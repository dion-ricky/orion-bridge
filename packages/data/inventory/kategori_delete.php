<?php
include_once "library/inc.seslogin.php";

if(isset($_GET['Kode'])) {
	$mySql = "DELETE FROM kategori WHERE kd_kategori='".$_GET['Kode']."'";
	$myQry = mysqli_query($koneksidb, $mySql) or die ("<b>Error query: </b>".mysqli_error($koneksidb));
	if($myQry){
		echo "<meta http-equiv='refresh' content='0;url=?page=Kategori-Data'>";
	}
}
else {
	echo "<b>Data yang dihapus tidak ada!</b>";
}
?>