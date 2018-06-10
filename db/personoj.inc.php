<?php
/* 
 * tiun funkcio kontrolas cxu lundanto ekzistas en la datenbazo
 * EN : $enirmo (enirnomo de la ludanto)
 * EL : TRUE se la lundanto ekzistas, FALSE se ne
 */
function verifiPersonon($enirnomo) {
	$query = "select * from sam_ludantoj where kromnomo='".$enirnomo."'";
	mysql_select_db("sam");
	$result = mysql_query($query) or die ("INSERT : Invalid query :".$query);
	return (mysql_num_rows($result)>=1);
}

/* 
 * tiun funkcio kontrolas cxu lundanto ekzistas en la datenbazo
 * EN : $retadreso (enirnomo de la ludanto)
 * EL : TRUE se la lundanto ekzistas, FALSE se ne
 */
function verifiRetadreson($retadreso) {
	$query = "select * from sam_ludantoj where retadreso='".$retadreso."'";
	mysql_select_db("sam");
	$result = mysql_query($query) or die ("INSERT : Invalid query :".$query);
	return (mysql_num_rows($result)>=1);
}

/* 
 * tiun funkcio kontrolas cxu lundanto ekzistas en la datenbazo
 * EN : $retadreso (enirnomo de la ludanto)
 * EL : TRUE se iu lundanto ekzistas kun tiu enirnomo, FALSE se ne
 */
function verifiEnirnomo($enirnomo) {
	$query = "select * from sam_ludantoj where kromnomo='".$enirnomo."'";
	mysql_select_db("sam");
	$result = mysql_query($query) or die ("INSERT : Invalid query :".$query);
	return (mysql_num_rows($result)>=1);
}

/*
 * tiu funkcio kontrolas cxu enirnomo kaj pasvorto estas en la datenbazo 
 * kaj estas gxustaj
 * EN : $enirnom, $pasvorto
 * EL : id de la ludanto se la kontrolo gxustas, NULL se ne
 */
function kontroliPersonon($enirnomo,$pasvorto) {
	$query = "select id from sam_ludantoj where kromnomo='".$enirnomo."' and pasvorto='".$pasvorto."'";
	mysql_select_db("sam");
	$result = mysql_query($query) or die ("INSERT : Invalid query :".$query);
	if (mysql_num_rows($result)==0) {
		return null;
	} else {
		$row = mysql_fetch_array($result);
		return $row['id'];
	}
}

/*
 * kreas lundanton en la datenbazo
 * EN : datenoj de la ludantoj (enirnomo, pasvorto, retadreso, lando)
 * EL : true se la funkcio sukcesis
 */
function kreiPersonon($enirnomo,$pasvorto,$retadreso,$lando) {
     $query = "insert into sam_ludantoj";
     $query .="(kromnomo,pasvorto,retadreso,lando) ";
     $query .="values ('$enirnomo','$pasvorto','$retadreso','$lando')";
     mysql_select_db("sam");
     $result = mysql_query($query) or die ("INSERT : Invalid query :".$query);
     return mysql_insert_id();
}

/*
 * kreas lundanton en la datenbazo (por edukado.net)
 * EN : datenoj de la ludantoj (personnomo, retadreso, sam_fonto=http://edukado.net)
 * EL : true se la funkcio sukcesis
 */
function alighasNomonKajRetadreson($personnomo,$retadreso,$sam_fonto) {
	mysql_select_db("sam");
	// avant d'inserer, on verifie qu'on n'en a pas deja un avec la même adresse email :
	$query = "select count(*) as kiom from sam_ludantoj where retadreso='".$retadreso."'";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);
	if ($row['kiom']==0) {
		$query = "insert into sam_ludantoj";
     	$query .="(kromnomo,retadreso,fonto) ";
     	$query .="values ('".$personnomo."','".$retadreso."','".$sam_fonto."')";
     	$result = mysql_query($query);
	}
}

/*
 * trovas enirnomon de ludanto 
 * EN : id de la persono
 * EL : enirnomo de la persono
 */
