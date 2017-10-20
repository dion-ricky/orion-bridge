<?php
include_once "library/inc.seslogin.php";

if(isset($_POST['btnSimpan'])) {
	$pesanError = array();
	
	if(trim($_POST['txtBarcode'])=="") {
		$pesanError[] = "<b>Barcode</b> should not be empty!";
	}
	if(trim($_POST['txtNama'])==""){
		$pesanError[] = "<b>Name</b> should not be empty!";
	}
	if(trim($_POST['txtKeterangan'])=="") {
		$pesanError[] = "<b>Information</b> should not be empty!";
	}
	if(trim($_POST['cmbSatuan'])=="KOSONG") {
		$pesanError[] = "<b>Unit</b> should not be empty!";
	}
	if(trim($_POST['txtHargaBeli'])=="" or ! is_numeric(trim($_POST['txtHargaBeli']))) {
		$pesanError[] = "<b>Purchase Price</b> should not be empty! Must be filled with number or 0";
	}
	if(trim($_POST['txtHargaJual'])=="" or !is_numeric(trim($_POST['txtHargaJual']))) {
		$pesanError[] = "<b>Selling Price</b> should not be empty! Must be filled with number or 0";
	}
	if(trim($_POST['cmbKategori'])=="KOSONG") {
		$pesanError[] = "<b>Category</b> should not be empty!";
	}
	if(trim($_POST['cmbSupplier'])=="KOSONG") {
		$pesanError[] = "<b>Supplier</b> should not be empty!";
	}
	
	$txtBarcode = $_POST['txtBarcode'];
	$txtNama = $_POST['txtNama'];
	$txtKeterangan = $_POST['txtKeterangan'];
	$cmbSatuan = $_POST['cmbSatuan'];
	$txtHargaBeli = $_POST['txtHargaBeli'];
	$txtHargaJual = $_POST['txtHargaJual'];
	$cmbKategori = $_POST['cmbKategori'];
	$cmbSupplier = $_POST['cmbSupplier'];
	
	$cekSql = "SELECT * FROM barang WHERE nm_barang='$txtNama' AND NOT(nm_barang='".$_POST['txtLama']."')";
	$cekQry = mysqli_query($koneksidb, $cekSql) or die ("Error cek sql: ".mysqli_error($koneksidb));
	if(mysqli_num_rows($cekQry)>=1) {
		$pesanError[] = "Sorry, item data using item name: <b>'$txtNama'</b> already exists in the database! Please pick another name!";
	}
	
	if(count($pesanError)>=1) {
		echo "<div class='msgBox'>";
		echo "<span class='icon-error'></span><br><hr>";
		$nomor = 0;
		foreach($pesanError as $pesan_tampil) {
			$nomor++;
			echo "&nbsp;&nbsp; $nomor. $pesan_tampil<br>";
		}
		echo "</div><br>";
	}
	else {
		$kodeBaru = buatKode("barang", "B");
		$mySql = "UPDATE barang SET barcode='$txtBarcode', nm_barang='$txtNama', keterangan='$txtKeterangan', satuan='$cmbSatuan', harga_beli='$txtHargaBeli', harga_jual='$txtHargaJual', kd_kategori='$cmbKategori', kd_supplier='$cmbSupplier' WHERE kd_barang='".$_POST['txtKode']."'";
		$myQry = mysqli_query($koneksidb, $mySql) or die ("Error insert query: ".mysqli_error($koneksidb));
		if($myQry) {
			echo "<meta http-equiv='refresh' content='0;url=?page=Barang-Data'>";
		}
		exit;
	}
}

$Kode = isset($_GET['Kode']) ? $_GET['Kode'] : $_POST['txtKode'];
$mySql = "SELECT * FROM barang WHERE kd_barang='$Kode'";
$myQry = mysqli_query($koneksidb, $mySql) or die ("Error query listing: ".mysqli_error($koneksidb));
$myData = mysqli_fetch_array($myQry);

$dataKode = $myData['kd_barang'];
$dataBarcode = isset($_POST['txtBarcode']) ? $_POST['txtBarcode'] : $myData['barcode'];
$dataNama = isset($_POST['txtNama']) ? $_POST['txtNama'] : $myData['nm_barang'];
$dataKeterangan = isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : $myData['keterangan'];
$dataSatuan = isset($_POST['cmbSatuan']) ? $_POST['cmbSatuan'] : $myData['satuan'];
$dataHargaBeli = isset($_POST['txtHargaBeli']) ? $_POST['txtHargaBeli'] : $myData['harga_beli'];
$dataHargaJual = isset($_POST['txtHargaJual']) ? $_POST['txtHargaJual'] : $myData['harga_jual'];
$dataKategori = isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : $myData['kd_kategori'];
$dataSupplier = isset($_POST['cmbSupplier']) ? $_POST['cmbSupplier'] : $myData['kd_supplier'];

