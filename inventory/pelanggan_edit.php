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
		$pesanError[] = "<b>Address</b> should not be empty!";
	}
	if(trim($_POST['txtTelepon'])=="") {
		$pesanError[] = "<b>Telephone</b> should not be empty!";
	}
	
	$cekSql = "SELECT * FROM pelanggan WHERE nm_pelanggan='".$_POST['txtNama']."' AND NOT (nm_pelanggan='".$_POST['txtLama']."')";
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
		$mySql = "UPDATE pelanggan SET nm_pelanggan='$txtNama', nm_toko='$txtToko', alamat='$txtAlamat', no_telepon='$txtTelepon' WHERE kd_pelanggan='".$_POST['txtKode']."'";
		$myQry = mysqli_query($koneksidb, $mySql) or die ("<b>Error insert query: </b>".mysqli_error($koneksidb));
		if($myQry) {
			echo "<meta http-equiv='refresh' content='0;url=?page=Pelanggan-Data'>";
		}
	}
}

$Kode = isset($_GET['Kode']) ? $_GET['Kode'] : $_POST['txtKode'];
$mySql = "SELECT * FROM pelanggan WHERE kd_pelanggan='$Kode'";
$myQry = mysqli_query($koneksidb, $mySql) or die ("<b>Error query lisitng: </b>".mysqli_error($koneksidb));
$myData = mysqli_fetch_array($myQry);

$dataKode = $myData['kd_pelanggan'];
$dataNama = isset($_POST['txtNama']) ? $_POST['txtNama'] : $myData['nm_pelanggan'];
$dataToko = isset($_POST['txtToko']) ? $_POST['txtToko'] : $myData['nm_toko'];
$dataAlamat = isset($_POST['txtAlamat']) ? $_POST['txtAlamat'] : $myData['alamat'];
$dataTelepon = isset($_POST['txtTelepon']) ? $_POST['txtTelepon'] : $myData['no_telepon'];

?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" id="form1">
  <table width="700" cellspacing="1" cellpadding="3">
    <tr>
      <th colspan="3" scope="col"><h2>EDIT CUSTOMER DATA</h2></th>
    </tr>
    <tr>
      <td width="155" nowrap="nowrap">Code</td>
      <td width="3">:</td>
      <td width="518">
      <input name="textfield" type="text" disabled id="textfield" value="<?php echo $dataKode; ?>" size="10" maxlength="10" readonly>
      <input name="txtKode" type="hidden" id="txtKode" value="<?php echo $dataKode; ?>"></td>
    </tr>
    <tr>
      <td nowrap="nowrap">Customer Name</td>
      <td>:</td>
      <td>
      <input name="txtNama" type="text" autofocus id="txtNama" value="<?php echo $dataNama; ?>" size="80" maxlength="100">
      <input name="txtLama" type="hidden" id="txtLama" value="<?php echo $myData['nm_pelanggan']; ?>"></td>
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
      <td><input type="submit" name="btnSimpan" id="btnSimpan" value="Save"></td>
    </tr>
  </table>
</form>