function troviNomon($id) {
	$query = "select kromnomo from sam_ludantoj where id='".$id."'";
	mysql_select_db("sam");
	$result = mysql_query($query) or die ("INSERT : Invalid query :".$query);
	$row = mysql_fetch_array($result);
	return $row['kromnomo'];
}

/*
 * trovas enirnomon de ludanto 
 * EN : retadreso de la persono
 * EL : enirnomo de la persono
 */
function troviNomonElRetadreso($retadreso) {
	$query = "select kromnomo from sam_ludantoj where retadreso='".$retadreso."'";
	mysql_select_db("sam");
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);
	if ($row==NULL) {
		return NULL;
	} else {
		return $row['kromnomo'];
	}	
}	

/*
 * trovas enirnomon de ludanto 
 * EN : retadreso de la persono
 * EL : id de la persono
 */
function troviIdElRetadreso($retadreso) {
	$query = "select id from sam_ludantoj where retadreso='".$retadreso."' order by id";
	mysql_select_db("sam");
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);
	if ($row==NULL) {
		return NULL;
	} else {
		return $row['id'];
	}	
}	



/*
 * trovas retadreson de ludanto 
 * EN : id de la persono
 * EL : retadreso de la persono
 */

function troviRetadreson($id) {
	$query = "select retadreso from sam_ludantoj where id='".$id."'";
	mysql_select_db("sam");
	$result = mysql_query($query) or die ("INSERT : Invalid query :".$query);
	$row = mysql_fetch_array($result);
	return $row['retadreso'];
}

/*
 * trovas ludintojn de la antauxa tago
 * EL : listo de ludntoj kun kromnomo kaj lando
 * uzata en rezulto.php
 */
function listiLudintojn () {
	//$query = "select * from sam_ludantoj";
	$vortoId = troviVortonId(date('d'),date('m'),date('Y'));
	$query = "select lando, kromnomo from sam_ludantoj LEFT JOIN sam_proponoj on sam_proponoj.ludanto_id = sam_ludantoj.id where sam_proponoj.vorto_id ='".$vortoId."' group by kromnomo,lando";
	mysql_select_db("sam");
	$result = mysql_query($query) or die ("SELECT : Invalid query :".$query);
	// emmanuelle : affichage sur 3 colonnes
	$i=0;
	while ($row = mysql_fetch_array($result)){
		$ludantoj[$i]['kromnomo']=$row['kromnomo'];
		$ludantoj[$i]['lando']=troviLandon($row['lando']);
		$i++;
	}
	return $ludantoj;
}

/*
 * 
 */
function konfig($ludanto_id, $teksto) {
		$query ="update sam_ludantoj set ekrano='".$teksto."' where id='".$ludanto_id."'";
		mysql_select_db("sam");
		mysql_query($query) or die ("UPDATE : Invalid query :".$query);	
}

/*******************************************************/
/* adminejo 									   */
/*******************************************************/

function listiNunajnLudantojn ($tago, $monato, $jaro) {
	$vortoId = troviVortonId($tago,$monato,$jaro);
	$query = "select lando, kromnomo, retadreso, count(*) as somme from sam_ludantoj LEFT JOIN sam_proponoj on sam_proponoj.ludanto_id = sam_ludantoj.id where sam_proponoj.vorto_id ='".$vortoId."' group by kromnomo,lando";
	mysql_select_db("sam");
	$result = mysql_query($query) or die ("SELECT : Invalid query :".$query);
	$i=0;
	while ($row = mysql_fetch_array($result)) {
		$ludantoj[$i]['kromnomo']=$row['kromnomo'];
		$ludantoj[$i]['lando']=troviLandon($row['lando']);
		$ludantoj[$i]['retadreso']=$row['retadreso'];
		$ludantoj[$i]['sumo']=$row[somme];
		$i++;
	}
	if 	(mysql_num_rows($result)!=0) return $ludantoj;
	else return null;
}

/*
 * donas liston de cxiuj ludantoj
 * EL : tabulo, kiu enhavas cxiujn ludantojn : id, lando, kromnomo, kreado, retadreso, ekrano,
 * uzata en admin/admin.php
 */
