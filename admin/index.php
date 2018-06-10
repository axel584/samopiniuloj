<? 
session_start();
include "../db.php";
malfermiDatumbazon();
date_default_timezone_set('Europe/Paris');
$tago=$_REQUEST["tago"];
$monato=$_REQUEST["monato"];
if ($monato=="") {
	$monato = date('m');
}
$jaro=$_REQUEST["jaro"];
if ($jaro=="") {
	$jaro = date('Y');
}
if (($_SESSION['sam_id']=="2")||($_SESSION['sam_id']=="6")) {
	?>
	<html>
	<head>
	<title>Samopiniuloj</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="KEYWORDS" content="Samopiniuloj" />
	<script type="text/javascript" src="xAlUtf8.js"></script>
	<link type="text/css" rel="stylesheet" href="../style/sam.css" title="Samopiniuloj">
	<!-- PROGRAMME JAVASCRPT POUR INSERER LE TAG <RAD> automatiquement -->
	<script type="text/javascript">
	<!--
	function insertion(repdeb, repfin) {
	var input = document.formularo.vorto;
  	input.focus();
	/* Insertion du code de formatage */
	    	var start = input.selectionStart;
	    	var end = input.selectionEnd;
	    	var insText = input.value.substring(start, end);
	    	input.value = input.value.substr(0, start) + repdeb + insText + repfin + input.value.substr(end);
	    	/* Ajustement de la position du curseur */
	    	var pos;
	    	if (insText.length == 0) {
	      		pos = start + repdeb.length;
	    	} else {
	      		pos = start + repdeb.length + insText.length + repfin.length;
	    	}
	    	input.selectionStart = pos;
	    	input.selectionEnd = pos;
  	}
  	
  	function insertVorton(vorto) {
  		// on decoupe pour enlever /dosiero et le .jpg
  		var novaVorto = vorto.substring(10,vorto.length-4);
  		var unuaLitero = vorto.substring(9,10);
		
  		//document.formularo.vorto.value = unuaLitero.toUpperCase() + novaVorto;
  		document.formularo.vorto.value = unuaLitero + novaVorto;
  	}
//-->
</script>
	</head>
	<body>
	
	<div id="listo">
		<table class="jaro">
			<tr>
				<td><a href="?jaro=2005&monato=<?=$monato?>" <?if ($jaro==2005){echo "class='nuna'";}?>>2005</a></td>
				<td><a href="?jaro=2006&monato=<?=$monato?>" <?if ($jaro==2006){echo "class='nuna'";}?>>2006</a></td>
				<td><a href="?jaro=2007&monato=<?=$monato?>" <?if ($jaro==2007){echo "class='nuna'";}?>>2007</a></td>
				<td><a href="?jaro=2008&monato=<?=$monato?>" <?if ($jaro==2008){echo "class='nuna'";}?>>2008</a></td>
				<td><a href="?jaro=2009&monato=<?=$monato?>" <?if ($jaro==2009){echo "class='nuna'";}?>>2009</a></td>
				<td><a href="?jaro=2010&monato=<?=$monato?>" <?if ($jaro==2010){echo "class='nuna'";}?>>2010</a></td>
				<td><a href="?jaro=2011&monato=<?=$monato?>" <?if ($jaro==2011){echo "class='nuna'";}?>>2011</a></td>
				<td><a href="?jaro=2012&monato=<?=$monato?>" <?if ($jaro==2012){echo "class='nuna'";}?>>2012</a></td>
				<td><a href="?jaro=2013&monato=<?=$monato?>" <?if ($jaro==2013){echo "class='nuna'";}?>>2013</a></td>
				<td><a href="?jaro=2014&monato=<?=$monato?>" <?if ($jaro==2014){echo "class='nuna'";}?>>2014</a></td>
				<td><a href="?jaro=2015&monato=<?=$monato?>" <?if ($jaro==2015){echo "class='nuna'";}?>>2015</a></td>
				<td><a href="?jaro=2016&monato=<?=$monato?>" <?if ($jaro==2016){echo "class='nuna'";}?>>2016</a></td>
				<td><a href="?jaro=2017&monato=<?=$monato?>" <?if ($jaro==2017){echo "class='nuna'";}?>>2017</a></td>
				<td><a href="?jaro=2018&monato=<?=$monato?>" <?if ($jaro==2018){echo "class='nuna'";}?>>2018</a></td>
				<td><a href="?jaro=2019&monato=<?=$monato?>" <?if ($jaro==2019){echo "class='nuna'";}?>>2019</a></td>
				<td><a href="?jaro=2020&monato=<?=$monato?>" <?if ($jaro==2020){echo "class='nuna'";}?>>2020</a></td>
				<td><a href="?jaro=2021&monato=<?=$monato?>" <?if ($jaro==2021){echo "class='nuna'";}?>>2021</a></td>
				<td><a href="?jaro=2022&monato=<?=$monato?>" <?if ($jaro==2022){echo "class='nuna'";}?>>2022</a></td>
				<td><a href="?jaro=2023&monato=<?=$monato?>" <?if ($jaro==2023){echo "class='nuna'";}?>>2023</a></td>
				<td><a href="?jaro=2024&monato=<?=$monato?>" <?if ($jaro==2024){echo "class='nuna'";}?>>2024</a></td>
				<td><a href="?jaro=2025&monato=<?=$monato?>" <?if ($jaro==2025){echo "class='nuna'";}?>>2025</a></td>
				<td><a href="?jaro=2026&monato=<?=$monato?>" <?if ($jaro==2026){echo "class='nuna'";}?>>2026</a></td>
				<td><a href="?jaro=2027&monato=<?=$monato?>" <?if ($jaro==2027){echo "class='nuna'";}?>>2027</a></td>
			</tr>
		</table>	
		<table class="jaro">
			<tr>
				<td><a href="?monato=1&jaro=<?=$jaro?>" <?if ($monato==1){echo "class='nuna'";}?>>jan</a></td>
				<td><a href="?monato=2&jaro=<?=$jaro?>" <?if ($monato==2){echo "class='nuna'";}?>>feb</a></td>
				<td><a href="?monato=3&jaro=<?=$jaro?>" <?if ($monato==3){echo "class='nuna'";}?>>mar</a></td>
				<td><a href="?monato=4&jaro=<?=$jaro?>" <?if ($monato==4){echo "class='nuna'";}?>>apr</a></td>
				<td><a href="?monato=5&jaro=<?=$jaro?>" <?if ($monato==5){echo "class='nuna'";}?>>maj</a></td>
				<td><a href="?monato=6&jaro=<?=$jaro?>" <?if ($monato==6){echo "class='nuna'";}?>>jun</a></td>
				<td><a href="?monato=7&jaro=<?=$jaro?>" <?if ($monato==7){echo "class='nuna'";}?>>jul</a></td>
				<td><a href="?monato=8&jaro=<?=$jaro?>" <?if ($monato==8){echo "class='nuna'";}?>>a&#365;g</a></td>
				<td><a href="?monato=9&jaro=<?=$jaro?>" <?if ($monato==9){echo "class='nuna'";}?>>sep</a></td>
				<td><a href="?monato=10&jaro=<?=$jaro?>" <?if ($monato==10){echo "class='nuna'";}?>>okt</a></td>
				<td><a href="?monato=11&jaro=<?=$jaro?>" <?if ($monato==11){echo "class='nuna'";}?>>nov</a></td>
				<td><a href="?monato=12&jaro=<?=$jaro?>" <?if ($monato==12){echo "class='nuna'";}?>>dec</a></td>
			</tr>
		</table>
		<div id="kartoj">
			<? 
			$rezultoj = montriMonaton($monato,$jaro);
			foreach ($rezultoj as $rezulto) {
				echo "<div class=\"bildeto\">\n";
				//echo "<a href='index.php?jaro=".$jaro."&monato=".$monato."&tago=".$rezulto['tago']."'>";
				//echo "<img src='".$rezulto['dosiero']."' width='70' height='70' /></a>\n";
				echo "<p><a href='index.php?jaro=".$jaro."&monato=".$monato."&tago=".$rezulto['tago']."'>".$rezulto['tago'].". ".x2utf($rezulto['vorto'])."</a></p>";
				echo "</div>\n";		
			}
			?>
		</div>
		<div style='clear:both'>		
		<?	
			$vorto_id=$_REQUEST['vorto_id'];
			if ($_REQUEST['UPDATE']!=null) {
				updateVorton($_REQUEST['id'],$_REQUEST['tago'],$_REQUEST['monato'],$_REQUEST['jaro'],$_REQUEST['vorto'],$_REQUEST['dosiero']);
			} elseif ($_REQUEST['INSERT']!=null) {
				$vorto_id = insertVorton($_REQUEST['tago'],$_REQUEST['monato'],$_REQUEST['jaro'],$_REQUEST['vorto'],$_REQUEST['dosiero']);
			} else {
				editVorton($tago, $monato, $jaro);
			}
			?>
		</div>
	</div>
	</body>
	</html>
<? 
} else {
	header('location:../index.php');	
}
?>