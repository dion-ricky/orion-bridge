<?php
session_start();
include_once "library/inc.connection.php";
include_once "library/inc.library.php";
include_once "library/inc.pilihan.php";

date_default_timezone_set("Asia/Jakarta");
$username = isset($_SESSION['SES_NAME']) ? $_SESSION['SES_NAME'] : 'Guest';
$avatar = 'iVBORw0KGgoAAAANSUhEUgAAAO4AAADuCAMAAAAJMMsQAAACrFBMVEU3NDU4NTY5Njc6Nzg7ODk8OTo9Ojs+Ozw/PD1APT5BPj9CP0BDQEFEQUJFQkNGQ0RGREVHREVIRUZJRkdKR0hKSElLSElMSUpNSktOS0xOTE1PTE1QTU5RTk9RT1BSUFFUUVJVUlNVU1RWVFVXVFVYVVZZVldZV1haWFhbWFlcWVpdWltdW1xeXFxfXF1gXV5gXl9hX2BiYGBjYGFkYWJnZGVoZWZoZmdpZ2hqaGhraGlraWpsamtta2xubGxvbG1vbW5xb3BycHBzcHFzcXJ0cnN1c3R2dHR2dHV3dXZ5d3h6eHh6eHl7eXp8ent9e3t+fHx/fX6Afn+Bf3+CgICCgIGDgYKEgoOFg4OFhISGhIWHhYaIhoeJh4eJiIiKiImLiYqMiouNi4uNjIyPjY6Qjo+Qj4+SkJGTkZKUkpOUk5OVlJSXlZaYlpeamJmbmZqcmpucm5uenJ2fnZ6fnp6gn5+hoKCioKGjoaKjoqKko6OlpKSmpKWnpqaop6epqKiqqKmqqaqrqqqsq6utrKyurK2ura6vrq6wr6+xsLCysLGysbKzsrK0s7O1tLS1tLW2tba3tra4t7e5uLi5uLm6ubq7urq8u7u9vLy9vL2+vb3Av7/BwMDBwMHDwsLEw8PFxMXGxcXHxsbIx8fIyMjJyMnKycnMy8vMzMzNzM3Ozc3Pz8/R0NHS0dHT0tLT09PU1NTV1NXW1dXX1tbX19fY2NjZ2Nna2dna2trb29vc3Nzd3N3e3d3e3t7g4ODh4ODi4eHi4uLj4+Pk5OTl5OTm5eXm5ubn5+fo6Ojp6Ojp6enq6urr6+vs7Ozt7Ozt7e3u7u7v7+/w8PDx8PDx8fHy8vLz8/P09PT19fX29vb39/f4+Pj5+fn6+vr7+/v8/Pz9/f3+/v7///8AAAAp4fPUAAAA5HRSTlP//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////wCKi/9yAAAACXBIWXMAAC4jAAAuIwF4pT92AAAKsUlEQVR4nO2dfVRUdRrHL4SkhdoLZSIcFdRstTqJy9HArU22TuyxwGOmpbaSqUudwI5baO4qK4bmyx4psTUkUlPwiEJuKq4KLKm7uEsiGiRgKigm5hsT7zALM7zMwL135t77fX5z53o/f8wZhpnvfT5zZ+De+3tzK+fuJNwcXQBbdF0to+tqGV1Xy+i6WkbX1TK6rpbRdbWMrqtldF0to+tqGV1XyzDWvXX9VvXt2oaGBuNd7u69PPr26+/Zh+X2WeleKy4uLb90qa7nb/r5eA0dPmLkPUzKYKFbeuxE3mXB394+c6b11mXkuICnHyAvhVw3/+CBMjueZiwq+sJ1bPAkb9pqaHUN23eU2v/slry8uKA3gu+iq4dU17AxySDxJcbcXN/IUFeSctqg0zWmxN2Q87pzkYnL/dHFdECmezb6hNyXFobNWOyBrKULKt3k2Hr5LzZuzY4fi6vFAhrdmgX7lAWUT4mejynFGhLdK+GFSiOaV5TFEdRGoVs27QogJaUysTcgxhoC3dJXr0JycsKT4L543SvTMbYclzsvCX3IAdetmY34JJs58tcYWJYZuO7C08CwpFFTgWkcXjd1LzRuib8fNA+sW/FnbF7te3ugB9Bg3b/UYvO4/K1vIOOwuof+CY1rY+Uk5Ek/VLflY2SaGUPCEmAaVHd/ETKtnS/ne+LCoLobkGEd1G3+ABeG1P2P4hMDXr6KuhuWhdTdAsyy4EYG7lgDqHv7AC7Lip2q1M1owGVZkVfug4pC6uKirDHueRcVhdO9IftSnE0Oq1D3UAssqjvfXX0YlITTzYYl9cCYjfpjBdM1HkUl8XBMdbolP6OSeDiOCoLp/g8VxMflyoGYIJjuKVQQf/qdpVvwAiYHpdvyAyiIn2JQDkq3XEELmB1IaBQXBaWLqkeAi429IDko3QugHAGaK4ZCclC6uKYDfi6rS1e4IxGGSkwMSvcnUI4QoE8PSvcmKEeIW5gYlK6sTjbs851l74LyQbqNtEcZHFeNiQHpSu0dJ5lfMDEgXdCbL8xtTIy+d+Vwh+miW7F7bsDogohxFt2WekgfK2fR5erU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';
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $username; ?> / <?php echo $_SERVER['SERVER_NAME']; ?></title>
<link rel="stylesheet" href="styles/topnav.css">
<link rel="stylesheet" href="styles/font-awesome.css">
<link rel="stylesheet" href="styles/style.css">
<script src="script/script.js"></script>
<script>
function active() {
	var href = document.getElementsByTagName("a");
	var proto = window.location.protocol;
	var host = window.location.host;
	var path = window.location.pathname;
	var url = window.location.href;
	//var newUrl = new URL(url);
	var get = window.location.search;
	var query = get.substring(6);
	var pageArray = query.split("&",1);
	var page = pageArray.toString();
	var session = "<?php if(isset($_SESSION['SES_USER'])) {echo $_SESSION['SES_USER']; } else {echo ""; } ?>";
	if(page != null) {
	for (x = 0;x<href.length;x++) {
		var hr = href[x].href;
		if (hr == url) {
			href[x].classList.add('active');
		}
		else if (session == "" && page != "") {
			if (hr == proto+'//'+host+path+'?page=Login') {
				href[x].classList.add('active');
			}
		}
		else if (page == "" || page == "Halaman-Utama") {
			if (hr == url || hr == proto+'//'+host+path+'?page') {
				href[x].classList.add('active');
			}
		}
		else if (page.substr(0,4)=="User") {
			if (hr == proto+'//'+host+path+'?page=User-Data') {
				href[x].classList.add('active');
			}
		}
		else if (page.substr(0,8)=="Supplier") {
			if (hr == proto+'//'+host+path+'?page=Supplier-Data') {
				href[x].classList.add('active');
			}
		}
		else if (page.substr(0,9)=="Pelanggan") {
			if (hr == proto+'//'+host+path+'?page=Pelanggan-Data') {
				href[x].classList.add('active');
			}
		}
		else if (page.substr(0,8)=="Kategori") {
			if (hr == proto+'//'+host+path+'?page=Kategori-Data'){
				href[x].classList.add('active');
			}
		}
		else if (page.substr(0,6)=="Barang") {
			if (hr == proto+'//'+host+path+'?page=Barang-Data') {
				href[x].classList.add('active');
			}
		}
		else if (page == "Search") {
			if (hr == proto+'//'+host+path+'?page=Search') {
				href[x].classList.add('active');
			}
		}
		else if (page.substr(0,7) == "Laporan") {
			if (hr == proto+'//'+host+path+'?page=Laporan') {
				href[x].classList.add('active');
			}
		}
	}
	}
}
</script>
<style>
html,body {
	font-family:"Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif;
}
</style>
</head>

