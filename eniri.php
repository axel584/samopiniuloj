<?php include "db.php";
session_start();
malfermiDatumbazon();
$id = kontroliPersonon($_REQUEST['nomo'],$_REQUEST['pasvorto']);
if ($id==null) {
	//header('location:index.php?eraro=Malbona%20pasvorto');
	header('location:forgesemulo.php');
} else {
	$kateg="eniris";
	protokolo($id, $kateg, "");
	//setcookie("sam_id",$id);
	$_SESSION["sam_id"]=$id;
	header('location:index.php');
}
?>