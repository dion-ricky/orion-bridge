<?php
include_once "library/inc.seslogin.php";

$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM pelanggan";
$pageQry = mysqli_query($koneksidb, $pageSql) or die ("<b>Error page sql: </b>".mysqli_error($koneksidb));
$jml = mysqli_num_rows($pageQry);
$max = ceil($jml/$row);

?>

<table width="900" cellspacing="1" cellpadding="3">
  <tr>
    <td colspan="2" align="left"><h1>CUSTOMER DATA</h1></td>
  </tr>
  <tr>
    <td colspan="2"><a href="?page=Pelanggan-Add">Add Data</a></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" cellspacing="1" cellpadding="3" class="table-list">
      <tr >
        <th width="4%" scope="col">No</th>
        <th width="28%" scope="col">Customer Name</th>
        <th width="17%" scope="col">Shop</th>
        <th width="23%" scope="col">Address</th>
        <th width="14%" scope="col">Telephone</th>
        <th colspan="2" scope="col">Tools</th>
        </tr>
        <?php
		$mySql = "SELECT * FROM pelanggan ORDER BY kd_pelanggan ASC LIMIT $hal,$row";
		$myQry = mysqli_query($koneksidb, $mySql) or die ("<b>Error query list: </b>".mysqli_error($koneksidb));
		$nomor = 0;
		while ($myData = mysqli_fetch_array($myQry)) {
			$nomor++;
			$Kode = $myData['kd_pelanggan'];
		?>
      <tr>
        <td align="center" nowrap="nowrap"><?php echo $nomor; ?></td>
        <td nowrap="nowrap"><?php echo $myData['nm_pelanggan']; ?></td>
        <td><?php echo $myData['nm_toko']; ?></td>
        <td><?php echo $myData['alamat']; ?></td>
        <td align="center" nowrap="nowrap"><?php echo $myData['no_telepon']; ?></td>
        <td width="7%" align="center"><a href="?page=Pelanggan-Edit&Kode=<?php echo $Kode; ?>">Edit</a></td>
        <td width="7%" align="center"><a href="?page=Pelanggan-Delete&Kode=<?php echo $Kode; ?>" target="_self" onClick="return confirm('Are you sure you want to delete customer <?php echo $Kode; ?>?')">Delete</a></td>
      </tr>
      <?php
		}
	  ?>
    </table></td>
  </tr>
  <tr>
    <td width="776">Total Data: <?php echo $jml; ?></td>
    <td width="107" align="right" nowrap="nowrap">Page:
<?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $row * $h - $row;
		echo "<a href='?page=Supplier-Data&hal=$list[$h]'>$h</a>";
		if($h<$max){
			echo ", ";
		}
	}
	?></td>
  </tr>
</table>
