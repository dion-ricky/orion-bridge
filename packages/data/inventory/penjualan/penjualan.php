<script type="text/javascript">
function HandlePopUpResult(result,pk) {
	var code = result;
	var pk = pk;
	location.replace("?kode="+code+"&pk="+pk);
}
</script>
<?php
include_once "../library/inc.seslogin.php";

if(isset($_POST['cari'])) {
	$dataPelanggan = $_POST['cmbPelanggan'];
	$dataKeterangan = htmlspecialchars($_POST['txtKeterangan']);
	echo "<script>";
	$open = "./?page=Search&pk=$dataPelanggan+$dataKeterangan";
	echo "window.open('$open', '', 'width=800,height=350,left=100,top=25,resizeable=no')";
	echo "</script>";
}

if(isset($_GET['Act'])) {
	if(trim($_GET['Act'])=="Delete") {
		$deleteSql = "DELETE FROM tmp_penjualan WHERE id='".$_GET['id']."' AND kd_user='".$_SESSION['SES_LOGIN']."'";
		mysqli_query($koneksidb, $deleteSql) or die ("Error delete sql: ".mysqli_error($koneksidb));
	}
	if(trim($_GET['Act'])=="Success") {
		echo "<b>DATA BERHASIL DISIMPAN</b><br><br>";
	}
}

$noTransaksi = buatKode("penjualan", "JL");
$tglTransaksi = isset($_POST['cmbTanggal']) ? $_POST['cmbTanggal'] : date('Y-m-d');
$tahun = substr($tglTransaksi,0,4);
$bulan = substr($tglTransaksi,5,2);
$hari = substr($tglTransaksi,8,2);
$dataPelanggan = isset($_POST['cmbPelanggan']) ? $_POST['cmbPelanggan'] : 'P0001';
$dataPelanggan = isset($_GET['pk']) ? substr($_GET['pk'],0,5) : 'P0001';
$dataKeterangan = isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
$dataKeterangan = isset ($_GET['pk']) ? substr($_GET['pk'],6) : '';
$dataUangBayar = isset($_POST['txtUangBayar']) ? $_POST['txtUangBayar'] : '';
if(isset($_GET['kode'])) {
	$barcode = $_GET['kode'];
} else {
	$barcode = isset($_POST['txtKodeBarcode']) ? $_POST['txtKodeBarcode'] : '';
}
$jumlah = isset($_POST['txtJumlah']) ? $_POST['txtJumlah'] : 1;
$maxJumlah = 9999;

// btnTambah click
if(isset($_POST['btnTambah'])) {
	$jumlah = 1;
	$barcode = '';
	$pesanError = array();
	
	if(trim($_POST['txtKodeBarcode'])=="") {
		$pesanError[] = "<b>Code/Barcode</b> must be filled out!";
	}
	if(trim($_POST['txtJumlah'])=="") {
		$pesanError[] = "<b>Item Quantity</b> must be filled out!";
	}
	if(trim($_POST['txtDiskon'])=="" || !is_numeric(trim($_POST['txtDiskon']))) {
		$pesanError[] = "<b>Discount</b> must be filled with numbers or 0!";
	}
	
	$txtKodeBarcode = $_POST['txtKodeBarcode'];
	$txtKodeBarcode = str_replace("'","&acute;",$txtKodeBarcode);
	$txtJumlah = $_POST['txtJumlah'];
	$txtDiskon = $_POST['txtDiskon'];
	
	$rowSql = "SELECT * FROM barang WHERE kd_barang='$txtKodeBarcode' OR barcode='$txtKodeBarcode'";
	$rowQry = mysqli_query($koneksidb, $rowSql) or die ("Error check availability: ".mysqli_error($koneksidb));
	if(trim($_POST['txtKodeBarcode']) != "") {
	if(mysqli_num_rows($rowQry)>=1) {
	$cekSql = "SELECT * FROM barang WHERE kd_barang='$txtKodeBarcode' OR barcode='$txtKodeBarcode'";
	$cekQry = mysqli_query($koneksidb, $cekSql) or die ("Error query check stok: ".mysqli_error($koneksidb));
	$cekRow = mysqli_fetch_array($cekQry);
	if($cekRow['stok'] < $txtJumlah) {
		if($cekRow['stok'] == 0) {
			$barcode = $_POST['txtKodeBarcode'];
			$pesanError[] = "Item sold out!";
		} else {
		$barcode = $_POST['txtKodeBarcode'];
		$maxJumlah = $cekRow['stok'];
		$pesanError[] = "Item stock with item's code <b>$txtKodeBarcode</b> has <b>$cekRow[stok] $cekRow[satuan]</b> left!";
		}
	}
	} // if check availibility
		else {
		$pesanError[] = "<b>Item</b> with code <b>$txtKodeBarcode</b> does not exist in the database!<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; You can use <b>Search</b> if you are having problems";
	}
	} // if trim

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
		$mySql = "SELECT * FROM barang WHERE kd_barang='$txtKodeBarcode' OR barcode='$txtKodeBarcode'";
		$myQry = mysqli_query($koneksidb, $mySql) or die ("Error query input to database: ".mysqli_error($koneksidb));
		$myRow = mysqli_fetch_array($myQry);
		if (mysqli_num_rows($myQry) >= 1) {
			$kodeBarang = $myRow['kd_barang'];
			$tmpSql = "INSERT INTO tmp_penjualan SET kd_barang='$kodeBarang', jumlah='$txtJumlah', diskon='$txtDiskon', kd_user='".$_SESSION['SES_LOGIN']."'";
			mysqli_query($koneksidb, $tmpSql) or die ("Error insert to tmp_penjualan: ".mysqli_error($koneksidb));
		}
	}
}

