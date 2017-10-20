<?php
if(isset($_POST['btnLogin'])) {
	
	// Redirect
	if (trim($_POST['redirect'])=="") {
		$redir = "?page=Halaman-Utama";
	} else {
	$redir = $_POST['redirect'];
	if (substr($redir,0,1)=="/") {
		$redir = ".".$redir;
	} else {
		$redir = "?page=".$redir;
	}
	}
	// error
	$pesanError = array();
	if (trim($_POST['txtUser'])=="") {
		$pesanError[] = "<b>Username</b> should not be empty!";
	}
	
	if(trim($_POST['txtPassword'])=='') {
		$pesanError[]= "<b>Password</b> should not be empty!";
	}
	
	if($_POST['cmbLevel']=="KOSONG") {
		$pesanError[] = "<b>Level</b> has not choosen yet!";
	}
	
	// Baca variable dari form
	$txtUser = $_POST['txtUser'];
	$txtUser = str_replace("'", "&acute;",$txtUser);
	$txtPassword = $_POST['txtPassword'];
	$txtPassword = str_replace("'", "&acute;",$txtPassword);
	$cmbLevel = $_POST['cmbLevel'];
	
	// Show error
	if (count($pesanError)>=1) {
		echo "<div class='msgBox'>";
		echo "<span class='icon-error'></span><br><hr>";
		$noPesan = 0;
		foreach ($pesanError as $pesan_tampil) {
			$noPesan++;
			echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";
		}
		echo "</div><br>";
		include "login.php";
	}
	else {
		$mySql = "SELECT * FROM user WHERE username='".$txtUser."' AND password='".md5($txtPassword)."' AND level='$cmbLevel'";
		$myQry = mysqli_query($koneksidb, $mySql) or die ("Gagal query".mysqli_error($koneksidb));
		
		if(mysqli_num_rows($myQry)>=1) {
			$myData = mysqli_fetch_array($myQry);
			$_SESSION['SES_LOGIN'] = $myData['kd_user'];
			$_SESSION['SES_USER'] = $myData['username'];
			$_SESSION['SES_NAME'] = $myData['nm_user'];
			if ($cmbLevel=="Admin") {
				$_SESSION['SES_ADMIN'] = "Admin";
			}
			if ($cmbLevel=="Cashier") {
				$_SESSION['SES_CASHIER'] = "Cashier";
			}
			
			echo "<meta http-equiv='refresh' content='0;url=$redir'>";
		}
		else {
			echo "You are not ".$_POST['cmbLevel'];
		}
	}
}
?>