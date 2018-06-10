<?php
include "config.php";
include "db/datoj.inc.php";
include "db/landoj.inc.php";
include "db/personoj.inc.php";
include "db/proponoj.inc.php";
include "db/vortoj.inc.php";
include "db/rezultoj.inc.php";

$monatnomo = array (
	'', 'Januaro','Februaro','Marto', 
	'Aprilo', 'Majo', 'Junio',
	'Julio', 'Augusto', 'Septembro',
	'Oktobro', 'Novembro', 'Decembro');

function init() {
	dl('mysql.so');
}

function malfermiDatumbazon () {
	global $login,$motDePasse;
	if (!@function_exists('mysql_connect')) {
    		init();
	}
     $link = mysql_connect("127.0.0.1",$login,$motDePasse) or die ("Connexion impossible");
}

function fermiDatumbazon() {
   mysql_close();
}



function protokolo($ludanto_id, $kateg, $teksto) {
		$ip = $_SERVER['REMOTE_ADDR'];
		$query ="insert into sam_protokolo (ludanto_id, ip, dato, kategorio, teksto) values ('".$ludanto_id."','".$ip."',now(),'".$kateg."','".$teksto."')";
		mysql_select_db("sam");
		mysql_query($query) or die ("INSERT : Invalid query :".$query);	
}
function montriProtokolon() {
	echo "<table>";
	$query = "select * from sam_protokolo order by dato DESC limit 400";
	mysql_select_db("sam");
	$result = mysql_query($query) or die ("SELECT : Invalid query :".$query);
	while ($row = mysql_fetch_array($result)) {
		if ($row['kategorio']!="proponoj") {
			$nomo=troviNomon($row['ludanto_id']);
			echo "<tr><td>".$row['ip']."</td>";
			echo "<td class='rimarko' nowrap>".$row['dato']."</td>";
			echo "<td>".$nomo."</td>";
			echo "<td class='rimarko'>".$row['kategorio']."</a></td>";
			echo "<td>".$row['teksto']."</td></tr>";
		}
	}
	echo "</table>";
}

function MesagxoForgesemulo($retadreso) {
		// on recupere les donnees de la base
		$query = "select kromnomo,pasvorto from sam_ludantoj where retadreso='".$retadreso."' order by id asc";
		mysql_select_db("sam");
		$result = mysql_query($query) or die ("SELECT : Invalid query :".$query);
		$row = mysql_fetch_array($result);
		$nomo = $row[0];
		$pasvorto = $row[1];
	
		$dosiero = "retmesaghoj/pasvorto.html";
		$fd = fopen($dosiero, "r");
		$enhavo = fread($fd, filesize ($dosiero));
		fclose($fd);
		$enhavo=str_replace("##LUDANTO##",$nomo,$enhavo);
		$enhavo=str_replace("##PASVORTO##",$pasvorto,$enhavo);


		$mesagxkapo="MIME-Version: 1.0\n";
		$mesagxkapo.="Content-type: text/html;charset=utf-8\n";
		$mesagxkapo.="From: Samopiniuloj <samopiniuloj@esperanto-jeunes.org>\n";
		//$mesagxkapo.="Bcc: <emmanuelle@esperanto-jeunes.org>\n";
		$mesagxkapo.="Date: ".date("D, j M Y H:i:s").chr(13);
		$mesagxkapo.=" \n";
		mail($retadreso,"Samopiniuloj : via forgesita pasvorto",$enhavo,$mesagxkapo);
}

function MesagxoNovaLudanto($id, $nomo, $retadreso, $lando) {
		$dosiero = "/arthur/sites/sam/retmesaghoj/novaLudanto.html";
		$fd = fopen($dosiero, "r");
		$enhavo = fread($fd, filesize ($dosiero));
		fclose($fd);
		$enhavo=str_replace("##ID##",$id,$enhavo);
		$enhavo=str_replace("##NOMO##",$nomo,$enhavo);
		$enhavo=str_replace("##RETADRESO##",$retadreso,$enhavo);
		$enhavo=str_replace("##LANDO##",troviLandon($lando),$enhavo);

		$mesagxkapo="MIME-Version: 1.0\n";
		$mesagxkapo.="Content-type: text/html;charset=utf-8\n";
		$mesagxkapo.="From: Samopiniuloj <samopiniuloj@esperanto-jeunes.org>\n";
		//$mesagxkapo.="Bcc: <emmanuelle@esperanto-jeunes.org>\n";
		$mesagxkapo.="Date: ".date("D, j M Y H:i:s").chr(13);
		$mesagxkapo.=" \n";
		$adresatoj="emmanuelle@esperanto-jeunes.org,axel584@axel584.org";
		mail($adresatoj,"Nova ludanto en Samopiniuloj",$enhavo,$mesagxkapo);
}
?>
