<?php 
$pagxo="rezultoj";
include "db.php";
malfermiDatumbazon();
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
	// kontroli cxiu fripono ne provas vidi rezultojn por hodiaux aux vidi vortojn por venonta tago
	if ($jaro.$monato.$tago > date('Y',$hier).date('m',$hier).date('d',$hier)) {
		$jaro = date('Y',$hier);
		$monato = date('m',$hier);
		$tago = date('d',$hier);
		$fripono=TRUE;
	}
	$eraro="Ne provu friponi";
	include "kapo.php";
	include "menuo.php";
	if ($_REQUEST['ludanto_id']!=null) {
		$ludanto_id=$_REQUEST['ludanto_id'];
	} else {
		$ludanto_id=$_SESSION['sam_id'];
	}
	

	$temo=$_REQUEST['temo'];
	if ($temo=="") {$temo="tago";}
	?>
		<div id="ongleto">
			<ul>
				<li><a href="rezulto.php?temo=tago" <?if ($temo=="tago") {echo " class='elektita'";}?>>la&#365; tago</a></li>
				<li><a href="rezulto.php?temo=monato" <?if ($temo=="monato") {echo " class='elektita'";}?>>la&#365; monato</a></li>
				<li><a href="rezulto.php?temo=vorto" <?if ($temo=="vorto") {echo " class='elektita'";}?>>la&#365; vorto</a></li>
				<li><a href="rezulto.php?temo=hodiaux" <?if ($temo=="hodiaux") {echo " class='elektita'";}?>>ludis hodia&#365;</a></li>
			</ul>
		</div>
		<div id="rezulto">
			<?php if ($temo=="tago") { ?>
				<div class="parto">
					<div class="dato">
						<?php $t = pasinttago($tago,$monato,$jaro);
						if ($t!=null) {echo "<span class='retroen'><a href='".$_SERVER['SCRIPT_URI']."?temo=".$temo."&tago=".date('d',$t)."&monato=".date('m',$t)."&jaro=".date('Y',$t)."'><img src='style/retroen.gif' title='retroen' alt='retroen' /></a></span>\n";}						
						echo 0+$tago." ".$monatnomo[0+($monato)]." ".$jaro;
						$t = venonttago($tago,$monato,$jaro);
						if ($t!=null) {echo "<span class='antauxen'><a href='".$_SERVER['SCRIPT_URI']."?temo=".$temo."&tago=".date('d',$t)."&monato=".date('m',$t)."&jaro=".date('Y',$t)."'><img src='style/antauxen.gif' title='antauxen' alt='antauxen' /></a></span>\n";}
						?>
					</div> <!-- dato -->
					<div>
						<?
						echo "<p class='klarigo'>La vorto de tiu tago estis: <b><br/>".troviVorton($tago, $monato, $jaro)."</b><br/></p>";
						?>
					</div>
					<?php if (($_SESSION['sam_id']!=null)&&($_SESSION['sam_id']!=0)&&($ludanto_id==$_SESSION['sam_id'])) {
							echo "<h2>Viaj proponoj :</h2>";
						} else {
							echo "<h2>Proponoj de ".troviNomon($ludanto_id)." :</h2>";
						}
					?>
					<div class="kadro">
						<?php 
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
							<?php } ?>
							</tbody><tfoot><tr><td>Sumo : </td><td class='kol2'><?=$sumo?></td></tr></tfoot>
							</table>
						<?php } ?>
					</div>
				</div>
				<div class="parto">
					<h2>Ludintoj :</h2>
					<div id="ludintoj">
						<?
						$ludintoj = montriRezulton($tago,$monato,$jaro);
						$nbLudintoj = sizeof($ludintoj);
						$i=0; $antauxa=0; $col=0; $vico=0;
						echo "<table><tr>";
						foreach ($ludintoj as $ludinto) {
							if ($i==0) { ?>
								<td valign='top' width='50%'><table>
							<?php } ?>
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
							<td><a href='rezulto.php?temo=tago&ludanto_id=<?=$ludinto['id']?>&tago=<?=$tago?>&monato=<?=$monato?>&jaro=<?=$jaro?>'><?=$ludinto['kromnomo']?></a></td>
							<td width='25' style='dekstre'><?=$ludinto['poentoj']?></td></tr>
							<?
							$i++;
							if (($i>($nbLudintoj/2))&&($col==0)) {$col=1; echo "</table></td><td valign='top' width='50%'><table>";}
						}
						?>
						</table></td></tr>
					</table>
					</div>
					<?php if ($nbLudintoj>0) { ?>
						<p class="rimarko"">Entute <?=$nbLudintoj?> homoj ludis por tiu vorto</p>
					<?php } ?>				
				</div>
			<?php } elseif ($temo=="vorto") { ?>
					<div class="dato">
						<?php $t = pasinttago($tago,$monato,$jaro);
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
					<p class='rimarko'>Atentu: se nur unu ludinto proponis iun vorton, tiu vorto gajnigas al la ludinto neniun poenton.</p>
			<?php } elseif ($temo=="monato") { ?>					
					<div class="dato">
						<?php $t = pasintmonato($tago,$monato,$jaro,$temo);
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
								<?php } ?>
								<tr <?if($_SESSION['sam_id']==$vorto['id']){echo " class='dika'";}?>>
								<td><?=$rang?></td><td><?=$vorto['kromnomo']?></td>
								<td class='rimarko'><?=$vorto['kiom']?></td></tr>
								<?php 
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
			
			<?php } elseif ($temo=="hodiaux") { ?>
					<h2>Jam ludis hodia&#365;:</h2>
					<div id="ludintoj style="width:800px">
					<?	$ludintoj=listiLudintojn(); 
						$nbLudintoj = sizeof($ludintoj);
					?>
						<table><tr>
					<?
						$i=0;
						foreach ($ludintoj as $ludinto) {
							if ($i==0) { ?>
								<td valign='top' width='25%'><table>
							<?php } ?>
							<tr <?if($_SESSION['sam_id']==$ludinto['id']){echo " class='dika'";}?>>
							<td><?=$ludinto['kromnomo'] ?></td>
							<td class='rimarko'>(<?=$ludinto['lando'] ?>)</td></tr>
							<?
							$i++; 
							if ($i>($nbLudintoj/4)) {$i=0; echo "</table></td>";}
						}
						
						if ($i) {echo"</table></td></tr>";}
						?>
					</table>
					<p class="rimarko">
					<?php if ($nbLudintoj>0) {
						echo "Entute ".$nbLudintoj." homoj jam ludis hodia&#365;";
					}
					?>
					</p>
					</div>
			<?php } ?>
		</div>
	<?
	include "piedo.php";
?>	
