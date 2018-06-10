<?
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set("Europe/Paris");
$db = sqlite_open("ww.db");

$q=sqlite_escape_string($_GET['q']);
$date=$_GET['date'];
$result = sqlite_array_query($db,"select distinct aliment,points from ww where aliment like '".$q."%'", SQLITE_ASSOC);
foreach ($result as $entry) {
    echo '<tr><td>' . $entry['aliment'] . '</td><td>' . $entry['points'].' points</td><td><a href="index.php?action=AJOUT&date='.$date.'&aliment='.$entry['aliment'].'&point='.$entry['points'].'" data-role="button" data-icon="plus" data-iconpos="notext" data-mini="true" data-inline="true">Ajout</a></td></tr>';
}
?>