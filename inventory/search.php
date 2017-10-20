<?php
include_once "library/inc.connection.php";
include_once "library/inc.seslogin.php";

$dataLookup = isset($_GET['cmbSearch']) ? $_GET['cmbSearch'] : "barang";
$query = isset($_GET['query']) ? $_GET['query'] : '';
if (isset($_GET['query'])) {
if ($query != "") { $last = $_GET['query']; } elseif (isset($_GET['last'])) { $last = $_GET['last']; } elseif (!isset($_GET['last'])) { $last = ""; }
if ($_GET['query'] != "") { $query = $_GET['query']; } else { $query = $last;}
} // if $_GET query
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Search</title>
<style type="text/css">
body, html {
	height:100%;
	margin:0;
	border:0;
}
form#searchDrop {
	position:absolute;
	top:40%;
	left:50%;
	transform:translate(-50%,-50%);
	text-align:center;
	width:100%;
}
h1 {
	text-align:center;
	font-size:60px;
}
div#noResult {
	font-weight:bold;
	font-size:18px;
	cursor:default;
}
div#sad {
	font-weight:;
	font-size:90px;
	font-family:Consolas, "Andale Mono", "Lucida Console", "Lucida Sans Typewriter", Monaco, "Courier New", monospace;
	cursor:default;
}
</style>
</head>
<body>
<?php
if(isset($_GET['query'])) {
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="get" target="_self" id="searchTrigger">
  <table width="500" cellspacing="1" cellpadding="3">
    <tr>
      <td>
        <input name="page" type="hidden" id="page" value="Search">
        <input name="last" type="hidden" id="last" value="<?php echo $last; ?>">
		<label for="query">Search:</label>
      <input name="query" type="text" id="query" value="<?php echo $query; ?>">
      <input type="submit" value="Search">
      <select name="cmbSearch" id="cmbSearch" onChange="search()">
      <?php
	  $lookup = array('items', 'category', 'supplier', 'customer');
	  foreach ($lookup as $where) {
		  if($dataLookup == $where) {
			  $cek = "selected";
		  } else { $cek = ""; }
		  echo "<option value='$where' $cek>$where</option>";
	  }
      ?>
      </select></td>
    </tr>
  </table>
</form>
<br>
<?php
if(trim($_GET['query']) == "" && isset($_GET['last']) && trim($_GET['last']) != "") {
	$query = $_GET['last'];
} elseif(!isset($_GET['last']) && !isset($_GET['query']))  {
	  echo "<div id='sad'>:(</div>";
	  echo "<br>";
	  echo "<div id='noResult'>We can't search $dataLookup with an empty query!</div>";
}
if(trim($_GET['cmbSearch'])=="items") {
	$query = htmlspecialchars($query);
	$query = mysqli_real_escape_string($koneksidb, $query);
	$Sql = "SELECT * FROM barang WHERE (kd_barang LIKE '%".$query."%') OR (nm_barang LIKE '%".$query."%') OR (barcode LIKE '%".$query."%') ORDER BY kd_barang";
	$start = microtime(true);
	$Qry = mysqli_query($koneksidb, $Sql) or die ("Error search: ".mysqli_error($koneksidb));
	$end = microtime(true);
	$duration = $end - $start;
	if ($query != "") {
	if (mysqli_num_rows($Qry)>=1) {
		$infoName = "";
		$infoSize = "width=630,height=330,left=100,top=25";
		?>
<table width="600" cellspacing="1" cellpadding="3">
<tr>
<td><i>Showing <?php echo mysqli_num_rows($Qry); ?> result(s) in <?php echo number_format($duration,4,'.',''); ?> seconds</i></td>
</tr>
</table><br>
        <?php
		while ($results = mysqli_fetch_array($Qry)) {
			$info = "search_info.php?kode=$results[kd_barang]";
?>
<table width="600" cellspacing="1" cellpadding="3" class="search">
  <tr>
    <td colspan="2" class="searchHead"><?php echo "[".$results['barcode']."]"." ".$results['nm_barang']; ?></td>
  </tr>
  <tr>
    <td colspan="2"><?php echo "<b>code:</b> ".$results['kd_barang'].", <b>information:</b> ".$results['keterangan']; ?></td>
  </tr>
  <tr>
      <td class="moreInfo"><a onClick="window.open('<?php echo $info; ?>','','<?php echo $infoSize; ?>','')">More info...</a></td>
  </tr>
</table><hr style="position:relative;float:left;width:50%;">
  <?php 
		} // While
	} else {
	  echo "<div id='sad'>:(</div>";
	  echo "<br>";
	  echo "<div id='noResult'>$dataLookup data on the database has no match with search query '$query'</div>";

	}// If num_rows>0
	} // if $results != ""
?>
<?php
	} // if $_POST[cmbSearch] = barang
	elseif (trim($_GET['cmbSearch'])=="category") {
		
  		$query = htmlspecialchars($query);
  		$query = mysqli_real_escape_string($koneksidb, $query);
  		$mySql = "SELECT * FROM kategori WHERE (kd_kategori LIKE '%".$query."%') OR (nm_kategori LIKE '%".$query."%') ORDER BY kd_kategori";
		$start = microtime(true);
  		$myQry = mysqli_query($koneksidb,$mySql) or die ("Error query: ".mysqli_error($koneksidb));
		$end = microtime(true);
		$duration = $end - $start;
  		if(mysqli_num_rows($myQry) >= 1) {
		$infoName = "";
		$infoSize = "width=630,height=330,left=100,top=25";
		?>
<table width="600" cellspacing="1" cellpadding="3">
<tr>
<td><i>Showing <?php echo mysqli_num_rows($myQry); ?> result(s) in <?php echo number_format($duration,4,'.',''); ?> seconds</i></td>
</tr>
</table><br>
<?php
  while ($myData = mysqli_fetch_array($myQry)) {
	  $entrySql = "SELECT nm_barang FROM barang WHERE kd_kategori='$myData[kd_kategori]'";
	  $entryQry = mysqli_query($koneksidb, $entrySql) or die ("Error entry sql: ".mysqli_error($koneksidb));
	  $totalEntry = mysqli_num_rows($entryQry);
	  $info = "search_info.php?kode=$myData[kd_kategori]";
  ?>
<table width="600" cellspacing="1" cellpadding="3" class="search">
  <tr>
    <td colspan="2" class="searchHead"><?php echo "[".$myData['kd_kategori']."]"." ".$myData['nm_kategori']; ?></td>
  </tr>
  <tr>
    <td colspan="2"><?php echo $totalEntry." Entry on database"; ?></td>
  </tr>
  <tr>
      <td class="moreInfo"><a onClick="window.open('<?php echo $info; ?>','','<?php echo $infoSize; ?>','')">More info...</a></td>
  </tr>
</table><hr style="position:relative;float:left;width:50%;">
  <?php }
  } else {
	  echo "<div id='sad'>:(</div>";
	  echo "<br>";
	  echo "<div id='noResult'>$dataLookup data on the database has no match with search query '$query'</div>";
  }
  ?>
<?php } //$_POST cmbSearch = kategori

elseif(trim($_GET['cmbSearch'])=="supplier") { // $_POST cmbSearch =supplier
	$query = htmlspecialchars($query);
	$query = mysqli_real_escape_string($koneksidb, $query);
	$mySql = "SELECT * FROM supplier WHERE (kd_supplier LIKE '%".$query."%') OR (nm_supplier LIKE '%".$query."%') ORDER BY kd_supplier";
	$start = microtime(true);
	$myQry = mysqli_query($koneksidb, $mySql) or die ("Error query: ".mysqli_error($koneksidb));
	$end = microtime(true);
	$duration = $end - $start;
	if (mysqli_num_rows($myQry)>=1) {
		$infoSize = "width=710,height=330,left=100,top=25";
	?>
<table width="600" cellspacing="1" cellpadding="3">
<tr>
<td><i>Showing <?php echo mysqli_num_rows($myQry); ?> result(s) in <?php echo number_format($duration,4,'.',''); ?> seconds</i></td>
</tr>
</table><br>
<?php
  		while ($results = mysqli_fetch_array($myQry)) {
			$info = "search_info.php?kode=$results[kd_supplier]";
  ?>
<table width="600" cellspacing="1" cellpadding="3" class="search">
  <tr>
    <td colspan="2" class="searchHead"><?php echo "[".$results['kd_supplier']."]"." ".$results['nm_supplier']; ?></td>
  </tr>
  <tr>
    <td colspan="2"><?php echo "<b>Address:</b> ".$results['alamat'].", <b>Telephone:</b> ".$results['no_telepon']; ?></td>
  </tr>
  <tr>
      <td class="moreInfo"><a onClick="window.open('<?php echo $info; ?>','','<?php echo $infoSize; ?>','')">More info...</a></td>
  </tr>
</table><hr style="position:relative;float:left;width:50%;">
  <?php } // while
	} else {
	  echo "<div id='sad'>:(</div>";
	  echo "<br>";
	  echo "<div id='noResult'>$dataLookup data on the database has no match with search query '$query'</div>";		
	}// if >= 1
} // if $_POST cmbSearch = supplier
elseif(trim($_GET['cmbSearch'])=="customer") {
	$query = htmlspecialchars($query);
	$query = mysqli_real_escape_string($koneksidb, $query);
	$mySql = "SELECT * FROM pelanggan WHERE kd_pelanggan LIKE '%".$query."%' OR nm_pelanggan LIKE '%".$query."%'";
	$start = microtime(true);
	$myQry = mysqli_query($koneksidb, $mySql) or die ("Error query: ".mysqli_error($koneksidb));
	$end = microtime(true);
	$duration = $end - $start;
		if (mysqli_num_rows($myQry)>=1) {
			$infoSize = "width=730,height=360,left=100,top=25";
?>
<table width="600" cellspacing="1" cellpadding="3">
<tr>
<td><i>Showing <?php echo mysqli_num_rows($myQry); ?> result(s) in <?php echo number_format($duration,4,'.',''); ?> seconds</i></td>
</tr>
</table><br>
<?php
		while ($results = mysqli_fetch_array($myQry)) {
			$info = "search_info.php?kode=$results[kd_pelanggan]";
  ?>
<table width="600" cellspacing="1" cellpadding="3" class="search">
  <tr>
    <td colspan="2" class="searchHead"><?php echo "[".$results['kd_pelanggan']."]"." ".$results['nm_pelanggan']; ?></td>
  </tr>
  <tr>
    <td colspan="2"><?php echo "<b>Shop:</b> ".$results['nm_toko'].", <b>Address:</b> ".$results['alamat']; ?></td>
  </tr>
  <tr>
      <td class="moreInfo"><a onClick="window.open('<?php echo $info; ?>','','<?php echo $infoSize; ?>','')">More info...</a></td>
  </tr>
</table><hr style="position:relative;float:left;width:50%;">
  <?php } // while
	} else {
	  echo "<div id='sad'>:(</div>";
	  echo "<br>";
	  echo "<div id='noResult'>$dataLookup data on the database has no match with search query '$query'</div>";
	}// if >= 1
} // if $_POST cmbSearch = pelanggan
} // if isset query
else {
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="get" name="form2" target="_self" id="searchDrop">
  <table width="100%" cellspacing="1" cellpadding="3" id="searchDrop">
    <tr>
      <td><h1 style="font-family:'Times New Roman'">Search
        <input name="page" type="hidden" id="page" value="Search">
      </h1></td>
    </tr>
    <tr>
      <td>
      <input name="query" type="text" autofocus required id="query" placeholder="Search data in table inventory_db" size="65"><select name="cmbSearch" id="cmbSearch">
      <?php
	  $lookup = array("items", "category", "supplier", "customer");
	  foreach ($lookup as $where) {
		  if($dataLookup == $where) {
			  $cek = "selected";
		  } else { $cek = ""; }
		  echo "<option value='$where' $cek>$where</option>";
	  }
      ?>
      </select></td>
    </tr>
  </table>
</form>
<?php } ?>
</body>
</html>