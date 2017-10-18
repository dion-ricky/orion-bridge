<?php
include_once "library/inc.seslogin.php";
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<style>
body, html {
	height:100%;
	margin:0;
	border:0;
}
h1,h2,h3,var {
	font-family:Aleo;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}
h1 {
	position:absolute;
	font-size:72px;
	top:28%;
	left:50%;
	transform:translate(-50%,-50%);
	text-align:center;
}
h2 {
	font-size:48px;
	text-align:center;
	position:absolute;
	top:40%;
	left:50%;
	transform:translate(-50%,-50%);
}
h3 {
	text-align:center;
	position:absolute;
	top:57%;
	left:50%;
	transform:translate(-50%,-50%);
}
var {
	font-size:14px;
}
</style>
</head>

<body>
<var>#ERRCODE: 404</var>
<h1>^.^</h1>
<h2>#404</h2>
<h3>It looks like the link you are visiting does not exists.<br>The page could have been deleted by the Administrator or the link has expired.<br>Please re-check the link or contact the Administrator for more information.<br>#Thanks</h3>
<h4 id="redirect"></h4>
</body>
<script>
var count = 5;
var elem = document.getElementById('redirect');
elem.innerHTML = 'Redirecting in '+count;
setInterval(function() {
	if(count>1) {
	count--;
	elem.innerHTML = 'Redirecting in '+count;
	} else {
	javascript:history.back();
	}
},1000);
</script>
</html>