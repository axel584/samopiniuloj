<?php
/*
 * kalkulas daton de la antauxa tago 
 * EN : tago, monato, jaro
 * EL : dato de la antauxa tago (se ekzistas vorton por la antauxa tago)
 * uzata en statistikoj.php, rezulto.php
 */
function pasinttago($tago,$monato,$jaro) {
	$t = mktime(12,00,00,$monato,$tago-1,$jaro);
	$query = "select * from sam_proponoj,sam_vortoj where sam_proponoj.vorto_id=sam_vortoj.id and tago='".date('d',$t)."' and monato='".date('m',$t)."' and jaro='".date('Y',$t)."'";
	mysql_select_db("sam");
	$result = mysql_query($query) or die ("INSERT : Invalid query :".$query);
	if (mysql_num_rows($result)!=0) {
		return $t;
	} else {
		return null;
	}	
}

/*
 * kalkulas daton de la posta tago 
 * EN : tago, monato, jaro
 * EL : dato de la posta tago (se ekzistas vorton por la posta tago)
 * uzata en statistikoj.php, rezulto.php
 */

function venonttago($tago,$monato,$jaro) {
	$t = mktime(12,00,00,$monato,$tago+1,$jaro);
	$query = "select * from sam_proponoj,sam_vortoj where sam_proponoj.vorto_id=sam_vortoj.id and tago='".date('d',$t)."' and monato='".date('m',$t)."' and jaro='".date('Y',$t)."'";
	mysql_select_db("sam");
	$result = mysql_query($query) or die ("INSERT : Invalid query :".$query);
	// donne le jour prochain s'il y a des propositions de faites et que ce n'est pas aujourd'hui
	if ((mysql_num_rows($result)!=0) && (date('d',$t)!=date('d'))||(date('m',$t)!=date('m'))||(date('Y',$t)!=date('Y'))) {
		return $t;
	} else {
		return null;
	}
}

/*
 * trovas daton de la antauxa luda tago
 * EN : tago, monato, jaro
 * EL : dato de la antauxa luda tago (se ekzistas)
 * uzata en ludu.php
 */

function pasintludtago($tago,$monato,$jaro) {
	$t = mktime(12,00,00,$monato,$tago-1,$jaro);
	$query = "select * from sam_vortoj where tago='".date('d',$t)."' and monato='".date('m',$t)."' and jaro='".date('Y',$t)."'";
	mysql_select_db("sam");
	$result = mysql_query($query) or die ("INSERT : Invalid query :".$query);
	if (mysql_num_rows($result)!=0) {
		return $t;
	} else {
		return null;
	}
}

/*
 * trovas daton de la posta luda tago
 * EN : tago, monato, jaro
 * EL : dato de la posta luda tago (se ekzistas vorto por tiu tago)
 * uzata en ludu.php
 */
function venontludtago($tago,$monato,$jaro) {
	$t = mktime(12,00,00,$monato,$tago+1,$jaro);
	$query = "select * from sam_vortoj where tago='".date('d',$t)."' and monato='".date('m',$t)."' and jaro='".date('Y',$t)."'";
	mysql_select_db("sam");
	$result = mysql_query($query) or die ("INSERT : Invalid query :".$query);
	// affiche le jour prochain s'il y a des propositions de faites et que ce n'est pas aujourd'hui
	if (mysql_num_rows($result)!=0) {
		return $t;
	} else {
		return null;
	}
}

/*
 * trovas la antauxan monaton
 * EN : tago, monato, jaro
 * EL : dato de la antauxa monato (se ekzistas proponoj por tiu dato)
 * uzata en rezulto.php
 */
function pasintmonato($tago,$monato,$jaro) {
	$t = mktime(12,00,00,$monato-1,$tago,$jaro);
	$query = "select * from sam_proponoj,sam_vortoj where sam_proponoj.vorto_id=sam_vortoj.id and monato='".date('m',$t)."' and jaro='".date('Y',$t)."'";
	mysql_select_db("sam");
	$result = mysql_query($query) or die ("INSERT : Invalid query :".$query);
	if (mysql_num_rows($result)!=0) {
		return $t;
	} else {
		return null;
	}	
}

