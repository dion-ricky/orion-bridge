<?php
include_once "library/inc.seslogin.php";

$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM kategori";
$pageQry = mysqli_query($koneksidb, $pageSql) or die ("Error query".mysqli_error($koneksidb));
$jml = mysqli_num_rows($pageQry);
$max = ceil($jml/$row);

?>

<table width="700" cellpadding="3" cellspacing="1">
  <tr>
    <td colspan="2" align="left"><h1>CATEGORY DATA</h1></td>
  </tr>
  <tr>
    <td colspan="2"><a href="?page=Kategori-Add">Add Data</a></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" cellspacing="1" cellpadding="3" class="table-list">
      <tr>
        <th width="5%" align="center">No</th>
        <th width="71%" align="center">Category</th>
        <th width="6%" align="center">Qty</th>
        <th colspan="2" align="center">Tools</th>
        </tr>
        <?php
		$mySql = "SELECT kategori.*, (SELECT COUNT(*) AS qty FROM barang WHERE kd_kategori=kategori.kd_kategori) AS qty_barang FROM kategori ORDER BY kd_kategori ASC LIMIT $hal,$row";
		$myQry = mysqli_query($koneksidb, $mySql) or die ("Error query! ".mysqli_error($koneksidb));
		$nomor = 0;
		while ($myData = mysqli_fetch_array($myQry)) {
			$nomor++;
			$Kode = $myData['kd_kategori'];
		?>
      <tr>
        <td align="center"><?php echo $nomor;?></td>
        <td><?php echo $myData['nm_kategori']; ?></td>
        <td align="center"><a href="#" onClick="window.open('search_info.php?kode=<?php echo $myData['kd_kategori']; ?>','','width=630,height=330,left=100,top=25','')"><?php echo $myData['qty_barang']; ?></a></td>
        <td width="9%" align="center"><a href="?page=Kategori-Edit&Kode=<?php echo $Kode; ?>">Edit</a></td>
        <td width="9%" align="center"><a href="?page=Kategori-Delete&Kode=<?php echo $Kode; ?>" target="_self" onClick="return confirm('Are you sure you want to delete category <?php echo $Kode; ?>?')">Delete</a></td>
      </tr>
      <?php
		}
	  ?>
    </table></td>
  </tr>
  <tr>
    <td width="525">Total Data: <?php echo $jml; ?></td>
    <td width="158" align="right">Page:
<?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $row * $h - $row;
		echo "<a href='?page=Kategori-Data&hal=$list[$h]'>$h</a>";
		if($h<$max){
			echo ", ";
		}
	}
	?></td>
  </tr>
</table>
