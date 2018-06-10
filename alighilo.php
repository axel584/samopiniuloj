<?php include "db.php";?>
<?php include "kapo.php";?>
<?php include "menuo.php";?>
	<div id="bonvenon"><p>&nbsp;</p></div>
	<div id="ludo">
		<h1>Ali&#285;ilo</h1>
		<form action='alighilo2.php' method='post'>
			<table>
				<tr><td class="titolo">Enirnomo:</td><td><input type='text' name='nomo' size='20' /></td></tr>
				<tr><td class="titolo">Pasvorto:</td><td><input type='password' name='pasvorto' size='20' /></td></tr>
				<tr><td class="titolo">Retadreso:</td><td><input type='text' name='retadreso' size='30' /></td></tr>
				<tr><td class="titolo">Lando:</td>
				<td>
					<select name=lando>
    				<option value=\"XX\" selected>&nbsp;</option>
					<?php 
					$landoj= listiLandojn(); 
					foreach ($landoj as $lando) {
					?>
					<option value="<?=$lando['kodo']?>"><?=$lando['nomo']?></option>";  
     				<?
				     /*
				     if (($aliavaluo!="") || ($aliavidigito!="")) {
				          echo "<option value=\"$aliavaluo\" ";
				          if ($aliavaluo==$elektita) { echo "selected";}
				          echo " >".$aliavidigito."</option>";
				     }
				     */
					}
     				?>
     				</select>
				</td></tr>					
			</table>
			<input class="sendu" type="image" src="style/aligxu.gif" onMouseOver="this.src='style/aligxu2.gif';" onMouseOut="this.src='style/aligxu.gif';" onClick="this.form.submit();" />
		</form>
	</div>
<?php include "piedo.php";?>