if(isset($_POST['btnSimpan'])) {
	$pesanError = array();
	
	if(trim($_POST['cmbTanggal'])=="") {
		$pesanError[] = "<b>Date of Transaction</b> must be filled out!";
	}
	if(trim($_POST['cmbPelanggan'])=="KOSONG") {
		$pesanError[] = "<b>Customer</b> has not choosen yet!";
	}
	if(trim($_POST['txtUangBayar'])=="" || !is_numeric($_POST['txtUangBayar'])) {
		$pesanError[] = "<b>Money</b> must be filled with number";
	}
	if(trim($_POST['txtUangBayar']) < trim($_POST['txtTotBayar'])) {
		$pesanError[] = "The <b>Money</b> paid is not enough to buy item with total price of <b>Rp. ".format_angka($_POST['txtTotBayar'])."</b>";
	}
	
	$tmpSql = "SELECT COUNT(*) As qty FROM tmp_penjualan WHERE kd_user='".$_SESSION['SES_LOGIN']."'";
	$tmpQry = mysqli_query($koneksidb, $tmpSql) or die ("Error count tmp_penjualan: ".mysqli_error($koneksidb));
	$tmpData = mysqli_fetch_array($tmpQry);
	if($tmpData['qty'] < 1) {
		$pesanError[] = "<b>Items List</b> is empty! User hasn't input any item yet!";
	}
	
	$cmbTanggal = $_POST['cmbTanggal'];
	$cmbPelanggan = $_POST['cmbPelanggan'];
	$txtKeterangan = $_POST['txtKeterangan'];
	$txtUangBayar = $_POST['txtUangBayar'];
	
	if(count($pesanError) >= 1) {
		echo "<div class='msgBox'>";
		echo "<span class='icon-error'></span><br><hr>";
		$nomor = 0;
		foreach ($pesanError as $pesan_tampil) {
			$nomor++;
			echo "&nbsp;&nbsp; $nomor. $pesan_tampil<br>";
		}
		echo "</div><br>";
	} else {
		$mySql = "INSERT INTO penjualan SET no_penjualan='$noTransaksi', tgl_penjualan='".$cmbTanggal."', kd_pelanggan='$cmbPelanggan', keterangan='$txtKeterangan', uang_bayar='$txtUangBayar', kd_user='".$_SESSION['SES_LOGIN']."'";
		mysqli_query($koneksidb, $mySql) or die ("Error insert to penjualan: ".mysqli_error($koneksidb));
		
		$tmpSql = "SELECT barang.*, tmp.jumlah, tmp.diskon FROM barang, tmp_penjualan As tmp WHERE barang.kd_barang=tmp.kd_barang AND tmp.kd_user='".$_SESSION['SES_LOGIN']."'";
		$tmpQry = mysqli_query($koneksidb, $tmpSql) or die ("Error query #01: ".mysqli_error($koneksidb));
		while ($tmpData = mysqli_fetch_array($tmpQry)) {
			$dataKode = $tmpData['kd_barang'];
			$dataHargaB = $tmpData['harga_beli'];
			$dataHargaJ = $tmpData['harga_jual'];
			$dataDiskon = $tmpData['diskon'];
			$dataJumlah = $tmpData['jumlah'];
			
			$itemSql = "INSERT INTO penjualan_item SET no_penjualan='$noTransaksi', kd_barang='$dataKode', harga_beli='$dataHargaB', harga_jual='$dataHargaJ', diskon='$dataDiskon', jumlah='$dataJumlah'";
			mysqli_query($koneksidb, $itemSql) or die ("Error insert to penjualan_item: ".mysqli_error($koneksidb));
			
			$stokSql = "UPDATE barang SET stok=stok-$dataJumlah WHERE kd_barang='$dataKode'";
			mysqli_query($koneksidb, $stokSql) or die ("Error update stok: ".mysqli_error($koneksidb));
		}
		$hapusSql = "DELETE FROM tmp_penjualan WHERE kd_user='".$_SESSION['SES_LOGIN']."'";
		mysqli_query($koneksidb, $hapusSql) or die ("Error delete from tmp_penjualan: ".mysqli_error($koneksidb));
		echo "<script>";
		echo "window.open('../cetak/penjualan_nota.php?noNota=$noTransaksi', '', 'width=630,height=330,left=100,top=25')";
		echo "</script>";
	}
}

