<?php
/* 
 * tiun funkcio donas rezultojn de la nuna monato
 * EN : $monato, $jaro
 * EL : listo de cxiuj lundatoj kun iliaj poentoj
 */
function listiMonatanRezultojn ($monato,$jaro) {
	$query = "select sam_ludantoj.id, sam_ludantoj.kromnomo,sum(sam_proponoj.poento) as kiom from sam_proponoj,sam_ludantoj,sam_vortoj where sam_vortoj.id=sam_proponoj.vorto_id and sam_vortoj.monato = '".$monato."' and sam_vortoj.jaro ='".$jaro."' and sam_ludantoj.id=sam_proponoj.ludanto_id group by sam_ludantoj.id order by kiom DESC";
	mysql_select_db("sam");
	$result = mysql_query($query) or die (mysql_errno() . ": " . mysql_error() . " : SELECT : Invalid query :".$query);
	$nbProponoj=mysql_num_rows($result);
	$i=0;
	while ($row = mysql_fetch_array($result)) {
		$vortoj[$i]['id']=$row['id'];
		$vortoj[$i]['kromnomo']=$row['kromnomo'];
		$vortoj[$i]['kiom']=$row['kiom'];
		$i++;
	}
	return $vortoj;
}

function montriLudantojn($vorto_id) {
	$query = "select distinct ludanto_id,kromnomo from sam_proponoj,sam_ludantoj where sam_proponoj.ludanto_id=sam_ludantoj.id and vorto_id='".$vorto_id."'";
	mysql_select_db("sam");
	$result = mysql_query($query) or die ("INSERT : Invalid query :".$query);
	return $result;
	/*$i=1;
	while ($row = mysql_fetch_array($result)) {
		$rezulto[$i]['ludanto_id']=$row['ludanto_id'];
		$rezulto[$i]['kromnomo']=$row['kromnomo'];
		$i++;
	}
	return $rezulto;*/
}

function montriProponojn($vorto_id) {
	$query = "select ludanto_id,propono,vico,poento from sam_proponoj where vorto_id='".$vorto_id."'";
	mysql_select_db("sam");
	$result = mysql_query($query) or die ("INSERT : Invalid query :".$query);
	return $result;
	/*$i=1;
	while ($row = mysql_fetch_array($result)) {
		$rezulto[$i]['ludanto_id']=$row['ludanto_id'];
		$rezulto[$i]['propono']=$row['propono'];
		$rezulto[$i]['vico']=$row['vico'];
		$rezulto[$i]['poento']=$row['poento'];
		$i++;
	}
	return $rezulto;*/
}

function montriRezulton ($tago,$monato,$jaro) {
	global $monatnomo;
	$query = "select sam_ludantoj.kromnomo,sam_ludantoj.id,sum(sam_proponoj.poento) as poentoj from sam_proponoj,sam_ludantoj,sam_vortoj where sam_proponoj.vorto_id=sam_vortoj.id and sam_proponoj.ludanto_id=sam_ludantoj.id and sam_vortoj.tago = '".$tago."' and sam_vortoj.monato = '".$monato."' and sam_vortoj.jaro ='".$jaro."' group by sam_ludantoj.id order by poentoj DESC";
	mysql_select_db("sam");
	$result = mysql_query($query) or die ("INSERT : Invalid query :".$query);
	$i=1;
	// emmanuelle : affichage des joueurs sur 2 colonnes
	$nbLudintoj=mysql_num_rows($result);
	while ($row = mysql_fetch_array($result)) {
		$ludintoj[$i]['poentoj']=$row['poentoj'];
		$ludintoj[$i]['kromnomo']=$row['kromnomo'];
		$ludintoj[$i]['id']=$row['id'];
		$i++;
	}
	return $ludintoj;
}

