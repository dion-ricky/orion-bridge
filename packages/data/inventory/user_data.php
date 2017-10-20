<?php
include_once "library/inc.seslogin.php";

$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM user";
$pageQry = mysqli_query($koneksidb, $pageSql) or die ("Error paging: ".mysqli_error($koneksidb));
$jml = mysqli_num_rows($pageQry);
$max = ceil($jml/$row);
?>
<table width="700" cellspacing="1" cellpadding="3">
  <tr>
    <td colspan="2" align="left"><h1>USER DATA</h1></td>
  </tr>
  <tr>
    <td colspan="2"><a href="?page=User-Add">Add Data</a></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" cellspacing="1" cellpadding="3" class="table-list">
      <tr >
        <th width="4%" scope="col">No</th>
        <th width="11%" scope="col">Code</th>
        <th width="22%" scope="col">Name</th>
        <th width="16%" scope="col">Username</th>
        <th width="17%" scope="col">Telephone</th>
        <th width="14%" scope="col">Level</th>
        <th colspan="2" scope="col">Tools</th>
        </tr>
        <?php
		$mySql = "SELECT * FROM user ORDER BY kd_user ASC LIMIT $hal,$row";
		$myQry = mysqli_query($koneksidb, $mySql) or die ("Error query: ".mysqli_error($koneksidb));
		$nomor = 0;
		while ($myData = mysqli_fetch_array($myQry)) {
			$nomor++;
			$Kode = $myData['kd_user'];
		?>
      <tr>
        <td align="center" nowrap><?php echo $nomor; ?></td>
        <td align="center" nowrap><?php echo $Kode; ?></td>
        <td nowrap><?php echo $myData['nm_user']; ?></td>
        <td nowrap><?php echo $myData['username']; ?></td>
        <td align="center" nowrap><?php echo $myData['no_telepon']; ?></td>
        <td align="center" nowrap><?php echo $myData['level']; ?></td>
        <td width="8%" align="center" nowrap><a href="?page=User-Edit&Kode=<?php echo $Kode; ?>">Edit</a></td>
        <td width="8%" align="center" nowrap><a href="?page=User-Delete&Kode=<?php echo $Kode; ?>" onClick="return confirm('Are you sure you want to delete user <?php echo $Kode; ?>?')">Delete</a></td>
      </tr>
      <?php
		}
	  ?>
    </table></td>
  </tr>
  <tr>
    <td width="559">Total Data: <?php echo $jml; ?></td>
    <td width="124" align="right">Page:
<?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $row * $h - $row;
		echo "<a href='?page=User-Data&hal=$list[$h]'>$h</a>";
		if($h<$max){
			echo ", ";
		}
	}
	?>
    </td>
  </tr>
</table>