function listiCxiujnLudantojn () {
	$ludantoj[] = array();
	$query = "select * from sam_ludantoj order by id DESC";
	mysql_select_db("sam");
	$result = mysql_query($query) or die ("INSERT : Invalid query :".$query);
	$i=0;
	while ($row = mysql_fetch_array($result)) {
		$ludantoj[$i]['id'] = $row['id'];
		$ludantoj[$i]['lando'] = troviLandon($row['lando']);
		$ludantoj[$i]['kreado'] = $row['kreado'];
		$ludantoj[$i]['kromnomo'] = $row['kromnomo'];
		$ludantoj[$i]['retadreso'] = $row['retadreso'];
		$ludantoj[$i]['ekrano'] = $row['ekrano'];
		$i++;
	}
	return $ludantoj;
}

function sendiPasvorton ($retadreso) {
		$dosiero = "retmesaghoj/pasvorto.html";
		$fd = fopen($dosiero, "r");
		$enhavo = fread($fd, filesize ($dosiero));
		fclose($fd);

		$mesagxkapo="MIME-Version: 1.0\n";
		$mesagxkapo.="Content-type: text/html;charset=utf-8\n";
		$mesagxkapo.="From: Samopiniuloj <samopiniuloj@esperanto-jeunes.org>\n";
		//$mesagxkapo.="Bcc: <emmanuelle@esperanto-jeunes.org>\n";
		$mesagxkapo.="Date: ".date("D, j M Y H:i:s").chr(13);
		$mesagxkapo.=" \n";
	
		$query = "select sam_ludantoj.kromnomo,sam_ludantoj.retadreso,sam_ludantoj.id, sam_ludantoj.mesagxo, sum(sam_proponoj.poento) as poentoj from sam_proponoj,sam_ludantoj,sam_vortoj where sam_proponoj.vorto_id=sam_vortoj.id and sam_proponoj.ludanto_id=sam_ludantoj.id and sam_vortoj.tago = '".$tago."' and sam_vortoj.monato = '".$monato."' and sam_vortoj.jaro ='".$jaro."' group by sam_ludantoj.id order by poentoj DESC";

		mysql_select_db("sam");
		$result = mysql_query($query) or die ("INSERT : Invalid query :".$query);
		while ($row = mysql_fetch_array($result)) {
			// se la ludanto deziras ne ricevi mesagxon aux se la adreso ne validas, oni ne sendas mesagxon
			if ($row['mesagxo']=='Y') {
				// on est sur le joueur lundanto_id
				$teksto=$enhavo;
				$teksto=str_replace("##LUDANTO##",$row['kromnomo'],$teksto);
				$query2 = "select distinct sam_proponoj.poento,sam_proponoj.propono from sam_proponoj,sam_vortoj where sam_proponoj.vorto_id=sam_vortoj.id and sam_vortoj.tago = '".$tago."' and sam_vortoj.monato = '".$monato."' and sam_vortoj.jaro ='".$jaro."' and sam_proponoj.ludanto_id='".$row['id']."' order by vico ASC";
				mysql_select_db("sam");
				$result2 = mysql_query($query2) or die ("INSERT : Invalid query :".$query2);
				$sumo = 0; $i = 1;
				while ($row2 = mysql_fetch_array($result2)) {
					$sumo = $sumo + $row2['poento'];
					$propono="##PROPONO_".$i."##";
					$poento="##POENTO_".$i."##";
					$teksto=str_replace($propono,x2utf($row2['propono']),$teksto);
					$teksto=str_replace($poento,$row2['poento'],$teksto);
					$i++;
				}
				if ($i<8) {
					for ($j=$i;$j<9;$j++) {
					$propono="##PROPONO_".$j."##";
					$poento="##POENTO_".$j."##";
						$teksto=str_replace($propono,"",$teksto);
						$teksto=str_replace($poento,"",$teksto);
					}	
				}
				$teksto=str_replace("##SUMO##",$sumo,$teksto);
				mail($row['retadreso'],"Samopiniuloj-rezultoj",$teksto,$mesagxkapo);
				echo "envoi message pour ".$row['retadreso']."<br>";
			} else {
				echo "pas de message pour ".$row['retadreso']."<br>";
			}
		}
}


?>
