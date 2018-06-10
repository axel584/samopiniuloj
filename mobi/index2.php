<?
include "../db.php";
malfermiDatumbazon();
if ((empty($_SESSION['sam_id']))||($_SESSION['sam_id']==null)||($_SESSION['sam_id']==0)) {
	header('location:index.php');
	exit();
}

// on recherche le jour du vorto_id que l'on joue :
$luditaTago = troviTagLauxVortonId($_POST['vorto_id']);
$ludoTago = sprintf("%4d%02d%02d", $luditaTago['jaro'], $luditaTago['monato'], $luditaTago['tago']);
if ($ludoTago < date('Y').date('m').date('d')) {
	$eraro="Vi malfruas, vi ne plu rajtas ludi tiun vorton !";
	$tagoParametroj = troviTagoParametrojn($_POST['vorto_id']);
	header('location:index.php?eraro='.$eraro.'&'.$tagoParametroj);
}
$prop = $_POST['prop'];
$ludanto_id=$_SESSION['sam_id'];
$kateg="m-ludis";
$teksto="vorto_id=".$_POST['vorto_id'];
protokolo($ludanto_id, $kateg, $teksto);
$kateg="proponoj";
$teksto="";
for ($i=0;$i<8;$i++) {
	if ($prop[$i]) {
		$teksto.=" - ".$prop[$i];
	}
}
protokolo($ludanto_id, $kateg, $teksto);

function verifiRadikon($mot) {
	$radikoj = troviRadikon($_POST['vorto_id']);
	for ($i=0;$i<count($radikoj[1]);$i++) {
		$radiko = trim($radikoj[1][$i]);
		if (!(strpos(konvMinMaj($mot), konvMinMaj($radiko))===FALSE)) {
			return "Radiko%20trovita";
		}
	}
	return null;
}

$jamprop = troviProponojn($_POST['vorto_id'],$_SESSION['sam_id']);
for ($i=0;$i<8;$i++) {
	if ($jamprop[$i]!=null) {
		$vortaro[$jamprop[$i]]='jes';
	}
}
for ($i=0;$i<8;$i++) {
	//if ($prop[$i]!=null) {
		$prop[$i]=trim($prop[$i]);
		$res = verifiRadikon($prop[$i]);
		if ($res!=null) {
			$eraro = $res;
			continue;
		}
		if (($vortaro[strtolower($prop[$i])]==null)||($prop[$i]==null)) {
			$vortaro[strtolower($prop[$i])]='jes';
			registriProponon($_POST['vorto_id'],$_SESSION['sam_id'],$prop[$i],$i);
		} 
	//}
}
$tagoParametroj = troviTagoParametrojn($_POST['vorto_id']);
if ($eraro!=null) {
	header('location:http://sam.esperanto-jeunes.org/mobi/index.php?eraro='.$eraro.'&'.$tagoParametroj);	
} else {
	header('location:http://sam.esperanto-jeunes.org/mobi/index.php?'.$tagoParametroj);
}
?>