<? include "../db.php";
session_start();
malfermiDatumbazon();
$nomo = trim($_REQUEST['nomo']);
$pasvorto = trim($_REQUEST['pasvorto']);
$retadreso = trim($_REQUEST['retadreso']);
$lando = $_REQUEST['lando'];
$id = kontroliPersonon($nomo,$pasvorto);
$json_respondo = array();
if ($nomo=="") {
	$json_respondo['respondo']='eraro';
	$json_respondo['kialo']='Enirnomo mankas';
	$json_respondo['eraro_id']=3;
} elseif ($pasvorto=="") {
	$json_respondo['respondo']='eraro';
	$json_respondo['kialo']='Pasvorto mankas';
	$json_respondo['eraro_id']=4;
} elseif ($retadreso=="") {
	$json_respondo['respondo']='eraro';
	$json_respondo['kialo']='Retadreso mankas';
	$json_respondo['eraro_id']=5;
} elseif ($lando=="") {
	$json_respondo['respondo']='eraro';
	$json_respondo['kialo']='Lando mankas';
	$json_respondo['eraro_id']=6;
} elseif (verifiRetadreson($retadreso)) {
	$json_respondo['respondo']='eraro';
	$json_respondo['kialo']='Retadreso jam uzita';
	$json_respondo['eraro_id']=2;
} elseif (verifiEnirnomo($nomo)) {
	$json_respondo['respondo']='eraro';
	$json_respondo['kialo']='Enirnomo jam uzita';
	$json_respondo['eraro_id']=1;
} else {
	$json_respondo['respondo']='ok';
	kreiPersonon($nomo,$pasvorto,$retadreso,$lando); 
	$id = kontroliPersonon($nomo,$pasvorto);
	protokolo($id, "aligxis per ws", $nomo+" ("+$retadreso+")");
	MesagxoNovaLudanto($id, $nomo,$retadreso,$lando);
	$json_respondo['id']=$id;
	$json_respondo['nomo']=$nomo;
}
print_r(json_encode($json_respondo));

?>