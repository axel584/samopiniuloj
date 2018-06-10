<?php include "db.php";
malfermiDatumbazon();

$hier = time() - (24 * 60 * 60);
$tago = date('d',$hier);
$monato = date('m',$hier);
$jaro = date('Y',$hier);
//$tago = '24';
//$monato = '09';
//$jaro = '2012';

// si on a besoin de tester l'envoi des resultats, on joue pour un jour futur (où personne n'a jamais joué)
// on indique dans les variables $tago, $monato et $jaro la date en question et on va sur http://samopiniuloj.esperanto-jeunes.org/kalkuli.php
// on supprime dans la table sam_kalkuloj la ligne qui correspond a un jour donne pour recommencer

if (verifiKalkulon($tago,$monato,$jaro)==0) {
	kalkuli($tago,$monato,$jaro);
	sendiRezultojn($tago,$monato,$jaro);
} else {
	echo "le calcul a déjà été lancé aujourd'hui";
}
?>