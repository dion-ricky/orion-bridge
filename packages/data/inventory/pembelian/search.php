<?php
include_once "../library/inc.connection.php";

$query = isset($_GET['query']) ? $_GET['query'] : '';
if ($query != "") { $last = $_GET['query']; } elseif (isset($_GET['last'])) { $last = $_GET['last']; }

if(isset($_GET['sk'])) {
	$sk = $_GET['sk'];
} else {
	$sk = "";
}
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
}
form#searchTrigger {
	position:absolute;
	top:2%;
	left:1%;
}
table.searchTrigger {
	position:absolute;
	top: 11%;
	left: 3%;
	text-align:center;
}
h1 {
	font-size:60px;
}
</style>
</head>

<body>
<script type="text/javascript">
function windowClose(sender) {
	try {
		var x = sender.getAttribute("result");
		var y = sender.getAttribute("sk");
		window.opener.HandlePopUpResult(x,y);
	}
	catch (err) {}
	window.close();
	return false;
}
</script>
<?php
if(isset($_GET['query'])) {
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="get" target="_self" id="searchTrigger">
  <table width="400" cellspacing="1" cellpadding="3">
    <tr>
      <td>
        <input name="page" type="hidden" id="page" value="Search">
        <input name="last" type="hidden" id="last" value="<?php echo $last; ?>">
        <input name="sk" type="hidden" id="sk" value="<?php echo $sk; ?>">
<label for="query">Search:</label>
      <input name="query" type="text" id="query" value="<?php echo $query; ?>">
      <input type="submit" value="Search"></td>
    </tr>
  </table>
</form>
<br><br>
<?php
if(trim($_GET['query'])=="") {
	$query = $_GET['last'];
}
?>
<table width="889" cellpadding="3" cellspacing="1" class="searchTrigger">
  <tr>
    <th width="20" nowrap="nowrap" scope="col">No</th>
    <th width="133" nowrap="nowrap" scope="col">Code</th>
    <th width="144" nowrap="nowrap" scope="col">Barcode</th>
    <th width="272" nowrap="nowrap" scope="col">Item Name</th>
    <th width="272" nowrap="nowrap" scope="col">&nbsp;</th>
  </tr>
  <?php
	$query = htmlspecialchars($query);
	$query = mysqli_real_escape_string($koneksidb, $query);
	$Sql = "SELECT * FROM barang WHERE (kd_barang LIKE '%".$query."%') OR (nm_barang LIKE '%".$query."%') OR (barcode LIKE '%".$query."%')";
	$Qry = mysqli_query($koneksidb, $Sql) or die ("Error search: ".mysqli_error($koneksidb));
	if (mysqli_num_rows($Qry)>0) {
		$nomor = 0;
		while ($results = mysqli_fetch_array($Qry)) {
			$nomor++;
?>
  <tr>
    <td nowrap="nowrap"><?php echo $nomor; ?></td>
    <td nowrap="nowrap"><?php echo $results['kd_barang']; ?></td>
    <td nowrap="nowrap"><?php echo $results['barcode']; ?></td>
    <td nowrap="nowrap"><?php echo $results['nm_barang']; ?></td>
    <td nowrap="nowrap"><a href="" result="<?php echo $results['barcode']; ?>" sk="<?php echo $_GET['sk']; ?>" onClick="return windowClose(this);" >Insert</a></td>
  </tr>
  <?php 
		} // While
	} // If num_rows>0
?>
</table>
<?php
} // if isset $_GET[query]
else {
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="get" name="form2" target="_self" id="searchDrop">
  <table width="100%" cellspacing="1" cellpadding="3" id="searchDrop">
    <tr>
      <td><h1>Search
        <input name="page" type="hidden" id="page" value="Search">
        <input name="sk" type="hidden" id="sk" value="<?php echo $sk; ?>">
      </h1></td>
    </tr>
    <tr>
      <td>
      <input name="query" type="text" autofocus required id="query" placeholder="Search data in table inventory_db" size="75"></td>
    </tr>
  </table>
</form>
<?php } ?>
</body>
</html>