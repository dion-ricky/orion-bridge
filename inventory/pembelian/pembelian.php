<script type="text/javascript">
function HandlePopUpResult(result,sk) {
	var code = result;
	var sk = sk;
	location.replace("?kode="+code+"&sk="+sk);
}
</script>
<?php
include_once "../library/inc.seslogin.php";

if(isset($_POST['cari'])) {
	$dataSupplier = $_POST['cmbSupplier'];
	$dataKeterangan = htmlspecialchars($_POST['txtKeterangan']);
	$open = "./?page=Search&sk=$dataSupplier+$dataKeterangan";
	echo "<script>";
	echo "window.open('$open', '', 'width=800,height=350,left=100,top=25,resizeable=no')";
	echo "</script>";
}

if(isset($_GET['Act'])) {
	if(trim($_GET['Act'])=="Delete") {
		$mySql = "DELETE FROM tmp_pembelian WHERE id='".$_GET['id']."' AND kd_user='".$_SESSION['SES_LOGIN']."'";
		$myQry = mysqli_query($koneksidb, $mySql) or die ("Error delete data: ".mysqli_error($koneksidb));
	}
	if(trim($_GET['Act'])=="Success") {
		echo "<b>DATA BERHASIL DISIMPAN</b><br><br>";
	}
}

$noTransaksi = buatKode("pembelian", "NP");
$tglTransaksi = isset($_POST['cmbTanggal']) ? $_POST['cmbTanggal'] : date("Y/m/d");
$tahun = substr($tglTransaksi,0,4);
$bulan = substr($tglTransaksi,5,2);
$hari = substr($tglTransaksi,8,2);
$dataKeterangan = isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
$kodeSupplier = '';
if (isset($_GET['sk']) && substr($_GET['sk'],0,6) != "KOSONG") {
	$kodeSupplier = isset($_GET['sk']) ? $_GET['sk'] : '';
	$dataKeterangan = isset($_GET['sk']) ? substr($_GET['sk'],5) : '';
}
$dataSupplier = isset($_POST['cmbSupplier']) ? $_POST['cmbSupplier'] : substr($kodeSupplier,0,4);

if(isset($_GET['kode'])) {
$barcode = isset($_GET['kode']) ? $_GET['kode'] : '';
} else {
$barcode = isset($_POST['txtKodeBarcode']) ? $_POST['txtKodeBarcode'] : '';
}
$harga = isset($_POST['txtHargaBeli']) ? $_POST['txtHargaBeli'] : '';

if(isset($_POST['btnTambah'])) {
	$pesanError = array();
	if(trim($_POST['txtHargaBeli'])=="") {
		$pesanError[] = "<b>Purchase Price</b> must be filled out!";
	}
	if(trim($_POST['txtJumlah'])=="") {
		$pesanError[] = "<b>Item Quantity</b> must be filled out!";
	}
	
	$cmbSupplier = $_POST['cmbSupplier'];
	$txtKodeBarcode = $_POST['txtKodeBarcode'];
	$txtKodeBarcode = str_replace(",","&acute",$txtKodeBarcode);
	$txtHargaBeli = $_POST['txtHargaBeli'];
	$txtHargaBeli = str_replace("'","&acute;",$txtHargaBeli);
	$txtHargaBeli = str_replace(".","",$txtHargaBeli);
	$txtJumlah = $_POST['txtJumlah'];
	
	$cekSql = "SELECT * FROM barang WHERE kd_barang='$txtKodeBarcode' OR barcode='$txtKodeBarcode'";
	$cekQry = mysqli_query($koneksidb, $cekSql) or die ("Error checking query: ".mysqli_error($koneksidb));
	if(trim($_POST['txtKodeBarcode'])=="") {
		$pesanError[] = "<b>Item Code/Barcode</b> must be filled!";
	} elseif(mysqli_num_rows($cekQry)<1) {
		echo "<script>";
		echo "window.alert('Data with code $txtKodeBarcode does not exists in the database!')";
		echo "</script>";
		$barcode = '';
	}
	
	if(count($pesanError)>=1) {
		echo "<div class='msgBox'>";
		echo "<span class='icon-error'></span><br><hr>";
		$noPesan=0;
		foreach($pesanError as $pesan_tampil) {
			$noPesan++;
			echo "&nbsp;&nbsp; $noPesan. $pesan_tampil <br>";
		}
		echo "</div><br>";
	} else {
		$mySql = "SELECT * FROM barang WHERE kd_barang='$txtKodeBarcode' OR barcode='$txtKodeBarcode'";
		$myQry = mysqli_query($koneksidb, $mySql) or die ("Error input data: ".mysqli_error($koneksidb));
		$myRow = mysqli_fetch_array($myQry);
		$myQty = mysqli_num_rows($myQry);
		if($myQty>=1) {
			$kodeBarang = $myRow['kd_barang'];
			$tmpSql = "INSERT INTO tmp_pembelian (kd_supplier, kd_barang, harga_beli, jumlah, kd_user) VALUES ('$cmbSupplier', '$kodeBarang', '$txtHargaBeli', '$txtJumlah', '".$_SESSION['SES_LOGIN']."')";
			mysqli_query($koneksidb, $tmpSql) or die ("Error query to database tmp_pembelian: ".mysqli_error($koneksidb));
		}
	}
}

