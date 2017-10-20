<?php
$mySql = "SELECT * FROM supplier ORDER BY kd_supplier ASC";
$start = microtime(true);
$myQry = mysqli_query($koneksidb, $mySql) or die ("Error query: ".mysqli_error($koneksidb));
$end = microtime(true);
$duration = $end - $start;
?>
<h1>SUPPLIER DATA REPORTS</h1>
<a href="?page=Laporan"><i class="fa fa-arrow-left fa-fw"></i>Back</a><br><br>
<span><i>Query took <?php echo number_format($duration,4,'.',''); ?> seconds</i></span>
<table width="700" cellspacing="1" cellpadding="3" class="table-list">
  <tr>
    <th width="20" scope="col">No</th>
    <th width="304" scope="col">Supplier Name</th>
    <th width="133" scope="col">Address</th>
    <th width="212" scope="col">Telephone</th>
  </tr>
  <?php
  $nomor = 0;
  while ($myData = mysqli_fetch_array($myQry)) {
	  $nomor++;
  ?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['nm_supplier']; ?></td>
    <td><?php echo $myData['alamat']; ?></td>
    <td><?php echo $myData['no_telepon']; ?></td>
  </tr>
  <?php } ?>
</table>