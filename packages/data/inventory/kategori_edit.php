<?php
include_once "library/inc.seslogin.php";

if($_GET) {
	// btnSimpan clicked
	if(isset($_POST['btnSimpan'])) {
		
			// Error
		$pesanError = array();
		if (trim($_POST['txtKategori'])=="") {
			$pesanError[] = "<b>Category Name</b> should not be empty!";
		}
		$txtNama = $_POST['txtKategori'];
		
		$cekSql = "SELECT * FROM kategori WHERE nm_kategori='$txtNama' AND NOT(nm_kategori='".$_POST['txtLama']."')";
		$cekQry = mysqli_query($koneksidb, $cekSql) or die ("Error Query".mysqli_error($koneksidb));
		if (mysqli_num_rows($cekQry)>=1) {
			$pesanError[] = "Sorry, category using name: <b>'$txtNama'</b> already exists in the database! Please pick another name!" ;
		}
		
		if (count($pesanError)>=1) {
			echo "<div class='msgBox'>";
			echo "<span class='icon-error'></span><br><hr>";
			$noPesan = 0;
			foreach ($pesanError as $pesan_tampil) {
				$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";
			}
			echo "</div><br>";
		} else {
			$kodeBaru = buatKode("kategori", "K");
			$mySql = "UPDATE kategori SET nm_kategori='$txtNama' WHERE kd_kategori='".$_POST['txtKode']."'";
			$myQry = mysqli_query($koneksidb, $mySql) or die ("Gagal Query".mysqli_error($koneksidb));
			if ($myQry) {
				echo "<meta http-equiv='refresh' content='0;url=?page=Kategori-Data'>";
			}
			exit;
		}
	} // Penutup if post
	
	$Kode = isset($_GET['Kode']) ? $_GET['Kode'] : $_POST['$txtKode'];
	$mySql = "SELECT * FROM kategori WHERE kd_kategori='$Kode'";
	$myQry = mysqli_query($koneksidb, $mySql) or die ("<b>Query Error: </b>".mysqli_error($koneksidb));
	$myData = mysqli_fetch_array($myQry);
	
	# Temporary Variable
	$dataKode = $myData['kd_kategori'];
	$dataKategori = isset($_POST['txtKategori']) ? $_POST['txtKategori'] : $myData['nm_kategori'];
	
} // Penutup GET
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" target="_self">
  <table width="600" cellpadding="3" cellspacing="1">
    <tr>
      <th colspan="3" scope="col"><h2>EDIT CATEGORY DATA</h2></th>
    </tr>
    <tr>
      <td width="126">Code</td>
      <td width="3">:</td>
      <td width="447">
      <input name="text" type="text" disabled id="text" value="<?php echo $dataKode; ?>" size="10" maxlength="10" readonly>
      <input name="txtKode" type="hidden" id="txtKode" value="<?php echo $dataKode; ?>"></td>
    </tr>
    <tr>
      <td nowrap>Category Name</td>
      <td>:</td>
      <td>
      <input name="txtKategori" type="text" autofocus id="txtKategori" value="<?php echo $dataKategori; ?>" size="60" maxlength="100">
      <input name="txtLama" type="hidden" id="txtLama" value="<?php echo $myData['nm_kategori']; ?>"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="btnSimpan" id="btnSimpan" value="Save"></td>
    </tr>
  </table>
</form>