<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html>
<head>
	<title>samopiniuloj</title>
	<meta http-equiv="content-type" content="Mime-Type; charset=utf-8" />
	<meta name="content-language" content="eo" />
	<meta http-equiv="Cache-Control" content="max-age=200" />		
	<link rel="stylesheet" type="text/css" href="sam.css" />
	<link rel="shortcut icon" href="http://samopiniuloj.esperanto-jeunes.org/ico.gif" />
</head>
<?
include "../db.php";
malfermiDatumbazon();
$eraro=$_REQUEST['eraro'];
if ($_SESSION['sam_id']) {
	$id=$_SESSION['sam_id'];
} elseif ($_POST['nomo']) {
	$nomo = $_POST['nomo'];
	$pasvorto = $_POST['pasvorto'];
	$id = kontroliPersonon($nomo,$pasvorto);
	if ($id==null) {
		$eraro="Malbona enirnomo aŭ pasvorto. Bonvolu retajpi.";
	} else {
		$_SESSION["sam_id"]=$id;
	}
}
	// prend les jours en parametre s'ils sont donnés ou alors le jour d'aujourd'hui
	if ($_REQUEST['tago']!=null) {$tago = $_REQUEST['tago'];} else {$tago = date('d');}
	if ($_REQUEST['monato']!=null) {$monato = $_REQUEST['monato'];} else {$monato = date('m');}
	if ($_REQUEST['jaro']!=null) { $jaro = $_REQUEST['jaro'];} else {$jaro = date('Y');}
	$pasintaTago = ($jaro.$monato.$tago < date('Y').date('m').date('d'));
	
?>
<body>
	<h1>Samopiniuloj</h1>
<? if (($id==null)||($id==0)) { ?>
	<div id="eniro">
		<? echo $eraro; ?>
		<form name="enirform" action='http://sam.esperanto-jeunes.org/mobi/index.php' method='post'>
		<p>enirnomo: <input type='text' name='nomo' /><br/>
		pasvorto: <input type='password' name='pasvorto' /><br/>
		<input type="submit" value=" eniru " />
		</p></form>
	</div>
<? } else {?>
	<div id="bonvenon">
		<p>Bonvenon, <? echo troviNomon($id); ?>!
	<div class="dato">
		<? $t = pasintludtago($tago,$monato,$jaro);
		if ($t!=null) {	
			echo "<a href='".$_SERVER['SCRIPT_URI']."?tago=".date('d',$t)."&monato=".date('m',$t)."&jaro=".date('Y',$t)."'><<< </a>\n";}
			echo "<strong>";
			echo 0+$tago." ".$monatnomo[0+($monato)]." ".$jaro."</strong>";
			$t = venontludtago($tago,$monato,$jaro);
			if ($t!=null) {echo "<a href='".$_SERVER['SCRIPT_URI']."?tago=".date('d',$t)."&monato=".date('m',$t)."&jaro=".date('Y',$t)."' >>>></a>\n";}						
		?>
	</div>
	<p>La vorto de tiu tago estas :</p>
	<h2><?=x2utf(troviVorton($tago,$monato,$jaro));?></h2>
	<br />
	<img src='<?=troviBildon($tago,$monato,$jaro);?>' />
	<? /*<div id="rimarko">
		<p>Vi rajtas proponi nur parton de la listo kaj kompletigi la liston poste. 
		Kiam viaj proponoj estos senditaj, vi rajtos ŝanĝi ilin ĝis la horlimo.</p>
	</div>
	*/ ?>
	<p>Skribu viajn proponojn en la liberaj lokoj kaj alklaku la butonon [Sendu].</p> 
	<p>Tajpu cx, sx... anstataŭ la ĉapeloj.</p>
	<? if ($eraro!="") { 
		echo "<p class='eraro'>".$eraro."! Bonvolu reprovi.</p>";
	} ?>
	<form name="ludoform" method='post' action='http://sam.esperanto-jeunes.org/mobi/index2.php' >
		<input type='hidden' name='vorto_id' value='<?=troviVortonId($tago,$monato,$jaro);?>' />
		<? for ($i=0;$i<8;$i++) { 
			// conversion des x en lettres accentuées pour l'affichage
			$propono = x2utf(troviProponon(troviVortonId($tago,$monato,$jaro),$_SESSION['sam_id'],$i));
			echo $i+1; 
			if (($id==null)||($id==0)) { ?>
				<input class="jam pasinta" name="prop[<?=$i?>]" value="<?=$propono ?>" readonly /><br />
			<? } else {      
				if ($propono!=null) { $nbprop++; }// cet increment était dans le else, normalement ca permet de compter le nombre de proposition deja faite, non ?
 				if ($pasintaTago) { ?>
					<input class="jam pasinta" type='input' name='prop[<?=$i?>]' value="<?=$propono ?>" readonly /><br />
				<? } else { ?>
					<input <?if ($propono) {echo " class=\"jam\"";}?> type='input' name='prop[<?=$i?>]' value="<?=$propono?>" /><br />
				<? } 
				}
			} 
			if ($pasintaTago==0) { ?>
				<p><input type="submit" value=" sendu " /></p>
			<? } ?>
	</form>
	<div class="dato">
		<? $t = pasintludtago($tago,$monato,$jaro);
		if ($t!=null) {	
			echo "<a href='".$_SERVER['SCRIPT_URI']."?tago=".date('d',$t)."&monato=".date('m',$t)."&jaro=".date('Y',$t)."'><<< </a>\n";}
			echo "<strong>";
			echo 0+$tago." ".$monatnomo[0+($monato)]." ".$jaro."</strong>";
			$t = venontludtago($tago,$monato,$jaro);
			if ($t!=null) {echo "<a href='".$_SERVER['SCRIPT_URI']."?tago=".date('d',$t)."&monato=".date('m',$t)."&jaro=".date('Y',$t)."' >>>></a>\n";}						
		?>
	</div>
<? }?>

</body>
</html>