<?php 
$pagxo="statistikoj";
include "db.php";
malfermiDatumbazon();
include "kapo.php";
include "menuo.php";
?>
		<div id="ludo">
			<div id="parto">
<?

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
	<div id="rezulto">
		<div class="dato">
			<?php $t = pasinttago($tago,$monato,$jaro);
			if ($t!=null) {echo "<span class='retroen'><a href='".$_SERVER['SCRIPT_URI']."?temo=".$temo."&tago=".date('d',$t)."&monato=".date('m',$t)."&jaro=".date('Y',$t)."'><img src='style/retroen.gif' title='retroen' alt='retroen' /></a></span>\n";}						
			echo $tago." ".$monatnomo[$monato]." ".$jaro;
			$t = venonttago($tago,$monato,$jaro);
			if ($t!=null) {echo "<span class='antauxen'><a href='".$_SERVER['SCRIPT_URI']."?temo=".$temo."&tago=".date('d',$t)."&monato=".date('m',$t)."&jaro=".date('Y',$t)."'><img src='style/antauxen.gif' title='antauxen' alt='antauxen' /></a></span>\n";}
			?>
		</div>
		<div>
			<?
			echo "<p class='klarigo'>La vorto de tiu tago estis: <b>".troviVorton($tago, $monato, $jaro)."</b>. 
			</p><p class='klarigo'>Jen la vortoj, kiujn vi proponis :</p>";
			?>
		</div>
		<div class="stat">
			<iframe src="stat.php?tago=<?=$tago?>&monato=<?=$monato?>&jaro=<?=$jaro?>" name="statistikoj" width="350px" height="220px" scrolling="auto">
			</iframe>		
		</div>
	</div>
<?php include "piedo.php";?>