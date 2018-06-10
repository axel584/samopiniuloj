<? include "../db.php";
session_start();
malfermiDatumbazon();
$tago = $_REQUEST['tago'];
$monato = $_REQUEST['monato'];
$jaro = $_REQUEST['jaro'];
// vérifier ici que le jour est bien passé.
$dato = mktime(0,0,0,$monato,$tago,$jaro);
$hodiaux = mktime(0,0,0);
$json_respondo = array();
if ($dato>=$hodiaux) {
	// erreur : on demande une date future
	$json_respondo['respondo']='eraro';
} else {
	$json_respondo['respondo']='ok';
	$json_respondo['tago']=$tago;
	$json_respondo['monato']=$monato;
	$json_respondo['jaro']=$jaro;
	$ludanto_id = $_REQUEST['ludanto_id'];
	$vorto_id = troviVortonId($tago,$monato,$jaro);
	// proposition
	$proponoj = array();
	$result = montriProponojn($vorto_id);
	if (mysql_num_rows($result)) {
		while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
			//print_r($row);
			$row['vorto_id']=$vorto_id;
			array_push($proponoj, $row);
		}
	}
	$json_respondo['proponoj']=$proponoj;

	// mots
	$ludantoj = array();
	$result = montriLudantojn($vorto_id);
	if (mysql_num_rows($result)) {
		while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
			array_push($ludantoj, $row);
		}
	}
	$json_respondo['ludantoj']=$ludantoj;
}


print_r(json_encode($json_respondo));
?>