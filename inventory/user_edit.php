<?php
include_once "library/inc.seslogin.php";

if(isset($_POST['btnSimpan'])) {
	$pesanError = array();
	if(trim($_POST['cmbLevel']=="KOSONG")) {
		$pesanError[] = "<b>Level</b> has not choosen yet, please choose <b>Admin</b> or <b>Cashier</b>";
	}
	if(!is_numeric($_POST['txtTelepon'])) {
		$telSql = "SELECT no_telepon FROM user WHERE kd_user='".$_GET['Kode']."'";
		$telQry = mysqli_query($koneksidb, $telSql) or die ("Error query telephone: ".mysqli_error($koneksidb));
		$telData = mysqli_fetch_array($telQry);
		if($telData['no_telepon']==$_POST['txtTelepon']) {
			$telepon = $_POST['txtTelepon'];
		} else {
		$pesanError[] = "<b>Telephone</b> must be numbers!";
		}
	}	
	$nama = $_POST['txtNama'];
	$username = $_POST['txtUsername'];
	$telepon = $_POST['txtTelepon'];
	$level = $_POST['cmbLevel'];
	
	if(count($pesanError)>=1) {
		echo "<div class='msgBox'>";
		echo "<span class='icon-error'></span> <br><hr>";
		$nomor = 0;
		foreach ($pesanError as $pesan_tampil) {
			$nomor++;
			echo "&nbsp;&nbsp; $nomor. $pesan_tampil<br>";
		}
		echo "</div><br>";
	} else {
		$kode = buatKode("user", "U");
		$mySql = "UPDATE user SET nm_user='$nama', no_telepon='$telepon', username='$username', level='$level' WHERE kd_user='".$_POST['txtKode']."'";
		$myQry = mysqli_query($koneksidb, $mySql) or die ("Error insert query: ".mysqli_error($koneksidb));
		if($myQry){
			echo "<meta http-equiv='refresh' content='0;url=?page=User-Data'>";
		}
	}
}
$Kode = isset($_GET['Kode']) ? $_GET['Kode'] : $_POST['txtKode'];
$mySql = "SELECT * FROM user WHERE kd_user='$Kode'";
$myQry = mysqli_query($koneksidb, $mySql) or die ("<b>Error query: </b>".mysqli_error($koneksidb));
$myData = mysqli_fetch_array($myQry);

$dataKode = $myData['kd_user'];
$dataNama = isset($_POST['txtNama']) ? $_POST['txtNama'] : $myData['nm_user'];
$dataPassword = isset($_POST['txtPassword']) ? $_POST['txtPassword'] : $myData['password'];
$dataTelepon = isset($_POST['txtTelepon']) ? $_POST['txtTelepon'] : $myData['no_telepon'];
$dataUsername = isset($_POST['txtUsername']) ? $_POST['txtUsername'] : $myData['username'];
$level = isset($_POST['cmbLevel']) ? $_POST['cmbLevel'] : $myData['level'];
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" id="form1">
  <table width="700" cellspacing="1" cellpadding="3">
    <tr>
      <td colspan="3" align="center"><h2>EDIT USER DATA</h2></td>
    </tr>
    <tr>
      <td width="97" nowrap>Code</td>
      <td width="1">:</td>
      <td width="578">
      <input name="textfield" type="text" disabled="disabled" id="textfield" value="<?php echo $dataKode; ?>" size="10" maxlength="4" readonly>
      <input name="txtKode" type="hidden" id="txtKode" value="<?php echo $dataKode; ?>"></td>
    </tr>
    <tr>
      <td nowrap>Name</td>
      <td>:</td>
      <td>
      <input name="txtNama" type="text" autofocus required id="txtNama" value="<?php echo $dataNama; ?>" size="50" maxlength="60">
      <input name="txtLama" type="hidden" id="txtLama" value="<?php echo $myData['nm_user']; ?>"></td>
    </tr>
    <tr>
      <td nowrap>Username</td>
      <td>:</td>
      <td>
      <input name="txtUsername" type="text" required id="txtUsername" autocomplete="off" value="<?php echo $dataUsername; ?>" size="30" maxlength="20"></td>
    </tr>
    <tr>
      <td nowrap>Password</td>
      <td>:</td>
      <td>
      <input style="cursor:not-allowed" name="txtPassword" type="password" disabled="disabled" id="txtPassword" autocomplete="off" value="<?php echo $dataPassword; ?>" size="30" maxlength="100" readonly></td>
    </tr>
    <tr>
      <td nowrap>Telephone</td>
      <td>:</td>
      <td>
      <input name="txtTelepon" type="text" id="txtTelepon" value="<?php echo $dataTelepon; ?>" size="30" maxlength="20"></td>
    </tr>
    <tr>
      <td nowrap>Level</td>
      <td>:</td>
      <td>
        <select name="cmbLevel" id="cmbLevel">
          <option value="KOSONG">....</option>
          <?php
		  $pilihan = array(Cashier, Admin);
		  foreach ($pilihan as $option) {
			  if($option == $level) {
				  $cek = " selected";
			  } else {
				  $cek = "";
			  }
			  echo "<option value='$option' $cek>$option</option>";
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
