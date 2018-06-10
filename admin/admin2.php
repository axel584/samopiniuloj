<? 
session_start();
$pagxo="admin2";
include "../db.php";
malfermiDatumbazon();

function montriHodiauxajnProponojn ($tago,$monato,$jaro) {
	global $monatnomo;
	$query = "select sam_ludantoj.kromnomo,sam_ludantoj.id,sum(sam_proponoj.poento) as poentoj from sam_proponoj,sam_ludantoj,sam_vortoj where sam_proponoj.vorto_id=sam_vortoj.id and sam_proponoj.ludanto_id=sam_ludantoj.id and sam_vortoj.tago = '".$tago."' and sam_vortoj.monato = '".$monato."' and sam_vortoj.jaro ='".$jaro."' group by sam_ludantoj.id order by poentoj DESC";
	mysql_select_db("ikurso");
	$result = mysql_query($query) or die ("INSERT : Invalid query :".$query);
	$i=1;
	// emmanuelle : affichage des joueurs sur 2 colonnes
	$nbLudintoj=mysql_num_rows($result);
	while ($row = mysql_fetch_array($result)) {
		$ludintoj[$i]['poentoj']=$row['poentoj'];
		$ludintoj[$i]['kromnomo']=$row['kromnomo'];
		$ludintoj[$i]['id']=$row['id'];
		$i++;
	}
	return $ludintoj;
}

