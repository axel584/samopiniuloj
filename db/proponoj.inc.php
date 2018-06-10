<?php
/*
 * trovas proponojn laux vorto, ludanto kaj vico
 * EN : vorto-id, ludanto-id, vico
 * EL : propono
 */
function troviProponon($vorto_id,$ludanto_id,$vico) {
	$query = "select propono from sam_proponoj where vorto_id='".$vorto_id."' and ludanto_id='".$ludanto_id."' and vico='".$vico."'";
	mysql_select_db("sam");
	
	$result = mysql_query($query) or die ("SELECT : Invalid query :".$query);
	$row = mysql_fetch_array($result);
	//echo_js($row['propono']);
	return $row['propono'];
}

/*
 * trovas cxiujn proponojn de iu ludanto por iu tago : utilas por ludu2.php
 * EN : vorto-id, ludanto-id
 * EL : listo de proponoj de la lundanto
 */ 
function troviProponojn($vorto_id,$ludanto_id) {
	$query = "select vico, propono from sam_proponoj where vorto_id='".$vorto_id."' and ludanto_id='".$ludanto_id."'";
	mysql_select_db("sam");
	$result = mysql_query($query) or die ("SELECT : Invalid query :".$query);
	while ($row = mysql_fetch_array($result)) {
		$jamprop[$row['vico']]=strtolower($row['propono']);
	}
	return $jamprop;
}

/*
 * registras proponojn de ludanto
 */
function registriProponon($vorto_id,$ludanto_id,$propono,$vico) {
	// echo "registriProponon : ".$vorto_id."<br/>";
	// echo "registriProponon : ".$ludanto_id."<br/>";
	// echo "registriProponon : ".$propono."<br/>";
	// echo "registriProponon : ".$vico."<br/>";
	$propono = utf2x($propono);
	$prop=troviProponon($vorto_id,$ludanto_id,$vico);
	if ($prop=="") {
		if ($propono) {
			// nouvelle proposition : on insère dans la base
			$query ="insert into sam_proponoj(vorto_id,ludanto_id,propono,vico) values ('".$vorto_id."','".$ludanto_id."','".$propono."','".$vico."')";
			mysql_select_db("sam");
			mysql_query($query) or die ("INSERT : Invalid query :".$query);
		}
	} else {
		// il y a déjà un mot dans la base : on met à jour avec le nouveau
		if ($propono=="") {
			// si le nouveau mot est vide, on efface l'enregistrement correspondant dans la base
			$query ="delete from sam_proponoj where vorto_id='".$vorto_id."' and ludanto_id='".$ludanto_id."' and vico='".$vico."'";
			mysql_select_db("sam");
			mysql_query($query) or die ("DELETE : Invalid query :".$query);	
		} else {
			$query ="update sam_proponoj set propono='".$propono."' where vorto_id='".$vorto_id."' and ludanto_id='".$ludanto_id."' and vico='".$vico."'";
			mysql_select_db("sam");
			mysql_query($query) or die ("UPDATE : Invalid query :".$query);
		}
	}		
}
?>
