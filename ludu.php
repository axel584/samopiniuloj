<?php
session_start();
$pagxo="ludo";
include "db.php";
malfermiDatumbazon();
date_default_timezone_set('Europe/Paris');

	include "kapo.php";
	include "menuo.php";
	// prend les jours en parametre s'ils sont donnés ou alors le jour d'aujourd'hui
	if ($_REQUEST['tago']!=null) {$tago = $_REQUEST['tago'];} else {$tago = date('d');}
	if ($_REQUEST['monato']!=null) {$monato = $_REQUEST['monato'];} else {$monato = date('m');}
	if ($_REQUEST['jaro']!=null) { $jaro = $_REQUEST['jaro'];} else {$jaro = date('Y');}
	$pasintaTago = ($jaro.$monato.$tago < date('Y').date('m').date('d'));
	
	/*$tago = date('d');
	$monato = date('m');
	$jaro = date('Y');*/
	$nbprop=0;
	?>
	<div id="bonvenon"><p>
	<?php if ($_SESSION['sam_id']!=null) { 
		echo "Bonvenon, ".troviNomon($_SESSION['sam_id']); 
	} else {
		echo "&nbsp;";
	}?>
	</p></div>
		<div id="ludo">
			<div class="parto">		
				<div class="dato">
					<?php $t = pasintludtago($tago,$monato,$jaro);
					if ($t!=null) {	echo "<span class='retroen'><a href='".$_SERVER['SCRIPT_URI']."?tago=".date('d',$t)."&monato=".date('m',$t)."&jaro=".date('Y',$t)."'><img src='style/retroen.gif' title='retroen' alt='retroen' /></a></span>\n";}
					echo 0+$tago." ".$monatnomo[0+($monato)]." ".$jaro;
					$t = venontludtago($tago,$monato,$jaro);
					if ($t!=null) {echo "<span class='antauxen'><a href='".$_SERVER['SCRIPT_URI']."?tago=".date('d',$t)."&monato=".date('m',$t)."&jaro=".date('Y',$t)."'><img src='style/antauxen.gif' title='antauxen' alt='antauxen' /></a></span>\n";}						
					?>
				</div>
				<!--<span class="dato"><?php echo $tago." ".$monatnomo[$monato]." ".$jaro;?></span><br>-->
				<p>La vorto de tiu tago estas :</p>
				<p class="vorto"><?=x2utf(troviVorton($tago,$monato,$jaro));?></p>
				<!--<div id="vorto"><img src='<?=troviBildon($tago,$monato,$jaro);?>' /></div>-->
				<div id="vorto">Neniu bildo dum tiu monato... Ludu nur per la vorto !</div>
				<div id="rimarko"><p>Skribu viajn proponojn en la liberaj lokoj kaj alklaku la butonon "Sendu".</p> 
				<p>Vi rajtas proponi nur parton de la listo kaj kompletigi la liston poste. 
				Kiam viaj proponoj estos senditaj, vi rajtos &#349;an&#285;i ilin &#285;is la horlimo.</p>
				</div>
			</div>
			<div class="parto">
				<p>Viaj proponoj :<?php if ($pasintaTago==0){?><span class="rimarko"><br />(vi rajtas &#349;an&#285;i ilin &#285;is la horlimo)</span><?}?></p>
				<p class="rimarko">Tajpu cx, sx... por ricevi &#265;, &#349;...</p>
				<form name="ludoform" method='post' action='ludu2.php' onsubmit="atentu(this.form);document.getElementById('rimarko').style.visibility='hidden';">
				<input type='hidden' name='vorto_id' value='<?=troviVortonId($tago,$monato,$jaro);?>' />
				<table>
					<?php for ($i=0;$i<8;$i++) { 
						// Emmanuelle (7.10.2006) : conversion des x en lettres accentuées pour l'affichage
						$propono = x2utf(troviProponon(troviVortonId($tago,$monato,$jaro),$_SESSION['sam_id'],$i));
					?>
					<tr>
						<td class="num">&nbsp;<?echo $i+1; ?>&nbsp;</td>
						<?php if (($_SESSION['sam_id']==null)||($_SESSION['sam_id']==0)) { ?>
							<td><input class="jam pasinta" name="prop[<?=$i?>]" value="<?=$propono ?>" readonly /></td>
						<?php } else {      
							if ($propono!=null) { $nbprop++; }// cet increment était dans le else, normalement ca permet de compter le nombre de proposition deja faite, non ?
						?>
						<?php 	if ($pasintaTago) { ?>
							<td><input class="jam pasinta" type='input' name='prop[<?=$i?>]' value="<?=$propono ?>" readonly /></td>
						<?php } else { ?>
							<td><input <?if ($propono) {echo " class=\"jam\"";}?> type='input' name='prop[<?=$i?>]' value="<?=$propono?>" onkeyup='xAlUtf8(this)'  /></td>
						<?php } ?>
					<?php }?>
						</tr>
					<?php } ?>
				</table>
				<?php if (($_SESSION['sam_id']==null)||($_SESSION['sam_id']==0)) { ?>
					<p>Ensalutu por ludi. Por enskribi&#285;i, bonvolu plenigi la ali&#285;ilon.</p> 
				<?php } elseif ($pasintaTago==0) { ?>
						<p class="meze"><input class="sendu" type="image" src="style/sendu.gif" 
						onmouseover="this.src='style/sendu2.gif';" onfocus="this.src='style/sendu2.gif';" 
						onmouseout="this.src='style/sendu.gif';" onblur="this.src='style/sendu2.gif';" onclick="this.form.submit();" /></p>
					<?php } ?>
				</form>
			</div>
		</div> <!-- ludo -->
<?php include "piedo.php";?>