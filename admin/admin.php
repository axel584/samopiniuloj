<? 
session_start();
$pagxo="admin";
include "../db.php";
malfermiDatumbazon();
date_default_timezone_set('Europe/Paris');
if (($_SESSION['sam_id']=="2")||($_SESSION['sam_id']=="4")||($_SESSION['sam_id']=="6")) {
	$temo=$_REQUEST['temo'];
	if ($_REQUEST['tago']!=null) {$tago = $_REQUEST['tago'];} else {$tago = date('d');}
	if ($_REQUEST['monato']!=null) {$monato = $_REQUEST['monato'];} else {$monato = date('m');}
	if ($_REQUEST['jaro']!=null) { $jaro = $_REQUEST['jaro'];} else {$jaro = date('Y');}
	if ($temo=="") {$temo="cxiuj";}
	?>
	<body>
	<html>
	<title>Samopiniuloj</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link type="text/css" rel="stylesheet" href="https://samopiniuloj.esperanto-jeunes.org/style/sam.css" title="Samopiniuloj-admin">
	<script type="text/javascript" src="xAlUtf8.js"></script>
	</head>
	<body>
	<div id="kapo">
		<div id="titolo">
			<h1>Samopiniuloj</h1>
		</div>
	</div>
	<div id="menuo">
	</div>

	<div id="enhavo">
		<div id="ongleto">
			<ul>
				<li><a href="admin.php?temo=cxiuj" <?if ($temo=="cxiuj") {echo " class='elektita'";}?>>&#265;iuj ludantoj</a></li>
				<li><a href="admin.php?temo=jamludis" <?if ($temo=="jamludis") {echo " class='elektita'";}?>>jam ludis</a></li>
				<li><a href="admin.php?temo=protokolo" <?if ($temo=="protokolo") {echo " class='elektita'";}?>>protokolo</a></li>
				<li><a href="admin.php?temo=kalkuli" <?if (($temo=="kalkuli")||($temo=="kalkuli2")) {echo " class='elektita'";}?>>kalkuli</a></li>
			</ul>
		</div>
		<div id="adminejo">
			<? if ($temo=="cxiuj") { ?>
				<div class="parto">
					<h2>Ludantoj:</h2>
					<div id="protokolo">
						<?	
						// sercxas liston de cxiuj ludantoj
						$ludantoj = listiCxiujnLudantojn();
						?>
						<table>
						<tr style="text-align:center;font-weight:bold">
							<td>ludanto</td>
							<td class='rimarko'>lando</td>
							<td>ali&#285;dato</td>
							<td class='rimarko'>nomo</td>
							<td>reatdreso</td>
							<td class='rimarko'>ekrano</td>
						</tr>
						<?  
						foreach ($ludantoj as $ludanto) {
						?>
						<tr>
							<td><?=$ludanto['id'] ?></td>
							<td class='rimarko'><?=$ludanto['lando'] ?></td>
							<td><?=$ludanto['kreado'] ?></td>
							<td class='rimarko'><?=$ludanto['kromnomo'] ?></td>
							<td><?=$ludanto['retadreso'] ?></td>
							<td class='rimarko'><?=$ludanto['ekrano'] ?></td>
						</tr>
						<?
						}
						?>
						</table>
					</div>
				</div>
			<? } elseif ($temo=="jamludis") { ?>
				<div class="parto">
					<div class="dato">
						<? 
						$t = pasintadmintago($tago,$monato,$jaro);
						if ($t!=null) {echo "<span class='retroen'><a href='".$_SERVER['SCRIPT_URI']."?temo=jamludis&tago=".date('d',$t)."&monato=".date('m',$t)."&jaro=".date('Y',$t)."'><img src='../style/retroen.gif' title='retroen' alt='retroen' /></a></span>\n";}	
						echo 0+$tago." ".$monatnomo[0+$monato]." ".$jaro;
						$t = venontadmintago($tago,$monato,$jaro);
						if ($t!=null) {echo "<span class='antauxen'><a href='".$_SERVER['SCRIPT_URI']."?temo=jamludis&tago=".date('d',$t)."&monato=".date('m',$t)."&jaro=".date('Y',$t)."'><img src='../style/antauxen.gif' title='antauxen' alt='antauxen' /></a></span>\n";}
							
						?>
					</div>
				<p>La vorto de tiu tago estas :</p>
				<p class="vorto"><?=troviVorton($tago,$monato,$jaro);?></p>
					<div id="vorto"><img src='<?=troviBildon($tago,$monato,$jaro);?>' /></div>
				</div>
				<div class="parto">				
					<h2>Ludantoj:</h2>
					<div id="ludantoj">
						<?	
						$ludintoj=listiNunajnLudantojn($tago, $monato, $jaro);
						$nbLudintoj = sizeof($ludintoj);						 
						?>
						<table>
						<? foreach ($ludintoj as $ludinto) { ?>
							<tr><td><?=$ludinto['kromnomo']?></td>
							<td class='rimarko'>(<?=$ludinto['lando']?>)</td>
							<td><?=$ludinto['retadreso']?></td>
							<td class='rimarko'>(<?=$ludinto['sumo']?>)</td>						
						<? } ?>
						</table>
					</div>
					<p class="rimarko">
					<? if ($nbLudintoj>0) {
						echo "Entute ".$nbLudintoj." homoj ludis";
					}
					?>
					</p>
				</div>
			<? } elseif ($temo=="protokolo") { ?>
				<div class="adminejo">
					<h2>Ludantoj:</h2>
					<div id="protokolo">
						<?	montriProtokolon(); ?>
					</div>
				</div>
			<? } elseif ($temo=="kalkuli") { ?>
				<div class="adminejo">
					<h2>Kalkuli poentojn por la dato:</h2>
					<div id="protokolo">
						<form action="admin.php" method="get">
							<input type="hidden" name="temo" value="kalkuli2" />
							tago: <input type='text' name='kaltago' size='2' value='' />&nbsp;
							monato: <input type='text' name='kalmonato' size='2' value='' />&nbsp;
							jaro: <input type='text' name='kaljaro' size='4' value='' /><br/>
	  						Cu la sistemo sendu mesagojn al la ludanto?<br/>
	  						ne: <input type="radio" name="sendiMsg" value="ne" checked/>
	  						&nbsp;&nbsp;jes:<input type="radio" name="sendiMsg" value="jes"/><br/>
	  						<input type="submit" value="sendu"/>
  						</form>
  					</div>
				</div>
			<? } elseif ($temo=="kalkuli2") { ?>
				<div class="adminejo">
					<h2>Kalkuli poentojn por la dato:
					<?=$_GET["kaltago"]?>.<?=$_GET["kalmonato"]?>.<?=$_GET["kaljaro"]?></h2>
					<div id="protokolo">
					<? 
					$poentoj=rekalkuli($_GET["kaltago"],$_GET["kalmonato"],$_GET["kaljaro"]);
					echo "<table>";
					foreach ($poentoj as $poento) {
						echo "<tr><td>".$poento['propono']." - ".$poento['kiom']."</td></tr>";
					}
					echo "</table>";
					if ($_GET["sendiMsg"]=="jes") {
						echo "Envoi des résultats par mail";
						sendiRezultojn($_GET["kaltago"],$_GET["kalmonato"],$_GET["kaljaro"]);
					}
					?>
 					</div>
				</div>
			<? } ?>
		</div>
	<?
	include "../piedo.php";
} else {
	header('location:../index.php');
}
?>	