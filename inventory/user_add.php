<?php
include_once "library/inc.seslogin.php";

if(isset($_POST['btnSimpan'])) {
	$pesanError = array();
	if(trim($_POST['cmbLevel']=="KOSONG")) {
		$pesanError[] = "<b>Level</b> has not choosen yet, please choose <b>Admin</b> or <b>Cashier</b>";
	}
	if(!is_numeric($_POST['txtTelepon'])) {
		$pesanError[] = "<b>Telephone</b> must be number!";
	}
	$nama = $_POST['txtNama'];
	$username = $_POST['txtUsername'];
	$password = $_POST['txtPassword'];
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
		$mySql = "INSERT INTO user SET kd_user='$kode', nm_user='$nama', no_telepon='$telepon', username='$username', password='".md5($password)."', level='$level'";
		$myQry = mysqli_query($koneksidb, $mySql) or die ("Error insert query: ".mysqli_error($koneksidb));
		if($myQry){
			echo "<meta http-equiv='refresh' content='0;url=?page=User-Data'>";
		}
	}
}

$dataKode = buatKode("user", "U");
$dataNama = isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
$dataPassword = isset($_POST['txtPassword']) ? $_POST['txtPassword'] : '';
$dataTelepon = isset($_POST['txtTelepon']) ? $_POST['txtTelepon'] : '';
$dataUsername = isset($_POST['txtUsername']) ? $_POST['txtUsername'] : '';
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" id="form1">
  <table width="700" cellspacing="1" cellpadding="3">
    <tr>
      <td colspan="3" align="center"><h2>ADD USER DATA</h2></td>
    </tr>
    <tr>
      <td width="97" nowrap>Code</td>
      <td width="1">:</td>
      <td width="578">
      <input name="textfield" type="text" disabled="disabled" id="textfield" value="<?php echo $dataKode; ?>" size="10" maxlength="4" readonly></td>
    </tr>
    <tr>
      <td nowrap>Name</td>
      <td>:</td>
      <td>
      <input name="txtNama" type="text" autofocus required id="txtNama" value="<?php echo $dataNama; ?>" size="50" maxlength="60"></td>
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
      <input name="txtPassword" type="password" required id="txtPassword" autocomplete="off" value="<?php echo $dataPassword; ?>" size="30" maxlength="100"></td>
    </tr>
    <tr>
      <td nowrap>Telephone</td>
      <td>:</td>
      <td>
      <input name="txtTelepon" type="text" id="txtTelepon" value="<?php echo $dataTelepon; ?>" size="20" maxlength="13"> *numeric
      </td>
    </tr>
    <tr>
      <td nowrap>Level</td>
      <td>:</td>
      <td>
        <select name="cmbLevel" id="cmbLevel">
          <option value="KOSONG">....</option>
          <?php
		  $pilihan = array(Admin, Cashier);
		  foreach ($pilihan as $option) {
			  if($option==$_POST['cmbLevel']) {
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
      <td><input type="submit" name="btnSimpan" id="btnSimpan" value="Submit"></td>
    </tr>
  </table>
</form>