if(isset($_POST['btnSimpan'])) {
	$pesanError = array();
	
	if(trim($_POST['cmbTanggal'])=="") {
		$pesanError[] = "<b>Date of Transaction</b> must be filled out!";
	}
	if(trim($_POST['cmbSupplier'])=="KOSONG") {
		$pesanError[] = "<b>Supplier</b> should not be empty!";
	}
	$tmpSql = "SELECT COUNT(*) As qty FROM tmp_pembelian WHERE kd_user='".$_SESSION['SES_LOGIN']."'";
	$tmpQry = mysqli_query($koneksidb, $tmpSql) or die ("Error count query: ".mysqli_error($koneksidb));
	$tmpData = mysqli_fetch_array($tmpQry);
	if($tmpData['qty'] == 0) {
		$pesanError[] = "<b>Item List</b> is empty! Please input some item first!";
	}
	$tmp2Sql = "SELECT tmp_pembelian.*, supplier.*, barang.* FROM tmp_pembelian JOIN barang ON tmp_pembelian.kd_barang=barang.kd_barang JOIN supplier ON barang.kd_supplier=supplier.kd_supplier WHERE tmp_pembelian.kd_user='".$_SESSION['SES_LOGIN']."'";
	$tmp2Qry = mysqli_query($koneksidb, $tmp2Sql) or die ("Error match supplier: ".mysqli_error($koneksidb));
	$tmp2Row = mysqli_fetch_array($tmp2Qry);
	if ($tmp2Row['kd_supplier'] != $_POST['cmbSupplier']) {
		$pesanError[] =  "<b>SUPPLIER DOES NOT MATCH!</b>, item in list is <b>$tmp2Row[nm_supplier]</b> 's product.";
	}
	$cmbSupplier = $_POST['cmbSupplier'];
	$txtKeterangan = $_POST['txtKeterangan'];
	$cmbTanggal = $_POST['cmbTanggal'];
	if(count($pesanError)>=1) {
		echo "<div class='msgBox'>";
		echo "<span class='icon-error'></span><br><hr>";
		$nomor = 0;
		foreach ($pesanError as $pesan_tampil) {
			$nomor++;
			echo "&nbsp;&nbsp; $nomor. $pesan_tampil<br>";
		}
		echo "</div><br>";
	} else {
		$noTransaksi = buatKode("pembelian", "NP");
		$mySql = "INSERT INTO pembelian SET no_pembelian='$noTransaksi', tgl_pembelian='".$_POST['cmbTanggal']."', keterangan='$txtKeterangan', kd_supplier='$cmbSupplier', kd_user='".$_SESSION['SES_LOGIN']."'";
		$myQry = mysqli_query($koneksidb, $mySql) or die ("Error insert query: ".mysqli_error($koneksidb));
		$tmpSql = "SELECT * FROM tmp_pembelian WHERE kd_user='".$_SESSION['SES_LOGIN']."'";
		$tmpQry = mysqli_query($koneksidb, $tmpSql) or die ("Error select tmp query: ".mysqli_error($koneksidb));
		while ($tmpData = mysqli_fetch_array($tmpQry)) {
			$dataKode = $tmpData['kd_barang'];
			$dataHarga = $tmpData['harga_beli'];
			$dataJumlah = $tmpData['jumlah'];
			
			$itemSql = "INSERT INTO pembelian_item SET no_pembelian='$noTransaksi', kd_barang='$dataKode', harga_beli='$dataHarga', jumlah='$dataJumlah'";
			$itemQry = mysqli_query($koneksidb, $itemSql) or die ("Fail insert into pembelian_item: ".mysqli_error($koneksidb));
			$stokSql = "UPDATE barang SET stok=stok + $dataJumlah, harga_beli='$dataHarga' WHERE kd_barang='$dataKode'";
			$stokQry = mysqli_query($koneksidb, $stokSql) or die ("Error stok query: ".mysqli_error($koneksidb));
		}
		$hapusSql = "DELETE FROM tmp_pembelian WHERE kd_user='".$_SESSION['SES_LOGIN']."'";
		mysqli_query($koneksidb, $hapusSql) or die ("Error delete query: ".mysqli_error($koneksidb));
		echo "<script>";
		echo "window.open('../cetak/pembelian_cetak.php?noNota=$noTransaksi', '', 'width=630,height=330,left=100,top=25')";
		echo "</script>";
	}
}
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="700" cellspacing="1" cellpadding="3">
    <tr>
      <td colspan="3"><h1>PURCHASE TRANSACTION</h1></td>
    </tr>
    <tr>
      <td width="163" nowrap="nowrap" bgcolor="#CCCCCC">TRANSACTION DATA</td>
      <td width="3" bgcolor="#CCCCCC">&nbsp;</td>
      <td width="508"></td>
    </tr>
    <tr>
      <td width="163" nowrap="nowrap"><strong>Transaction No.</strong></td>
      <td>:</td>
      <td>
      <input name="txtNomor" type="text" disabled id="txtNomor" value="<?php echo $noTransaksi; ?>" size="10" maxlength="10" readonly></td>
    </tr>
    <tr>
      <td width="163" nowrap="nowrap"><strong>Date of Transaction</strong></td>
      <td>:</td>
      <td>
      <input type="date" name="cmbTanggal" id="cmbTanggal" value="<?php echo $tahun; ?>-<?php echo $bulan; ?>-<?php echo $hari; ?>"></td>
    </tr>
    <tr>
      <td width="163" nowrap="nowrap"><strong>Supplier</strong></td>
      <td>:</td>
      <td>
        <select name="cmbSupplier" id="cmbSupplier">
        <option value="KOSONG">....</option>
        <?php
		$mySql = "SELECT * FROM supplier ORDER BY kd_supplier";
		$myQry = mysqli_query($koneksidb, $mySql) or die ("Gagal query supplier: ".mysqli_error($koneksidb));
		while ($myData = mysqli_fetch_array($myQry)) {
			$a = "a";
			if($dataSupplier == $myData['kd_supplier']) {
				echo $dataSupplier;
				$cek = " selected";
			} else { $cek = ""; }
			echo "<option value='$myData[kd_supplier]' $cek>[$myData[kd_supplier]] $myData[nm_supplier]</option>";
		}
		?>
      </select></td>
    </tr>
    <tr>
      <td width="163" nowrap="nowrap"><strong>Information</strong></td>
      <td>:</td>
      <td>
      <input name="txtKeterangan" type="text" id="txtKeterangan" value="<?php echo $dataKeterangan; ?>" size="60" maxlength="100"></td>
    </tr>
    <tr>
      <td width="163">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="163" nowrap="nowrap" bgcolor="#CCCCCC">ITEMS INPUT</td>
      <td bgcolor="#CCCCCC">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="163" nowrap="nowrap"><strong>Item Code/Barcode</strong></td>
      <td>:</td>
      <td>
      <input name="txtKodeBarcode" type="text" id="txtKodeBarcode" value="<?php echo $barcode; ?>" size="29" maxlength="20">
      <input type="submit" name="cari" id="cari" value="Search">
      </a></td>
    </tr>
    <tr>
      <td width="163" nowrap="nowrap"><strong>Purchase Price</strong></td>
      <td>:</td>
      <td>
      <input name="txtHargaBeli" type="text" id="txtHargaBeli" value="<?php echo $harga; ?>" size="20" maxlength="12">
      <b>Qty</b>
      <label for="txtJumlah"><b>:</b></label>
      <input name="txtJumlah" type="number" id="txtJumlah" max="999" min="1" step="1" value="1" size="5" maxlength="4">
