<?php
$mySql = "SELECT * FROM user ORDER BY kd_user ASC";
$start = microtime(true);
$myQry = mysqli_query($koneksidb, $mySql) or die ("Error query: ".mysqli_error($koneksidb));
$end = microtime(true);
$duration = $end - $start;
?>
<h1>USER DATA REPORTS</h1>
<a href="?page=Laporan"><i class="fa fa-arrow-left fa-fw"></i>Back</a><br><br>
<span><i>Query took <?php echo number_format($duration,4,'.',''); ?> seconds</i></span>
<table width="600" cellspacing="1" cellpadding="3" class="table-list">
  <tr>
    <th width="20" scope="col">No</th>
    <th width="174" scope="col">Name</th>
    <th width="154" scope="col">Telephone</th>
    <th width="135" scope="col">Username</th>
    <th width="79" scope="col">Level</th>
  </tr>
  <?php
  $nomor = 0;
  while ($myData = mysqli_fetch_array($myQry)) {
	  $nomor++;
  ?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['nm_user']; ?></td>
    <td><?php echo $myData['no_telepon']; ?></td>
    <td><?php echo $myData['username']; ?></td>
    <td align="center"><?php echo $myData['level']; ?></td>
  </tr>
  <?php } ?>
</table>