/*
 * trovas la postan monaton
 * EN : tago, monato, jaro
 * EL : dato de la posta monato (se ekzistas proponoj por tiu dato)
 * uzata en rezulto.php
 */
function venontmonato($tago,$monato,$jaro) {
	$t = mktime(12,00,00,$monato+1,$tago,$jaro);
	$query = "select * from sam_proponoj,sam_vortoj where sam_proponoj.vorto_id=sam_vortoj.id and monato='".date('m',$t)."' and jaro='".date('Y',$t)."'";
	mysql_select_db("sam");
	$result = mysql_query($query) or die ("INSERT : Invalid query :".$query);
	if (mysql_num_rows($result)!=0) {
		return $t;
	} else {
		return null;
	}	
}

/*******************************************************/
/* adminejo 									   */
/*******************************************************/

/*
 * trovas daton de la antauxa tago se ludantoj ludis por tiu tago
 * EN : tago, monato, jaro
 * EL : date de la venonta tago aux null
 */
function pasintadmintago($tago,$monato,$jaro) {
	$t = mktime(12,00,00,$monato,$tago-1,$jaro);
	$query = "select * from sam_vortoj where tago='".date('d',$t)."' and monato='".date('m',$t)."' and jaro='".date('Y',$t)."'";
	mysql_select_db("sam");
	$result = mysql_query($query) or die ("INSERT : Invalid query :".$query);
	if (mysql_num_rows($result)!=0) {
		return $t;
	} else {
		return null;
	}	
}

/*
 * trovas daton de la venonta tago se ludantoj jam ludis por tiu tago
 * EN : tago, monato, jaro
 * EL : date de la venonta tago aux null
 */
function venontadmintago($tago,$monato,$jaro) {
	$t = mktime(12,00,00,$monato,$tago+1,$jaro);
	$query = "select * from sam_vortoj where tago='".date('d',$t)."' and monato='".date('m',$t)."' and jaro='".date('Y',$t)."'";
	mysql_select_db("sam");
	$result = mysql_query($query) or die ("INSERT : Invalid query :".$query);
	// affiche le jour prochain s'il y a des propositions de faites et que ce n'est pas aujourd'hui
	if (mysql_num_rows($result)!=0) {
		return $t;
	} else {
		return null;
	}	
}
/*
 * trovas cxiun vorton de cxiu tago de iu monato
 * EN : monato, jaro
 * EL : vortoj de la monato
 * uzata en admin/index.php
 */
function montriMonaton($monato,$jaro) {
	//global $jaro;
	if ($monato==2) {$nbTagoj=29;}
	elseif ($monato==1||3||5||7||8||10||12) {$nbTagoj=31;}
	else {$nbTagoj=30;}
	for ($t=1; $t <= $nbTagoj; $t++) {
		$query = "select * from sam_vortoj where monato=".$monato." and tago=".$t." and jaro=".$jaro;
		mysql_select_db("sam");
		$result = mysql_query($query) or die ("INSERT : Invalid query :".$query);
		$row = mysql_fetch_array($result);
		$rezulto[$t]['tago']=$t;
		$rezulto[$t]['vorto']=$row['vorto'];
		$rezulto[$t]['dosiero']=$row['dosiero'];
	}
	return $rezulto;
}

/*
 * ne uzata
 */
function montriKalendaron() {
	global $monatnomo;
	$query = "select * from sam_vortoj order by jaro ASC,monato ASC,tago ASC";
	mysql_select_db("sam");
	$result = mysql_query($query) or die ("INSERT : Invalid query :".$query);
	echo "<a href='".$_SERVER['SCRIPT_URI']."'>Nova vorto</a>";
	while ($row = mysql_fetch_array($result)) {
		if ($pasintmonato!=$row['monato']) {
			$pasintmonato=$row['monato'];
			echo "<br/>".$monatnomo[$row['monato']]." ".$row[jaro]."<br/>";
		}
		// eventuellement mettre le nom du truc qui 
		echo "<a href='".$_SERVER['SCRIPT_URI']."?vorto_id=".$row['id']."' alt='".$row['vorto']."'>".$row['tago']."</a> ";
		
	}
}
?>