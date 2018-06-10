<? include "../db.php";
session_start();
malfermiDatumbazon();
$nomo = trim($_REQUEST['nomo']);
$pasvorto = trim($_REQUEST['pasvorto']);
$id = kontroliPersonon($nomo,$pasvorto);
$json_respondo = array();
if ($id==null) {
	$json_respondo['respondo']='eraro';
	// se la enirnomo ekzistas, la pasvorto malghustas, alikaze, ni informas ke la enirnomo ne ekzitas
	if (verifiEnirnomo($nomo)) {
	  $json_respondo['kialo']='Malĝusta pasvorto';
	  $json_respondo['eraro_id']=2;
	} else {
	  $json_respondo['kialo']='Enirnomo ne konata';
	  $json_respondo['eraro_id']=1;
	}
} else {
    $json_respondo['respondo']='ok';
    $json_respondo['id']=$id;
    $json_respondo['nomo']=$nomo;
	protokolo($id, "eniris per ws", "");
	
}
print_r(json_encode($json_respondo));
?>