<input type="submit" name="btnTambah" id="btnTambah" value="Add"></td>
    </tr>
    <tr>
      <td width="163">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="163">&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="btnSimpan" id="btnSimpan" value="Save"></td>
    </tr>
  </table>
  <table width="700" cellspacing="1" cellpadding="3">
    <tr>
      <td colspan="7" align="center"><h3>ITEMS LIST</h3></td>
    </tr>
    <tr>
      <td width="24" align="center" bgcolor="#CCCCCC">No.</td>
      <td width="65" align="center" bgcolor="#CCCCCC">Code</td>
      <td width="270" align="center" bgcolor="#CCCCCC">Item Name</td>
      <td width="86" align="center" bgcolor="#CCCCCC">Price</td>
      <td width="70" align="center" bgcolor="#CCCCCC">Qty</td>
      <td width="81" align="center" bgcolor="#CCCCCC">Subtotal</td>
      <td width="52" align="center" bgcolor="#CCCCCC">&nbsp;</td>
    </tr>
    <?php
	$tmpSql = "SELECT tmp_pembelian.*, barang.nm_barang FROM tmp_pembelian, barang WHERE tmp_pembelian.kd_barang=barang.kd_barang AND tmp_pembelian.kd_user='".$_SESSION['SES_LOGIN']."'";
	$tmpQry = mysqli_query($koneksidb, $tmpSql) or die ("Error query: ".mysqli_error($koneksidb));
	$nomor = 0; $subTotal = 0; $totalBelanja = 0; $jumlahBarang = 0;
	while($tmpData = mysqli_fetch_array($tmpQry)) {
		$id = $tmpData['id'];
		$jumlahBarang = $jumlahBarang + $tmpData['jumlah'];
		$subTotal = $tmpData['harga_beli'] * $tmpData['jumlah'];
		$totalBelanja = $totalBelanja + $subTotal;
		$nomor++
	?>
    <tr>
      <td align="center"><?php echo $nomor; ?></td>
      <td><?php echo $tmpData['kd_barang']; ?></td>
      <td><?php echo $tmpData['nm_barang']; ?></td>
      <td><?php echo format_angka($tmpData['harga_beli']); ?></td>
      <td><?php echo $tmpData['jumlah']; ?></td>
      <td><?php echo format_angka($subTotal); ?></td>
      <td align="center"><a href="?Act=Delete&id=<?php echo $id; ?>" target="_self">Delete</a></td>
    </tr>
    <?php
	}
	?>
    <tr>
      <td colspan="4" align="right" bgcolor="#CCCCCC">GRAND TOTAL</td>
      <td bgcolor="#CCCCCC"><?php echo $jumlahBarang; ?></td>
      <td align="right" bgcolor="#CCCCCC"><strong>Rp. <?php echo format_angka($totalBelanja); ?></strong></td>
      <td bgcolor="#CCCCCC">&nbsp;</td>
    </tr>
  </table>
</form>
