<?
$nb_max_points = 29;
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set("Europe/Paris");
$db = sqlite_open("ww.db");
// initialisation de la base si la table ww n'est pas trouvŽ
$result = sqlite_query($db, "SELECT count(*) as combien FROM sqlite_master WHERE type='table' and name='ww'");
$row = sqlite_fetch_array($result);
if ($row['combien']==0) {
// on creer la table
	sqlite_query($db, "CREATE TABLE ww (id INTEGER PRIMARY KEY, aliment CHAR(255), points FLOAT,date DATETIME)");
} 
$action = $_GET["action"];
//$q = utf8_decode($_GET["q"]);
$q = $_GET["q"];

$nom_mois[1]="Jan.";
$nom_mois[2]="F&eacute;v.";
$nom_mois[3]="Mars";
$nom_mois[4]="Avr.";
$nom_mois[5]="Mai";
$nom_mois[6]="Juin";
$nom_mois[7]="Jui.";
$nom_mois[8]="Ao&ucirc;t";
$nom_mois[9]="Sep.";
$nom_mois[10]="Oct.";
$nom_mois[11]="Nov.";
$nom_mois[12]="D&eacute;c.";


$date = $_GET["date"];
if ($date=="") {
	$date = date('Y-m-d');
}
list($annee,$mois,$jour) = explode("-",$date);
$hier = date('Y-m-d',mktime(12,0,0, $mois,$jour,$annee) - (24 * 60 * 60 ));
$demain = date('Y-m-d',mktime(12,0,0, $mois,$jour,$annee) + (24 * 60 * 60 ) );
$libelle_date = sprintf("%d %s %d",$jour,$nom_mois[$mois],$annee);


if ($action=="AJOUT") {
	$aliment = $_GET["aliment"];
	$point = $_GET["point"];
	$requete = "insert into ww(aliment,points,date) values ('".htmlspecialchars($aliment,ENT_QUOTES)."','".$point."','".$date."')";
	sqlite_query($db,$requete);
}
if ($action=="SUPPRIME") {
	$id = $_GET["id"];
	$requete = "delete from ww where id=".$id;
	echo $requete;
	sqlite_query($db,$requete);
}


?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="css/jquery.mobile-1.2.0.css" />
	<script src="js/jquery-1.8.2.min.js"></script>
	<script src="js/jquery.mobile-1.2.0.min.js"></script>
	<script src="js/fonctions-ww.js"></script>		
</head>
<body>
<div data-role="page">

<div data-role="header">
	<a href="index.php?date=<?=$hier?>" data-icon="arrow-l" data-transition="slide" data-direction="reverse">Prec.</a>
	<h1><?=$libelle_date?></h1>
	<a href="index.php?date=<?=$demain?>" data-icon="arrow-r" data-iconpos="right" data-transition="slide">Suiv.</a>
</div>

<div data-role="content">			

<?
if ($q!="") {
?>
<form action="index.php" action="POST" data-ajax="false">
<input type="hidden" name="aliment" value="<?=$q?>"/>
<input type="hidden" name="date" value="<?=$date?>"/>
<input type="hidden" name="action" value="AJOUT"/>
<div data-role="fieldcontain">
    <label for="name"><?=$q?> : </label>
<input type="number" name="point" step="0.5" placeholder="points"><br/>
</div>
</form>
<?
}
?>
<table>
<?
$result = sqlite_array_query($db,"select id,aliment,points from ww where date='".$date."'", SQLITE_ASSOC);
foreach ($result as $entry) {
    echo '<tr><td>' . $entry['aliment'] . '</td><td>' . $entry['points'].'</td><td><a href="index.php?action=SUPPRIME&id='.$entry['id'].'&date='.$date.'" data-role="button" data-icon="delete" data-iconpos="notext" data-mini="true" data-inline="true">Delete</a></td></tr>';
    $nb_max_points = $nb_max_points - $entry['points'];
}
?>
</table>
Il reste <?=$nb_max_points?> points

<form>
	<input type="search" class="search" name="q" placeholder="Recherche aliment">
</form>
<div class="result-search">
	
</div>

	</div><!-- /content -->
<div data-role="footer"  data-position="fixed" class="ui-bar">
	<div data-role="controlgroup" data-type="horizontal">
	<a href="index.php" data-role="button" data-icon="home">Auj.</a>
	<a href="stat.php" data-role="button" data-icon="gear">Stats</a>
	<a href="index.html" data-role="button" data-icon="info">A Propos</a>
	</div>
</div> <!-- footer -->	
	
</div><!-- /page -->	
</body>
</html>
