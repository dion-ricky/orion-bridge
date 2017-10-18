<?php
$mySql = "SELECT kategori.*, ( SELECT COUNT(*) FROM barang WHERE kd_kategori=kategori.kd_kategori ) As qty_barang FROM kategori ORDER BY kd_kategori ASC";
$start = microtime(true);
$myQry = mysqli_query($koneksidb, $mySql) or die ("Error query: ".mysqli_error($koneksidb));
$end = microtime(true);
$duration = $end - $start;
?>
<h1>CATEGORY DATA REPORTS</h1>
<a href="?page=Laporan"><i class="fa fa-arrow-left fa-fw"></i>Back</a><br><br>
<span><i>Query took <?php echo number_format($duration,4,'.',''); ?> seconds</i></span>
<table width="500" cellspacing="1" cellpadding="3" class="table-list">
  <tr>
    <th width="20" scope="col">No</th>
    <th width="360" scope="col">Category</th>
    <th width="96" nowrap="nowrap" scope="col">Item(s) Qty</th>
  </tr>
  <?php
  $nomor = 0;
  while ($myData = mysqli_fetch_array($myQry)) {
	  $nomor++;
  ?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['nm_kategori']; ?></td>
    <td align="center"><a href='#' onClick="window.open('search_info.php?kode=<?php echo $myData['kd_kategori']; ?>','','width=630,height=330,left=100,top=25','')"><?php echo $myData['qty_barang']; ?></a></td>
  </tr>
  <?php } ?>
</table>
