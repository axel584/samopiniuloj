<?php 
malfermiDatumbazon();
?>
<?php if ($_SESSION['sam_id']==null) { ?>
<div id="eniro">
	<form name="enirform" action='eniri.php' method='post' onsubmit="atentu(this.form);return false;">
	<p>
	enirnomo:<br />
	<input type='text' name='nomo' size='15' onfocus="this.value=''" /><br/>
	pasvorto:<br />
	<input type='password' name='pasvorto' size='15' onfocus="this.value=''" /><br/>
	<input class="sendu" type="image" src="style/eniru.gif" onmouseover="this.src='style/eniru2.gif';" onmouseout="this.src='style/eniru.gif';" />
	</p></form>
</div>
<?php } ?>

<div id="menuo">
	<p><a class="akceptejo<?if ($pagxo=='akceptejo'){echo " elektita";}?>" href="index.php"><span>akceptejo</span></a></p>
	<?php if ($_SESSION['sam_id']!=null) { ?>
		<p><a class="ludi<?if ($pagxo=='ludo'){echo " elektita";}?>" href="ludu.php"><span>ludi</span></a></p>
		<!--p><a class="proponi<?if ($pagxo=='proponi'){echo " elektita";}?>" href="proponi.php"><span>proponi</span></a></p-->
		<p><a class="rezulto<?if ($pagxo=='rezultoj'){echo " elektita";}?>" href="rezulto.php?temo=tago"><span>rezulto</span></a></p>
		<p><a class="foriri" href="forigi.php"><span>foriri</span></a></p>
		<?php if (($_SESSION['sam_id']=="2")||($_SESSION['sam_id']=="6")) { ?>
			<p><a class="admin" href="admin/admin.php"><span>admin</span></a></p>			
		<?php } ?>
	<?php } else { ?>
	<p><a class="aligxilo<?if ($pagxo=='aligxilo'){echo " elektita";}?>" href="alighilo.php"><span>aligxilo</span></a></p>
		<p><a class="ludi<?if ($pagxo=='ludo'){echo " elektita";}?>" href="ludu.php"><span>ludi</span></a></p>
	<p><a class="rezulto<?if ($pagxo=='rezultoj'){echo " elektita";}?>" href="rezulto.php?temo=tago"><span>rezulto</span></a></p>
<?php } ?>
	<div id="horo">
		<p>Nun estas <b><?echo gmdate('H');?>:<?echo gmdate('i');?>&nbsp;UTC</b>.</p>
	</div>
	<div id="mesagxo">
		<form name="mesagxoform" action="reago.php" method="post">
		<p>Kontaktu nin:
		<input type="image" src="style/mesagxo.gif" style="vertical-align:middle" onclick="this.form.submit();" />
		</p></form>
	</div>
</div>
<div id="enhavo">