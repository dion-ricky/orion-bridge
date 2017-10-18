<?php 
$myHost = "localhost"; 
$myUser = "root"; 
$myPass = ''; 
$myDbs = "coba"; 
 
$koneksidb = mysqli_connect($myHost, $myUser, $myPass); 
if (! $koneksidb) { 
	echo "Failed connection!"; 
} 
 
mysqli_select_db($koneksidb, $myDbs) or die ("Database not found!"); 
?> 
