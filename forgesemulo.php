<?php 
$pagxo="rezultoj";
include "db.php";
malfermiDatumbazon();
date_default_timezone_set('Europe/Paris');
include "kapo.php";
include "menuo.php";
?>
<div id="forgesemulo">
<h2>Ĉu vi Forgesis vian pasvorton ?</h2>
<?php 
if ($_REQUEST["retadreso"]=="") {
?>
Entajpu vian retadreson por ricevi vian pasvorton : <br/>
<form method='post' action='forgesemulo.php'><input type='text' name='retadreso' value=''><input type='submit' value='Sendu'></form></div>
<?
} else {
	MesagxoForgesemulo($_REQUEST["retadreso"]);
?>
Ni sendis vian pasvorton. Bonvolu kontroli vian retskatolon.
<?php } ?>

<?
include "piedo.php";
?>