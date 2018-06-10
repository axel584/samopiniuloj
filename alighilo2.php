<?php include "db.php";
session_start();
malfermiDatumbazon();
date_default_timezone_set('Europe/Paris');

if (($_REQUEST['nomo']=="")||($_REQUEST['retadreso']=="")||($_REQUEST['pasvorto']=="")){
	$eraro="mankas%20informoj&nomo=".$_REQUEST['nomo']."&retadreso=".$_REQUEST['retadreso'];
	header("location:alighilo.php?eraro=".$eraro."");
} elseif (verifiRetadreson($_REQUEST['retadreso'])) { 
	header("location:alighilo.php?eraro=retadreso%20jam%20registrita");
} elseif (verifiEnirnomo($_REQUEST['nomo'])) { 
	header("location:alighilo.php?eraro=enirnomo%20jam%20registrita");	
} else if (($_REQUEST['retadreso']=="lele_h_tinha@hotmail.com")
         ||($_REQUEST['retadreso']=="cirosantos@ig.com.br"))	{
	header("location:alighilo.php?eraro=Forfikighu");
} else {	
	kreiPersonon($_REQUEST['nomo'],$_REQUEST['pasvorto'],$_REQUEST['retadreso'],$_REQUEST['lando']); 
	$id = kontroliPersonon($_REQUEST['nomo'],$_REQUEST['pasvorto']);
	$kateg="aligxis";
	protokolo($id, $kateg, "");
	MesagxoNovaLudanto($id, $_REQUEST['nomo'],$_REQUEST['retadreso'],$_REQUEST['lando']);	
	$_SESSION["sam_id"]=$id;
	header("location:ludu.php");
}
?>