<body onLoad="active()">
<div class="topnav">
<button class="topnav-btn" onClick="sidebar()"><i class="fa fa-bars fa-fw"></i>&nbsp; Menu</button>
<span class="topnav-item">Shop Inventory</span>
</div>
<nav class="sidebar animateLeft" id="mySidebar"><br>
<div id="container" class="container">
<div class="col s4">
<?php
if(isset($_SESSION['SES_LOGIN'])) {
	echo "<img src='' class='avatar' id='avatar'>";
} else {
	echo "<img src='' class='avatar' id='avatar'>";
}?>
</div>
<script>
var avatar;

if(localStorage.getItem('avatar')) {
	avatar = localStorage.getItem('avatar');
} else {
	avatar = '<?php echo $avatar; ?>';
	localStorage.setItem('avatar',avatar);
}
document.getElementById('avatar').src = 'data:image/png;base64,'+avatar;
</script>
<div class="col s8 bar">
<span>Welcome, <strong><?php echo $username; ?></strong><br><i>Connected at <?php echo $_SERVER['HTTP_HOST'] ?></i></span><br><br>
<span>&nbsp;</span>
</div>
</div>
<hr>
<div class="container">
<h5>Dashboard</h5>
</div>
<div class="bar-block">
<?php if(isset($_SESSION['SES_ADMIN'])) {?>
    <a class="bar-item btnClose" onclick="sidebar()" title="close menu"><i class="fa fa-remove fa-fw"></i>&nbsp; Close Menu</a>
    <a href="?page" class="bar-item btn"><i class="fa fa-home fa-fw"></i>&nbsp; Overview</a>
    <a href="?page=User-Data" class="bar-item btn"><i class="fa fa-id-card fa-fw"></i>&nbsp; User Data</a>
    <a href="?page=Supplier-Data" class="bar-item btn"><i class="fa fa-truck fa-fw"></i>&nbsp; Supplier Data</a>
    <a href="?page=Pelanggan-Data" class="bar-item btn"><i class="fa fa-users fa-fw"></i>&nbsp; Customer Data</a>
    <a href="?page=Kategori-Data" class="bar-item btn"><i class="icon icon-drawer icon-fw"></i>&nbsp; Category Data</a>
    <a href="?page=Barang-Data" class="bar-item btn"><i class="fa fa-database fa-fw"></i>&nbsp; Items Data</a>
    <a href="?page=Search" class="bar-item btn"><i class="fa fa-search fa-fw"></i>&nbsp; Search</a>
    <a href="pembelian" target="_blank" class="bar-item btn"><i class="fa fa-exchange fa-fw"></i>&nbsp; Buy</a>
    <a href="penjualan" target="_blank" class="bar-item btn"><i class="fa fa-shopping-cart fa-fw"></i>&nbsp; Sell</a>
    <a href="?page=Laporan" class="bar-item btn"><i class="fa fa-line-chart fa-fw"></i>&nbsp; Sales Report</a>
    <a href="?page=Logout" class="bar-item logout"><i class="fa fa-sign-out fa-fw"></i>&nbsp; Logout</a><br><br>
<?php
}
elseif (isset($_SESSION['SES_CASHIER'])) {
?>
    <a class="bar-item btnClose" onclick="sidebar()" title="close menu"><i class="fa fa-remove fa-fw"></i>&nbsp; Close Menu</a>
    <a href="pembelian" target="_blank" class="bar-item btn"><i class="fa fa-exchange fa-fw"></i>&nbsp; Buy</a>
    <a href="penjualan" target="_blank" class="bar-item btn"><i class="fa fa-shopping-cart fa-fw"></i>&nbsp; Sell</a>
    <a href="?page=Logout" class="bar-item logout"><i class="fa fa-sign-in fa-fw"></i>&nbsp; Logout</a><br><br>
<?php
}
else {
?>
    <a class="bar-item btnClose" onclick="sidebar()" title="close menu"><i class="fa fa-remove fa-fw"></i>&nbsp; Close Menu</a>
    <a href="?page=Login" class="bar-item btn"><i class="fa fa-sign-in fa-fw"></i>&nbsp; Login</a><br><br>
<?php } ?>
</div>
</nav>
<div class="overlay" id="myOverlay" style="cursor:pointer" onClick="sidebar()" title="close side menu"></div>

/** Old script **/
<script>
// Sidebar Active Styling
var mySidebar = document.getElementById("mySidebar");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidebar, and add overlay effect
function sidebar() {
    if (mySidebar.style.display === 'block') {
        mySidebar.style.display = 'none';
        overlayBg.style.display = "none";
    } else {
        mySidebar.style.display = 'block';
        overlayBg.style.display = "block";
    }
}
</script>

<div class="main">
<?php
if(isset($_GET['page'])) {
if(substr($_GET['page'],-4,4) == "Edit") {
	$edit = strlen($_GET['page']);
	$pageLen = $edit - 5;
	$page = substr($_GET['page'],0,$pageLen);
	echo "<a href='?page=$page-Data'><i class='fa fa-arrow-left fa-fw'></i>Back</a>";
} else if(substr($_GET['page'],-3,3) == "Add") {
	$add = strlen($_GET['page']);
	$pageLen = $add-4;
	$page = substr($_GET['page'],0,$pageLen);
	echo "<a href='?page=$page-Data'><i class='fa fa-arrow-left fa-fw'></i>Back</a>";
}
}
?>
<?php include 'buka_file.php'; ?>
</div>
</div>
</body>
</html>