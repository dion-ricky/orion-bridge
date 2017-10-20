<?php
include_once "library/inc.seslogin.php";

if(isset($_POST['btnSimpan'])) {
	
	$pesanError = array();
	
	if(trim($_POST['txtNama'])=="") {
		$pesanError[] = "<b>Name</b> should not be empty!";
	}
	if(trim($_POST['txtToko'])=="") {
		$pesanError[] = "<b>Shop</b> should not be empty!";
	}
	if(trim($_POST['txtAlamat'])=="") {
		$pesanError[] = "<b>Adress</b> should not be empty!";
	}
	if(trim($_POST['txtTelepon'])=="") {
		$pesanError[] = "<b>Telephone</b> should not be empty!";
	}
	
	$cekSql = "SELECT * FROM pelanggan WHERE nm_pelanggan='".$_POST['txtNama']."'";
	$cekQry = mysqli_query($koneksidb, $cekSql) or die ("<b>Error query check: </b>".mysqli_error($koneksidb));
	if(mysqli_num_rows($cekQry)>=1) {
		$pesanError[] = "Customer with name <b>".$_POST['txtNama']."</b> already exists in database!";
	}
	
	$txtNama = $_POST['txtNama'];
	$txtAlamat = $_POST['txtAlamat'];
	$txtToko = $_POST['txtToko'];
	$txtTelepon = $_POST['txtTelepon'];
	
	if(count($pesanError)>=1) {
		echo "<div class='msgBox'>";
		echo "<span class='icon-error'></span><br><hr>";
		$nomor = 0;
		foreach($pesanError as $pesan_tampil) {
			$nomor++;
			echo "&nbsp;&nbsp; $nomor. $pesan_tampil<br>";
		}
		echo "</div><br>";
	} else {
		$kodeBaru = buatKode("pelanggan", "P");
		$mySql = "INSERT INTO pelanggan (kd_pelanggan, nm_pelanggan, nm_toko, alamat, no_telepon) VALUES ('$kodeBaru', '$txtNama', '$txtToko', '$txtAlamat', '$txtTelepon')";
		$myQry = mysqli_query($koneksidb, $mySql) or die ("<b>Error insert query: </b>".mysqli_error($koneksidb));
		if($myQry) {
			echo "<meta http-equiv='refresh' content='0;url=?page=Pelanggan-Data'>";
		}
	}
}

$dataKode = buatKode("pelanggan","P");
$dataNama = isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
$dataToko = isset($_POST['txtToko']) ? $_POST['txtToko'] : '';
$dataAlamat = isset($_POST['txtAlamat']) ? $_POST['txtAlamat'] : '';
$dataTelepon = isset($_POST['txtTelepon']) ? $_POST['txtTelepon'] : '';


?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" id="form1">
  <table width="700" cellspacing="1" cellpadding="3">
    <tr>
      <th colspan="3" scope="col"><h2>ADD CUSTOMER DATA</h2></th>
    </tr>
    <tr>
      <td width="155" nowrap="nowrap">Code</td>
      <td width="3">:</td>
      <td width="518">
      <input name="textfield" type="text" disabled id="textfield" value="<?php echo $dataKode; ?>" size="10" maxlength="10" readonly></td>
    </tr>
    <tr>
      <td nowrap="nowrap">Customer Name</td>
      <td>:</td>
      <td>
      <input name="txtNama" type="text" autofocus id="txtNama" value="<?php echo $dataNama; ?>" size="80" maxlength="100"></td>
    </tr>
    <tr>
      <td nowrap="nowrap">Shop</td>
      <td>:</td>
      <td>
      <input name="txtToko" type="text" id="txtToko" value="<?php echo $dataToko; ?>" size="80" maxlength="100"></td>
    </tr>
    <tr>
      <td nowrap="nowrap">Address</td>
      <td>:</td>
      <td>
      <input name="txtAlamat" type="text" id="txtAlamat" value="<?php echo $dataAlamat; ?>" size="80" maxlength="100"></td>
    </tr>
    <tr>
      <td nowrap="nowrap">Telephone</td>
      <td>:</td>
      <td>
      <input name="txtTelepon" type="text" id="txtTelepon" value="<?php echo $dataTelepon; ?>" size="20" maxlength="12"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="btnSimpan" id="btnSimpan" value="Submit"></td>
    </tr>
  </table>
</form>
