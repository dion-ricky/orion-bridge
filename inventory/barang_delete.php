<?php
include_once "library/inc.seslogin.php";

if(isset($_GET['Kode'])) {
	$mySql = "DELETE FROM barang WHERE kd_barang='".$_GET['Kode']."'";
	$myQry = mysqli_query($koneksidb, $mySql);
	if($myQry){
		echo "<meta http-equiv='refresh' content='0;url=?page=Barang-Data'>";
	}
}
else {
	echo "Data yang dihapus tidak ada dalam database!";
}

?>