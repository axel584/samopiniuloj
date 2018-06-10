<? include "../db.php";
session_start();
malfermiDatumbazon();
$tago = $_REQUEST['tago'];
$monato = $_REQUEST['monato'];
$jaro = $_REQUEST['jaro'];
$versio = $_REQUEST['versio'];
$json_respondo = array();
if ($versio=='') {
	$lasta_vorto_id = troviVortonId($tago,$monato,$jaro);
	$result = troviNovajnVortojn($lasta_vorto_id);
	if (mysql_num_rows($result)) {
		$json_respondo['respondo']='ok';
		$vortoj = array();
		while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
			array_push($vortoj, $row);
		}
		$json_respondo['vortoj']=$vortoj;
	} else {
		$json_respondo['respondo']='eraro';
		$json_respondo['kialo']='Neniu nova vorto';
		
	}
} elseif ($versio=='2') {
	$result = troviNovajnVortojnLauMonato($monato,$jaro);
	if (mysql_num_rows($result)) {
		$json_respondo['respondo']='ok';
		$vortoj = array();
		while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
			array_push($vortoj, $row);
		}
		$json_respondo['vortoj']=$vortoj;
	} else {
		$json_respondo['respondo']='eraro';
		$json_respondo['kialo']='Neniu nova vorto';
		
	}
}
print_r(json_encode($json_respondo));

?>