function montriPoentojn ($tago,$monato,$jaro,$ludanto_id) {
	$rezultoj=null;
	$query = "select distinct sam_proponoj.poento,sam_proponoj.propono from sam_proponoj,sam_vortoj where sam_proponoj.vorto_id=sam_vortoj.id and sam_vortoj.tago = '".$tago."' and sam_vortoj.monato = '".$monato."' and sam_vortoj.jaro ='".$jaro."' and sam_proponoj.ludanto_id='".$ludanto_id."' order by vico ASC";
	echo "<!--".$query."-->";
	mysql_select_db("sam");
	$result = mysql_query($query) or die ("INSERT : Invalid query :".$query);
	if (mysql_num_rows($result)==0) {
		if ($_SESSION['sam_id']) {
			//echo "Vi ne ludis tiun tagon !";
		}
	} else {
		$i=0;
		while ($row = mysql_fetch_array($result)) {
			$rezultoj[$i]['propono']=$row['propono'];
			$rezultoj[$i]['poento']=$row['poento'];
			$i++;
		}
	}
	return $rezultoj;
}

function montriStatistikojn ($tago,$monato,$jaro,$ludanto_id) {
	$query = "select sam_proponoj.propono,count(sam_proponoj.propono) as kiom from sam_proponoj,sam_vortoj where sam_proponoj.vorto_id=sam_vortoj.id and sam_vortoj.tago = '".$tago."' and sam_vortoj.monato = '".$monato."' and sam_vortoj.jaro ='".$jaro."' group by sam_proponoj.propono order by kiom DESC";
	//echo $query;
	//echo $ludanto_id;
	mysql_select_db("sam");
	$result = mysql_query($query) or die ("SELECT : Invalid query :".$query);
	$nbProponoj=mysql_num_rows($result);
	$i=0;
	while ($row = mysql_fetch_array($result)) {
		if ($ludanto_id>0) {
			$vortoId=troviTagVortonId($tago,$monato,$jaro);
			$query2 = "select * from sam_proponoj where ludanto_id='".$ludanto_id."' and vorto_id='".$vortoId."' and propono='".$row['propono']."'";
			//echo $query2."<br/>";
			$result2 = mysql_query($query2) or die ("SELECT : Invalid query :".$query2);
			$rezulto[$i]['proponitaVorto']=mysql_num_rows($result2);
		} else {$rezulto[$i]['proponitaVorto']=0;}
		$rezulto[$i]['kiom']=$row['kiom'];
		$rezulto[$i]['propono']=$row['propono'];
		$i++;
	}
	//print_r($rezulto);
	return $rezulto;
}

function verifiKalkulon($tago,$monato,$jaro) {
	echo "fonction verifiKalkulon<br>";
	$query = "select id from sam_kalkuloj where tago='".$tago."' and monato='".$monato."' and jaro='".$jaro."'";
	echo $query."<br>";
	mysql_select_db("sam");
	$result = mysql_query($query) or die ("INSERT : Invalid query :".$query);
	echo "retour=".mysql_num_rows($result)."<br>";
	return mysql_num_rows($result);
}

