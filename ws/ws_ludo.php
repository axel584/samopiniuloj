<? include "../db.php";
session_start();
malfermiDatumbazon();
$vorto_id = $_REQUEST['vorto_id'];
$ludanto_id = $_REQUEST['ludanto_id'];
$prop = $_REQUEST['prop'];

// on verifie que le mot qui est joué n'est pas trop tard
$luditaTago = troviTagLauxVortonId($vorto_id);
$ludoTago = sprintf("%4d%02d%02d", $luditaTago['jaro'], $luditaTago['monato'], $luditaTago['tago']);
if ($ludoTago < date('Y').date('m').date('d')) {
	$json_respondo = array();
	$json_respondo['respondo']='eraro';
	$json_respondo['kialo']="Vi malfruas, vi ne plu rajtas ludi tiun vorton !";
	print_r(json_encode($json_respondo));
	exit();
}

// Protokolo
protokolo($ludanto_id, "ludis per ws", "vorto_id=".$vorto_id);
protokolo($ludanto_id, "proponoj per ws", implode(" - ", $prop)); // on met toutes les propositions séparées par un tiret

function verifiRadikon($mot,$vorto_id) {
	$radikoj = troviRadikon($vorto_id);
	for ($i=0;$i<count($radikoj[1]);$i++) {
		$radiko = trim($radikoj[1][$i]);
		if (!(strpos(konvMinMaj($mot), konvMinMaj($radiko))===FALSE)) {
			return "la propono enhavas la radikon de la vorto";
		}
	}
	return null;
}

$jamprop = troviProponojn($vorto_id,$ludanto_id);
for ($i=0;$i<8;$i++) {
	if ($jamprop[$i]!=null) {
		$vortaro[$jamprop[$i]]='jes';
	}
}

$json_respondo = array();
$json_respondo['respondo']='ok';
$json_respondo['registritaj']=array();
$json_respondo['vorto_id']=$vorto_id;
$json_respondo['ludanto_id']=$ludanto_id;
$json_respondo['proponoj']=$prop;
for ($i=0;$i<8;$i++) {
	$prop[$i]=trim($prop[$i]);
	$eraro = verifiRadikon($prop[$i],$vorto_id);
	if ($eraro!=null) {
		if ($json_respondo['kialoj']==NULL) { // si c'est la première erreur, on instancie un tableau de réponses d'erreur
			$json_respondo['kialoj']=array();
			$json_respondo['eraraj_proponoj']=array();
		}
		array_push($json_respondo['kialoj'], $eraro);
		array_push($json_respondo['eraraj_proponoj'], $i);
	} else {
		if (($vortaro[strtolower($prop[$i])]==null)||($prop[$i]==null)) {
			$vortaro[strtolower($prop[$i])]='jes';
			registriProponon($vorto_id,$ludanto_id,$prop[$i],$i);
			if (($prop[$i]!=null)||($prod[$i]!="")) { // on indique que l'on a enregistré si c'est différent de null
				array_push($json_respondo['registritaj'], $i);
			}
		} 
	}
}
print_r(json_encode($json_respondo));
?>