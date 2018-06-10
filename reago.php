<?php include "db.php";?>
<?php include "kapo.php";?>
<?php include "menuo.php";?>
<?php malfermiDatumbazon();?>
	<div id="bonvenon"><p>&nbsp;</p></div>
		<div id="ludo">
			<div id="parto">
				<p>Uzu tiun formularon por sendi mesa&#285;on al la administrantoj de la ludo. 
				Anka&#365; vi ricevos kopion de tiu mesa&#285;o.</p>
				<form method="post" action="reago2.php">
				<?php $sendinto=troviRetadreson($_SESSION['sam_id']); ?>
				<?php if ($sendinto) {
					echo "<input type='hidden' name='sendinto'  value='".$sendinto."'>";
				} else { 
				?>
				<p>Via retadreso (deviga):<br/>
				<input type='text' name='sendinto' size='50' value="<?if ($_GET["sendinto"]) {echo $sendinto;}else {echo "";}?>" onFocus="this.value=''">
				</p>
				<?php } ?>
				<p>Via mesa&#285;o:<br/>
				<textarea name="komento" rows="8" cols="60"  onkeyup='xAlUtf8(this)' ><?if ($_GET["komento"]) {echo $komento;}?></textarea>
				</p><p>
				<input class="sendu" type="image" src="style/sendu.gif" onMouseOver="this.src='style/sendu2.gif';" onMouseOut="this.src='style/sendu.gif';" onClick="this.form.submit();">
				</p>
				</form>
			</div>
		</div>
<?php include "piedo.php";?>