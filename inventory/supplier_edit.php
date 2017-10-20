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
	
	$cekSql = "SELECT * FROM supplier WHERE nm_supplier='$txtNama' AND NOT (nm_supplier='".$_POST['txtLama']."')";
	$cekQry = mysqli_query($koneksidb, $cekSql) or die ("<b>Error query(01): </b>".mysqli_error($koneksidb));
	if(mysqli_num_rows($cekQry)>=1) {
		$pesanError[] = "Supplier with name '".$_POST['txtNama']."' already exists in database!";
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
		$mySql = "UPDATE supplier SET nm_supplier='$txtNama', alamat='$txtAlamat', no_telepon='$txtTelepon' WHERE kd_supplier='".$_POST['txtKode']."' ";
		$myQry = mysqli_query($koneksidb, $mySql) or die ("<b>Gagal query: </b>".mysqli_error($koneksidb));
		if($myQry) {
			echo "<meta http-equiv='refresh' content='0;url=?page=Supplier-Data'>";
		}
	}
}
$Kode = isset($_GET['Kode']) ? $_GET['Kode'] : $_POST['txtKode'];
$mySql = "SELECT * FROM supplier WHERE kd_supplier='$Kode'";
$myQry = mysqli_query($koneksidb, $mySql) or die ("<b>Error query: </b>".mysqli_error($koneksidb));
$myData = mysqli_fetch_array($myQry);

$dataKode = $myData['kd_supplier'];
$dataNama = isset($_POST['txtNama']) ? $_POST['txtNama'] : $myData['nm_supplier']; 
$dataAlamat = isset($_POST['txtAlamat']) ? $_POST['txtAlamat'] : $myData['alamat'];
$dataTelepon = isset($_POST['txtTelepon']) ? $_POST['txtTelepon'] : $myData['no_telepon'];
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" id="form1">
  <table width="700" cellspacing="1" cellpadding="3">
    <tr>
      <th colspan="3" scope="col"><h2>EDIT SUPPLIER DATA</h2></th>
    </tr>
    <tr>
      <td width="152" nowrap>Code</td>
      <td width="3">:</td>
      <td width="521">
      <input name="textfield" type="text" disabled="disabled" id="textfield" value="<?php echo $dataKode; ?>" size="10" maxlength="10" readonly>
      <input name="txtKode" type="hidden" id="txtKode" value="<?php echo $dataKode; ?>"></td>
    </tr>
    <tr>
      <td nowrap>Name</td>
      <td>:</td>
      <td>
      <input name="txtNama" type="text" autofocus id="txtNama" value="<?php echo $dataNama; ?>" size="70" maxlength="100">
      <input name="txtLama" type="hidden" id="txtLama" value="<?php echo $myData['nm_supplier']; ?>"></td>
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
      <input name="txtTelepon" type="text" id="txtTelepon" value="<?php echo $dataTelepon; ?>" size="20" maxlength="12"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="btnSimpan" id="btnSimpan" value="Save"></td>
    </tr>
  </table>
</form>
