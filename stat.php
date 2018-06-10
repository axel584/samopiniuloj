<?php
include "db.php";
malfermiDatumbazon();
// trovu tagon
if ($_REQUEST['tago']!=null) {
	$tago = $_REQUEST['tago'];
} else {
	$tago = date('d')-1;
}
// trovu monaton
if ($_REQUEST['monato']!=null) {
	$monato = $_REQUEST['monato'];
} else {
	$monato = date('m');
}
// trovu jaron
if ($_REQUEST['jaro']!=null) {
	$jaro = $_REQUEST['jaro'];
} else {
	$jaro = date('Y');
}
?>
<html>
<head>
<title>Statistikoj</title>
<link type="text/css" rel="stylesheet" href="/style/sam.css" title="Samopiniuloj">
</head>
<body>
	<div id="rezulto">
		<?
		if ($tago!=date('d') || $monato!=date('m') || $jaro!=date('Y')) {
			montriStatistikojn($tago,$monato,$jaro);
		} else {
			echo "Ah ah ah ! Fripono !!!";
		}
		?>
	</div>
</body>
</html>