?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" id="form1">
  <table width="700" cellspacing="1" cellpadding="3">
    <tr>
      <th colspan="3" scope="col"><h2>EDIT ITEM DATA</h2></th>
    </tr>
    <tr>
      <td width="116" nowrap>Code</td>
      <td width="3">:</td>
      <td width="557">
      <input name="textfield" type="text" disabled="disabled" id="textfield" value="<?php echo $dataKode; ?>" size="10" maxlength="10" readonly>
      <input name="txtKode" type="hidden" id="txtKode" value="<?php echo $dataKode; ?>"></td>
    </tr>
    <tr>
      <td nowrap>Barcode</td>
      <td>:</td>
      <td>
      <input name="txtBarcode" type="text" id="txtBarcode" value="<?php echo $dataBarcode; ?>" size="40" maxlength="20"></td>
    </tr>
    <tr>
      <td nowrap>Item Name</td>
      <td>:</td>
      <td>
      <input name="txtNama" type="text" autofocus id="txtNama" value="<?php echo $dataNama; ?>" size="40" maxlength="30">
      <input name="txtLama" type="hidden" id="txtLama" value="<?php echo $myData['nm_barang']; ?>"></td>
    </tr>
    <tr>
      <td nowrap>Information</td>
      <td>:</td>
      <td>
      <input name="txtKeterangan" type="text" id="txtKeterangan" value="<?php echo $dataKeterangan; ?>" size="80" maxlength="200"></td>
    </tr>
    <tr>
      <td nowrap>Unit</td>
      <td>:</td>
      <td>
        <select name="cmbSatuan" id="cmbSatuan">
          <option value="KOSONG">....</option>
          <?php
		  include_once "library/inc.pilihan.php";
		  foreach ($satuan as $nilai) {
			  if ($dataSatuan == $nilai) {
				  $cek = " selected";
			  } else { $cek = ""; }
			  echo "<option value='$nilai' $cek>$nilai</option>";
		  }
		  ?>
      </select></td>
    </tr>
    <tr>
      <td nowrap>Purchase Price (Rp.)</td>
      <td>:</td>
      <td>
      <input name="txtHargaBeli" type="text" id="txtHargaBeli" value="<?php echo $dataHargaBeli; ?>" size="20" maxlength="12"></td>
    </tr>
    <tr>
      <td nowrap>Selling Price (Rp.)</td>
      <td>:</td>
      <td>
      <input name="txtHargaJual" type="text" id="txtHargaJual" value="<?php echo $dataHargaJual; ?>" size="20" maxlength="12"></td>
    </tr>
    <tr>
      <td nowrap>Category</td>
      <td>:</td>
      <td>
        <select name="cmbKategori" id="cmbKategori">
        <option value="KOSONG">....</option>
        <?php
		$mySql = "SELECT * FROM kategori ORDER BY nm_kategori";
		$myQry = mysqli_query($koneksidb, $mySql) or die ("<b>Select kategori error: </b>".mysqli_error($koneksidb));
		while ($myData = mysqli_fetch_array($myQry)) {
			if ($myData['kd_kategori']==$dataKategori) {
				$cek = " selected";
			} else { $cek = ""; }
			echo "<option value='$myData[kd_kategori]' $cek>$myData[nm_kategori]</option>";
		}
		?>
      </select></td>
    </tr>
    <tr>
      <td nowrap>Supplier</td>
      <td>:</td>
      <td>
        <select name="cmbSupplier" id="cmbSupplier">
        <option value="KOSONG">....</option>
        <?php
		$mySql = "SELECT * FROM supplier ORDER BY nm_supplier";
		$myQry = mysqli_query($koneksidb, $mySql) or die ("<b>Select supplier error: </b>".mysqli_error($koneksidb));
		while ($myData = mysqli_fetch_array($myQry)) {
			if ($myData['kd_supplier']==$dataSupplier) {
				$cek = " selected";
			} else { $cek = ""; }
			echo "<option value='$myData[kd_supplier]' $cek>$myData[nm_supplier]</option>";
		}
		?>
      </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="btnSimpan" id="btnSimpan" value="Save"></td>
    </tr>
  </table>
</form>