?>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="700" cellspacing="1" cellpadding="3" style="border-collapse:collapse">
    <tr>
      <td colspan="3"><h1>SALES TRANSACTION</h1></td>
    </tr>
    <tr>
      <td width="163" nowrap bgcolor="#CCCCCC">TRANSACTION DATA</td>
      <td width="3" bgcolor="#CCCCCC">&nbsp;</td>
      <td width="510">&nbsp;</td>
    </tr>
    <tr>
      <td nowrap><strong>Transaction No.</strong></td>
      <td>:</td>
      <td>
      <input name="txtNomor" type="text" style="cursor:not-allowed" disabled="disabled" id="txtNomor" value="<?php echo $noTransaksi; ?>" size="23" maxlength="20" readonly></td>
    </tr>
    <tr>
      <td nowrap><strong>Date of Transaction</strong></td>
      <td>:</td>
      <td>
      <input name="cmbTanggal" type="date" id="cmbTanggal" value="<?php echo $tahun; ?>-<?php echo $bulan; ?>-<?php echo $hari; ?>"></td>
    </tr>
    <tr>
      <td nowrap><strong>Customer</strong></td>
      <td>:</td>
      <td>
        <select name="cmbPelanggan" id="cmbPelanggan">
          <option value="KOSONG">....</option>
          <?php
		  $mySql = "SELECT * FROM pelanggan ORDER BY kd_pelanggan";
		  $myQry = mysqli_query($koneksidb, $mySql) or die ("Error query pelanggan: ".mysqli_error($koneksidb));
		  while ($myData = mysqli_fetch_array($myQry)) {
			  if($dataPelanggan == $myData['kd_pelanggan']) {
				  $cek = " selected";
			  } else {
				  $cek = "";
			  }
			  echo "<option value='$myData[kd_pelanggan]' $cek>[ $myData[kd_pelanggan] ] $myData[nm_toko] => $myData[nm_pelanggan]</option>";
		  }
		  ?>
      </select></td>
    </tr>
    <tr>
      <td nowrap><strong>Information</strong></td>
      <td>:</td>
      <td>
      <input name="txtKeterangan" type="text" id="txtKeterangan" value="<?php echo $dataKeterangan; ?>" size="60" maxlength="100"></td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td nowrap bgcolor="#CCCCCC">ITEMS INPUT</td>
      <td bgcolor="#CCCCCC">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td nowrap><strong>Item Code/Barcode</strong></td>
      <td>:</td>
      <td>
      <input name="txtKodeBarcode" type="text" id="txtKodeBarcode" value="<?php echo $barcode; ?>" size="35" maxlength="20">
      <input type="submit" name="cari" id="cari" value="Search">
      </tr>
    <tr>
      <td nowrap><strong>Qty</strong></td>
      <td>:</td>
      <td>
      <input name="txtJumlah" type="number" id="txtJumlah" max="<?php echo $maxJumlah; ?>" min="1" step="1" value="<?php echo $jumlah; ?>"></td>
    </tr>
    <tr>
      <td nowrap><strong>Discount (%)</strong></td>
      <td>:</td>
      <td>
      <input name="txtDiskon" type="number" id="txtDiskon" max="100" min="0" step="1" value="0">
      <input type="submit" name="btnTambah" id="btnTambah" value="Add"></td>
    </tr>
    <tr>
      <td nowrap>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <br>
  <table width="800" cellspacing="1" cellpadding="3">
    <tr>
      <td colspan="8" align="center"><h3>DAFTAR BARANG</h3></td>
    </tr>
    <tr>
      <td width="24" nowrap="nowrap" bgcolor="#CCCCCC"><strong>No.</strong></td>
      <td width="53" nowrap="nowrap" bgcolor="#CCCCCC"><strong>Code</strong></td>
      <td width="249" nowrap="nowrap" bgcolor="#CCCCCC"><strong>Item Name</strong></td>
      <td width="90" align="center" nowrap="nowrap" bgcolor="#CCCCCC"><strong>Price (Rp.)</strong></td>
      <td width="96" align="center" nowrap="nowrap" bgcolor="#CCCCCC"><strong>Discount (%)</strong></td>
      <td width="53" nowrap="nowrap" bgcolor="#CCCCCC"><strong>Qty</strong></td>
      <td width="116" nowrap="nowrap" bgcolor="#CCCCCC"><strong>Subtotal (Rp.)</strong></td>
      <td width="60" nowrap="nowrap" bgcolor="#CCCCCC">&nbsp;</td>
    </tr>
    <?php
    $diskon = 0;
	$totalBayar = 0;
	$jumlahBarang = 0;
	
	$tmpSql = "SELECT barang.*, tmp.id, tmp.diskon, tmp.jumlah FROM barang, tmp_penjualan As tmp WHERE barang.kd_barang=tmp.kd_barang AND tmp.kd_user='".$_SESSION['SES_LOGIN']."' ORDER BY barang.kd_barang";
	$tmpQry = mysqli_query($koneksidb, $tmpSql) or die ("Error query barang: ".mysqli_error($koneksidb));
	$nomor = 0;
	while ($tmpData = mysqli_fetch_array($tmpQry)) {
		$nomor++;
		$id = $tmpData['id'];
		$diskon = $tmpData['harga_jual'] - ($tmpData['harga_jual'] * $tmpData['diskon'] / 100);
		$subTotal = $tmpData['jumlah'] * $diskon;
		$totalBayar = $totalBayar + $subTotal;
		$jumlahBarang = $jumlahBarang + $tmpData['jumlah'];
	?>
    <tr>
      <td align="center"><?php echo $nomor; ?></td>
      <td nowrap="nowrap"><?php echo $tmpData['kd_barang']; ?></td>
      <td nowrap="nowrap"><?php echo $tmpData['nm_barang']; ?></td>
      <td nowrap="nowrap"><?php echo format_angka($tmpData['harga_jual']); ?></td>
      <td nowrap="nowrap"><?php echo $tmpData['diskon']; ?></td>
      <td nowrap="nowrap"><?php echo $tmpData['jumlah']; ?></td>
      <td nowrap="nowrap"><?php echo format_angka($subTotal); ?></td>
      <td nowrap="nowrap"><a href="?Act=Delete&id=<?php echo $id; ?>">Delete</a></td>
    </tr>
    <?php } ?>
    <tr>
      <td colspan="5" align="right" nowrap="nowrap" bgcolor="#F5F5F5"><strong>GRAND TOTAL (Rp.) :</strong></td>
      <td bgcolor="#F5F5F5"><?php echo $jumlahBarang; ?></td>
      <td bgcolor="#F5F5F5"><?php echo format_angka($totalBayar); ?></td>
      <td bgcolor="#F5F5F5">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="5" align="right" nowrap="nowrap" bgcolor="#F5F5F5"><strong>MONEY (Rp.) :</strong></td>
      <td bgcolor="#F5F5F5"><input name="txtTotBayar" type="hidden" id="txtTotBayar" value="<?php echo $totalBayar; ?>"></td>
      <td bgcolor="#F5F5F5">
      <input name="txtUangBayar" type="text" id="txtUangBayar" value="<?php echo $dataUangBayar; ?>" size="16" maxlength="20"></td>
      <td bgcolor="#F5F5F5">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="7" align="right"><input type="submit" name="btnSimpan" id="btnSimpan" value="Save"></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>