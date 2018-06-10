<?php
include "db.php";
malfermiDatumbazon();
date_default_timezone_set('Europe/Paris');
if ($_REQUEST['ludanto_id']!=null) {
	$ludanto_id=$_REQUEST['ludanto_id'];
} else {
	$ludanto_id=$_SESSION['sam_id'];
}
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
<html>
<head>
<title>Poentoj</title>
<link type="text/css" rel="stylesheet" href="/style/sam.css" title="Samopiniuloj">
</head>
<body>
	<div id="rezulto">
		<?php if ($ludanto_id==$_SESSION['sam_id']) {
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
					<tr><td class='kol1'><?=$rezulto['propono'] ?>:</td><td class='kol2'><?=$rezulto['poento'] ?></td></tr>
				<?php } ?>
				</tbody><tfoot><tr><td>Sumo : </td><td class='kol2'><?=$sumo?></td></tr></tfoot>
				</table>
			<?php } ?>
		</div>
	</div>
</body>
</html>