function kalkuli($tago,$monato,$jaro) {
	// recherche l'id du mot en fonction du jour
	$query = "select id from sam_vortoj where tago='".$tago."' and monato='".$monato."' and jaro='".$jaro."'";
	echo $query."<br/>";
	mysql_select_db("sam");
	$result = mysql_query($query) or die ("INSERT : Invalid query :".$query);
	$row = mysql_fetch_array($result);
	$vorto_id = $row['id'];
	// recherche les propositions pour ce mot
	$query = "SELECT propono,count(*) as count FROM `sam_proponoj` WHERE vorto_id=".$vorto_id." group by propono order by count DESC";
	echo $query."<br/>";
	$result = mysql_query($query) or die ("INSERT : Invalid query :".$query);
	while ($row = mysql_fetch_array($result)) {
		if ($row[count]==1) {
			break;
		}
		echo $row[propono]."-".$row[count]."<br/>";
		$query2 = "update sam_proponoj set poento='".$row[count]."' where vorto_id=".$vorto_id." and propono='".$row[propono]."'";
		echo $query2."<br/>";
		mysql_query($query2) or die ("INSERT : Invalid query :".$query);			
	}
	$query2 = "insert into sam_kalkuloj (jaro, monato, tago, horo) values ('".$jaro."','".$monato."','".$tago."',now())";
	echo $query2."<br>";
	mysql_select_db("sam");
	$result2 = mysql_query($query2) or die ("INSERT : Invalid query :".$query2);
}
function rekalkuli($tago,$monato,$jaro) {
	// recherche l'id du mot en fonction du jour
	$query = "select id from sam_vortoj where tago='".$tago."' and monato='".$monato."' and jaro='".$jaro."'";
	echo $query."<br/>";
	mysql_select_db("sam");
	$result = mysql_query($query) or die ("INSERT : Invalid query :".$query);
	$row = mysql_fetch_array($result);
	$vorto_id = $row['id'];
	// recherche les propositions pour ce mot
	$query = "SELECT propono,count(*) as count FROM `sam_proponoj` WHERE vorto_id=".$vorto_id." group by propono order by count DESC";
	echo $query."<br/>";
	$result = mysql_query($query) or die ("INSERT : Invalid query :".$query);
	$i=0;
	while ($row = mysql_fetch_array($result)) {
		if ($row[count]==1) {
			break;
		}
		$poentoj[$i]['propono']=$row ['propono'];
		$poentoj[$i]['kiom']=$row['count'];
		$i++;
		$query2 = "update sam_proponoj set poento='".$row[count]."' where vorto_id=".$vorto_id." and propono='".$row[propono]."'";
		mysql_query($query2) or die ("INSERT : Invalid query :".$query);			
	}
	return $poentoj;
}

function sendiRezultojn ($tago,$monato,$jaro) {
	global $monatnomo;
		$dosiero = "retmesaghoj/rezulto.html";
		$fd = fopen($dosiero, "r");
		$enhavo = fread($fd, filesize ($dosiero));
		fclose($fd);
		$enhavo=str_replace("##TAGO##",$tago,$enhavo);
		$enhavo=str_replace("##MONATO##",$monatnomo[$monato],$enhavo);
		$enhavo=str_replace("##JARO##",$jaro,$enhavo);
		$enhavo=str_replace("##VORTO##",troviVorton($tago, $monato, $jaro),$enhavo);

		$mesagxkapo="MIME-Version: 1.0\n";
		$mesagxkapo.="Content-type: text/html;charset=utf-8\n";
		$mesagxkapo.="From: Samopiniuloj <samopiniuloj@esperanto-jeunes.org>\n";
		//$mesagxkapo.="Bcc: <emmanuelle@esperanto-jeunes.org>\n";
		$mesagxkapo.="Date: ".date("D, j M Y H:i:s").chr(13);
		$mesagxkapo.=" \n";
	
		$query = "select sam_ludantoj.kromnomo,sam_ludantoj.retadreso,sam_ludantoj.id, sam_ludantoj.mesagxo, sum(sam_proponoj.poento) as poentoj,sam_ludantoj.fonto from sam_proponoj,sam_ludantoj,sam_vortoj where sam_proponoj.vorto_id=sam_vortoj.id and sam_proponoj.ludanto_id=sam_ludantoj.id and sam_vortoj.tago = '".$tago."' and sam_vortoj.monato = '".$monato."' and sam_vortoj.jaro ='".$jaro."' group by sam_ludantoj.id order by poentoj DESC";

		mysql_select_db("sam");
		$result = mysql_query($query) or die ("INSERT : Invalid query :".$query);
		while ($row = mysql_fetch_array($result)) {
			// se la ludanto deziras ne ricevi mesagxon aux se la adreso ne validas, oni ne sendas mesagxon
			if ($row['mesagxo']=='Y') {
				// on est sur le joueur lundanto_id
				$teksto=$enhavo;
				$teksto=str_replace("##LUDANTO##",$row['kromnomo'],$teksto);
				if ($row['fonto']==null) {
					$teksto=str_replace("##FONTO##","http://samopiniuloj.esperanto-jeunes.org/ludu.php",$teksto);
				} else {
					$teksto=str_replace("##FONTO##",$row['fonto'],$teksto);
				}
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