date_default_timezone_set('Europe/Paris');
	// trovu tagon
	$fripono=FALSE;
	$hier = time() - (24 * 60 * 60);
	if ($_REQUEST['tago']!=null) {
		$tago = $_REQUEST['tago'];
	} else {
		$tago = date('d',$hier);
	}
	// trovu monaton
	if ($_REQUEST['monato']!=null) {
		$monato = $_REQUEST['monato'];
	} else {
		$monato = date('m',$hier);
	}
	// trovu jaron
	if ($_REQUEST['jaro']!=null) {
		$jaro = $_REQUEST['jaro'];
	} else {
		$jaro = date('Y',$hier);
	}
	
	if (($_SESSION['sam_id']=="2")||($_SESSION['sam_id']=="4")||($_SESSION['sam_id']=="6")) {
	$temo=$_REQUEST['temo'];
	if ($_REQUEST['tago']!=null) {$tago = $_REQUEST['tago'];} else {$tago = date('d');}
	if ($_REQUEST['monato']!=null) {$monato = $_REQUEST['monato'];} else {$monato = date('m');}
	if ($_REQUEST['jaro']!=null) { $jaro = $_REQUEST['jaro'];} else {$jaro = date('Y');}
	if ($temo=="") {$temo="cxiuj";}
	
	if ($_REQUEST['ludanto_id']!=null) {
		$ludanto_id=$_REQUEST['ludanto_id'];
	} else {
		$ludanto_id=$_SESSION['sam_id'];
	}
	?>

	<body>
	<html>
	<title>Samopiniuloj</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link type="text/css" rel="stylesheet" href="http://samopiniuloj.esperanto-jeunes.org/dev/style/sam.css" title="Samopiniuloj-admin">
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
				<li><a href="admin2.php?temo=cxiuj" <?if ($temo=="cxiuj") {echo " class='elektita'";}?>>&#265;iuj ludantoj</a></li>
				<li><a href="admin2.php?temo=jamludis" <?if ($temo=="jamludis") {echo " class='elektita'";}?>>jam ludis</a></li>
				<li><a href="admin2.php?temo=proponoj" <?if ($temo=="proponoj") {echo " class='elektita'";}?>>proponoj</a></li>
				<li><a href="admin2.php?temo=protokolo" <?if ($temo=="protokolo") {echo " class='elektita'";}?>>protokolo</a></li>
				<li><a href="admin2.php?temo=kalkuli" <?if (($temo=="kalkuli")||($temo=="kalkuli2")) {echo " class='elektita'";}?>>kalkuli</a></li>
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
						if ($t!=null) {echo "<span class='retroen'><a href='".$_SERVER['SCRIPT_URI']."?temo=jamludis&tago=".date('d',$t)."&monato=".date('m',$t)."&jaro=".date('Y',$t)."'><img src='../../style/retroen.gif' title='retroen' alt='retroen' /></a></span>\n";}	
						echo 0+$tago." ".$monatnomo[0+$monato]." ".$jaro;
						$t = venontadmintago($tago,$monato,$jaro);
						if ($t!=null) {echo "<span class='antauxen'><a href='".$_SERVER['SCRIPT_URI']."?temo=jamludis&tago=".date('d',$t)."&monato=".date('m',$t)."&jaro=".date('Y',$t)."'><img src='../../style/antauxen.gif' title='antauxen' alt='antauxen' /></a></span>\n";}
							
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
			
			<? } elseif ($temo=="proponoj") { ?>
				<div class="parto">
					<div class="dato">
						<? $t = pasinttago($tago,$monato,$jaro);
						if ($t!=null) {echo "<span class='retroen'><a href='".$_SERVER['SCRIPT_URI']."?temo=".$temo."&tago=".date('d',$t)."&monato=".date('m',$t)."&jaro=".date('Y',$t)."'><img src='../style/retroen.gif' title='retroen' alt='retroen' /></a></span>\n";}						
						echo 0+$tago." ".$monatnomo[0+($monato)]." ".$jaro;
						$t = venonttago($tago,$monato,$jaro);
						if ($t!=null) {echo "<span class='antauxen'><a href='".$_SERVER['SCRIPT_URI']."?temo=".$temo."&tago=".date('d',$t)."&monato=".date('m',$t)."&jaro=".date('Y',$t)."'><img src='../style/antauxen.gif' title='antauxen' alt='antauxen' /></a></span>\n";}
						?>
					</div> <!-- dato -->
					<div>
						<p class="vorto"><?=troviVorton($tago,$monato,$jaro);?></p>
					</div>
					<div class="kadro">
						<? 
						$rezultoj=montriPoentojn($tago,$monato,$jaro,$ludanto_id);
						if ($rezultoj==null) {
							echo "Vi ne ludis tiun tagon !";
						} else {
							$sumo=0;
							echo "<table><tbody>";
							foreach ($rezultoj as $rezulto) {
								$sumo = $sumo + $rezulto['poento'];
							?>
								<tr><td class='kol1'><?=x2utf($rezulto['propono']) ?>:</td><td class='kol2'><?=$rezulto['poento'] ?></td></tr>
							<? } ?>
							</tbody><tfoot><tr><td>Sumo : </td><td class='kol2'><?=$sumo?></td></tr></tfoot>
							</table>
						<? } ?>
					</div>				
				</div>
				<div class="parto2">
					<h2>Ludintoj :</h2>
					<div id="ludintoj">
						<?
						$ludintoj = montriHodiauxajnProponojn($tago,$monato,$jaro);
						$nbLudintoj = sizeof($ludintoj);
						$i=0; $antauxa=0; $col=0; $vico=0;
						echo "<table><tr>";
						foreach ($ludintoj as $ludinto) {
							if ($i==0) { ?>
								<td valign='top' width='50%'><table>
							<? } ?>
							<tr <?if($_SESSION['sam_id']==$ludinto['id']){echo " class='dika'";}?>>
							<?
							if ($ludinto['poentoj']!=$antauxa) {
								$vico=$i+1;
								echo "<td class='rimarko' width='25'>".$vico."</td>"; 
							} else {
								echo "<td class='rimarko'>&nbsp;</td>";
							}
							$antauxa=$ludinto['poentoj'];
							?>
							<td><a href='admin2.php?temo=proponoj&ludanto_id=<?=$ludinto['id']?>&tago=<?=$tago?>&monato=<?=$monato?>&jaro=<?=$jaro?>'><?=$ludinto['kromnomo']?></a></td>
							<td width='25' style='dekstre'><?=$ludinto['poentoj']?></td></tr>
							<?
							$i++;
							if (($i>($nbLudintoj/2))&&($col==0)) {$col=1; echo "</table></td><td valign='top' width='50%'><table>";}
						}
						?>
						</table></td></tr>
					</table>
					</div>
					<? if ($nbLudintoj>0) { ?>
						<p class="rimarko"">Entute <?=$nbLudintoj?> homoj ludis por tiu vorto</p>
					<? } ?>				
				</div>
				
			<? } elseif ($temo=="vorto") { ?>
					<div class="dato">
						<? $t = pasinttago($tago,$monato,$jaro);
						if ($t!=null) {echo "<span class='retroen'><a href='".$_SERVER['SCRIPT_URI']."?temo=".$temo."&tago=".date('d',$t)."&monato=".date('m',$t)."&jaro=".date('Y',$t)."'><img src='style/retroen.gif' title='retroen' alt='retroen' /></a></span>\n";}						
						echo 0+$tago." ".$monatnomo[0+($monato)]." ".$jaro;
						$t = venonttago($tago,$monato,$jaro,$temo);
						if ($t!=null) {echo "<span class='antauxen'><a href='".$_SERVER['SCRIPT_URI']."?temo=".$temo."&tago=".date('d',$t)."&monato=".date('m',$t)."&jaro=".date('Y',$t)."'><img src='style/antauxen.gif' title='antauxen' alt='antauxen' /></a></span>\n";}
						?>
					</div>
					<div>
						<p class="klarigo">
						La vorto de tiu tago estis:<b><?=troviVorton($tago, $monato, $jaro) ?>
						</b>. Jen &#265;iuj proponitaj vortoj:</p>
					</div>
					<div id="stat">
						<?
						if ($tago!=date('d') || $monato!=date('m') || $jaro!=date('Y')) {
							$rezultoj=montriStatistikojn($tago,$monato,$jaro,$ludanto_id);
							// nombre de propositions total = taille du tableau
							$nbProponoj=count($rezultoj);
							// nombre d'élements par colonne = l'arrondi superieur dans la division par 4
							$nbParCol = ceil($nbProponoj / 4 );
							echo "<table><tr>";
							$i=0;
							// affichage des mots sur 4 colonnes
							foreach ($rezultoj as $rezulto) {
								//print_r($rezulto);
								if ($i==0) {echo "<td valign='top' width='25%'><table>";}
								echo "<tr";
								if ($rezulto['proponitaVorto'] > 0) {echo " style='font-weight:bold'";}
								echo "><td";
								if ($rezulto['kiom']==1) {echo " class=griza";};
								echo ">".x2utf($rezulto['propono'])."</td>";
								if ($rezulto['kiom']==1) {echo "<td class='helbruna'";}
								else {echo "<td class='rimarko'";}
								echo ">".$rezulto['kiom']."</td></tr>";
								$i++;
								// si $i a atteint le nombre d'element par colonne, on ferme une table (de la colonne)
								if ($i==$nbParCol) {$i=0; echo "</table></td>";}					
							}
							if ($i) {echo "</table></td></tr>";}
							echo "</table>";							
							
						} else {
							echo "Ha ha ha ! Fripono !!!";
						}
						?>
					</div>
					<p class='rimarko'>Atentu: se nur unu ludinto proponis iun vorton, tiu vorto gajnigas al li neniun poenton</p>
			<? } elseif ($temo=="monato") { ?>					
					<div class="dato">
						<? $t = pasintmonato($tago,$monato,$jaro,$temo);
						if ($t!=null) {echo "<span class='retroen'><a href='".$_SERVER['SCRIPT_URI']."?temo=monato&monato=".date('m',$t)."&jaro=".date('Y',$t)."'><img src='style/retroen.gif' title='retroen' alt='retroen' /></a></span>\n";}						
						echo $monatnomo[0+($monato)]." ".$jaro;
						$t = venontmonato($tago,$monato,$jaro,$temo);
						if ($t!=null) {echo "<span class='antauxen'><a href='".$_SERVER['SCRIPT_URI']."?temo=monato&monato=".date('m',$t)."&jaro=".date('Y',$t)."'><img src='style/antauxen.gif' title='antauxen' alt='antauxen' /></a></span>\n";}
						?>
					</div>
					<div id="stat">
						<?
						if ($tago!=date('d') || $monato!=date('m') || $jaro!=date('Y')) {
							$vortoj=listiMonatanRezultojn($monato,$jaro);
							$nbVortoj = sizeof($vortoj);
							echo "<table><tr>";
							$i=0; $rang=1;
							foreach ($vortoj as $vorto) {
								if ($i==0) { ?>
									<td valign='top' width='25%'><table>
								<? } ?>
								<tr <?if($_SESSION['sam_id']==$vorto['id']){echo " class='dika'";}?>>
								<td><?=$rang?></td><td><?=$vorto['kromnomo']?></td>
								<td class='rimarko'><?=$vorto['kiom']?></td></tr>
								<? 
								$i++;
								if ($i>($nbVortoj/4)) {$i=0; echo "</table></td>";}
								$rang++;
							}
							if ($i) {echo "</table></td></tr>";}
							echo "</table>";
						} else {
							echo "Ha ha ha ! Fripono !!!";
						}
						?>
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