<?php
include_once "library/inc.seslogin.php";

if(isset($_POST['btnSimpan'])) {
	
	// Error
	$pesanError = array();
	
	if(trim($_POST['txtNama'])=="") {
		$pesanError[] = "<b>Name</b> should not be empty!";
	}
	if(trim($_POST['txtAlamat'])=="") {
		$pesanError[] = "<b>Address</b> should not be empty!";
	}
	if(trim($_POST['txtTelepon'])=="") {
		$pesanError[] = "<b>Telephone</b> should not be empty!";
	}
	
	$txtNama = $_POST['txtNama'];
	$txtAlamat = $_POST['txtAlamat'];
	$txtTelepon = $_POST['txtTelepon'];
	
	$cekSql = "SELECT * FROM supplier WHERE nm_supplier='$txtNama'";
	$cekQry = mysqli_query($koneksidb, $cekSql) or die ("<b>Error query: </b>".mysqli_error($koneksidb));
	if(mysqli_num_rows($cekQry)>=1) {
		$pesanError[] = "Supplier with name <b>".$_POST['txtNama']."</b> already exists in database!";
	}
	
	if(count($pesanError)>=1) {
		echo "<div class='msgBox'>";
		echo "<span class='icon-error'></span> <br><hr>";
		$nomor = 0;
		foreach($pesanError as $pesan_tampil) {
			$nomor++;
			echo "&nbsp;&nbsp; $nomor. $pesan_tampil<br>";
		}
		echo "</div><br>";
	} else {
		$kodeBaru = buatKode("supplier", "S");
		$mySql = "INSERT INTO supplier (kd_supplier, nm_supplier, alamat, no_telepon) VALUES ('$kodeBaru', '$txtNama', '$txtAlamat', '$txtTelepon')";
		$myQry = mysqli_query($koneksidb, $mySql) or die ("<b>Gagal query: </b>".mysqli_error($koneksidb));
		if($myQry) {
			echo "<meta http-equiv='refresh' content='0;url=?page=Supplier-Data'>";
		}
	}
}

$dataKode = buatKode("supplier", "S");
$dataNama = isset($_POST['txtNama']) ? $_POST['txtNama'] : ''; 
$dataAlamat = isset($_POST['txtAlamat']) ? $_POST['txtAlamat'] : '';
$dataTelepon = isset($_POST['txtTelepon']) ? $_POST['txtTelepon'] : '';
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" id="form1">
  <table width="700" cellspacing="1" cellpadding="3">
    <tr>
      <th colspan="3" scope="col"><h2>ADD SUPPLIER DATA</h2></th>
    </tr>
    <tr>
      <td width="152" nowrap>Code</td>
      <td width="3">:</td>
      <td width="521">
      <input name="textfield" type="text" disabled="disabled" id="textfield" value="<?php echo $dataKode; ?>" size="10" maxlength="10" readonly></td>
    </tr>
    <tr>
      <td nowrap>Name</td>
      <td>:</td>
      <td>
      <input name="txtNama" type="text" autofocus id="txtNama" value="<?php echo $dataNama; ?>" size="70" maxlength="100"></td>
    </tr>
    <tr>
      <td nowrap>Address</td>
      <td>:</td>
      <td>
      <input name="txtAlamat" type="text" id="txtAlamat" value="<?php echo $dataAlamat; ?>" size="70" maxlength="200"></td>
    </tr>
    <tr>
      <td nowrap>Telephone</td>
      <td>:</td>
      <td>
      <input name="txtTelepon" type="text" id="txtTelepon" value="<?php echo $dataTelepon; ?>" size="20" maxlength="12">
    </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="btnSimpan" id="btnSimpan" value="Submit"></td>
    </tr>
  </table>
</form>
