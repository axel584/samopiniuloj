<?php
/*
 * trovas vorton laux tago kaj cxirkauxias la radikon per <rad>-markoj
 * EN : tago, monato, jaro
 * EL : vorto
 */
 function troviVorton($tago, $monato, $jaro) {
	$query = "select vorto from sam_vortoj where tago='".$tago."' and monato='".$monato."' and jaro='".$jaro."'";
	mysql_select_db("sam");
	//$result = mysql_query($query) or die ("INSERT : Invalid query :".$query);
	$result = mysql_query($query);
	echo mysql_error();
	$row = mysql_fetch_array($result);
	$vorto = $row['vorto'];
	$vorto = strtr($vorto,array("<rad>" => "<u>", "</rad>" => "</u><span style='font-size:6px'>&nbsp;</span>"));
	return $vorto;
}

/*
 * donas vort-id laux tago
 * EN : tago, monato, jaro
 * EL : vorto-id
 */
function troviVortonId($tago, $monato, $jaro) {
	$query = "select id from sam_vortoj where tago='".$tago."' and monato='".$monato."' and jaro='".$jaro."'";
	mysql_select_db("sam");
	$result = mysql_query($query) or die ("SELECT : Invalid query :".$query);
	$row = mysql_fetch_array($result);
	//$vorto = $row['id']; // inutile si on renvoit le row id
	return $row['id'];
}

/*
 * donas tago laux vorto_id (la malo de troviVortonId)
 * EN : vorto-id
 * EL : tago, monato, jaro
 */
function troviTagLauxVortonId($vorto_id) {
	$query = "select tago,monato,jaro from sam_vortoj where id=".$vorto_id;
	mysql_select_db("sam");
	$result = mysql_query($query) or die ("SELECT : Invalid query :".$query);
	$row = mysql_fetch_array($result);
	$tago['tago'] = $row['tago'];
	$tago['monato'] = $row['monato'];
	$tago['jaro'] = $row['jaro'];
	return $tago;
}

function troviTagVortonId($tago,$monato,$jaro) {
	$query = "select id from sam_vortoj where tago='".$tago."' and monato='".$monato."' and jaro='".$jaro."'";
	mysql_select_db("sam");
	$result = mysql_query($query) or die ("SELECT : Invalid query :".$query);
	$row = mysql_fetch_array($result);
	$vorto = $row['id'];
	return $row['id'];;
}

/*
 * trovas laux la vorto-id parametro kiel tago=XX&monato=YY&jaro=ZZZZ 
 * EN : vorto-id
 * EL : tago=(d) monato=(m) jaro=(Y)
 */
function troviTagoParametrojn($vorto_id) {
	$query = "select tago,monato,jaro from sam_vortoj where id = ".$vorto_id;
	mysql_select_db("sam");
	$result = mysql_query($query) or die ("SELECT : Invalid query :".$query);
	$row = mysql_fetch_array($result);
	$t = mktime(12,00,00,$row['monato'],$row['tago'],$row['jaro']);
	return "tago=".date('d',$t)."&monato=".date('m',$t)."&jaro=".date('Y',$t);
}

/*
 * trovas radikon de iu vorto
 * EN : vorto-id
 * EL : rezulto de la demando
 */
function troviRadikon($id) {
	$query = "select vorto from sam_vortoj where id=".$id;
	mysql_select_db("sam");
	$result = mysql_query($query) or die ("SELECT : Invalid query :".$query);
	$row = mysql_fetch_array($result);
	$vorto = $row['vorto'];
	preg_match_all('/<rad>(.*)<\/rad>/U',$vorto,$result);
	return $result;
}

/*
 * insert vorton en la bazo (laux tago kaj dosiero)
 * EN : tago, monato, jaro, vorto, dosiero
 * EL : vico de la vorto en la tabelo
 */
function insertVorton($tago,$monato,$jaro,$vorto,$dosiero) {
	$query = "insert into sam_vortoj(tago,monato,jaro,vorto,dosiero) values('".$tago."','".$monato."','".$jaro."','".$vorto."','".$dosiero."')";
	mysql_select_db("sam");
	mysql_query($query) or die ("INSERT : Invalid query :".$query);
	$row = mysql_fetch_array(mysql_query('select last_insert_id() as last from sam_vortoj'));
	return $row['last'];
}

/*
 * gxisdatigas vorton en la datenbazo
 * EN : vorto-id, tago, monato, jaro, vorto, dosiero
 */
function updateVorton($id,$tago,$monato,$jaro,$vorto,$dosiero) {
	$query = "update sam_vortoj set tago='".$tago."',monato='".$monato."',jaro='".$jaro."',vorto='".$vorto."',dosiero='".$dosiero."' where id=".$id;
	mysql_select_db("sam");
	mysql_query($query) or die ("INSERT : Invalid query :".$query);	
}

/*
 * trovas bidon laux tago
 * EN : tago, monato, jaro
 * EL : dosiero
 */
function troviBildon($tago, $monato, $jaro) {
	$query = "select dosiero from sam_vortoj where tago='".$tago."' and monato='".$monato."' and jaro='".$jaro."'";
	mysql_select_db("sam");
	$result = mysql_query($query) or die ("SELECT : Invalid query :".$query);
	$row = mysql_fetch_array($result);
	return $row['dosiero'];
}

function editVorton($tago, $monato, $jaro) {
	$query = "select id,vorto,dosiero from sam_vortoj where tago='".$tago."' and monato='".$monato."' and jaro='".$jaro."'";
	mysql_select_db("sam");
	$result = mysql_query($query) or die ("SELECT : Invalid query :".$query);
	$row = mysql_fetch_array($result);
	if ($row!=null) {
		$vorto = $row['vorto'];
		$vorto = strtr($vorto,array("<rad>" => "", "</rad>" => ""));
		echo "<p><form method='post' name='formularo'>";
		echo "<table><tr><td valign='top'>";
		echo "ID : <input type='hidden' name='id' value='".$row[id]."' />".$row[id]."&nbsp;-&nbsp;";
		echo "Tago : <input type='text' name='tago' size='5' value='".$tago."' />&nbsp;";
		echo "Monato : <input type='text' name='monato' size='5' value='".$monato."' />&nbsp;";
		echo "Jaro : <input type='text' name='jaro' size='5' value='".$jaro."' /><br/>";
		echo "<span style='font-size:x-small;color:red'>Atentu: uzu nur la x-metodon por la vorto. Ne skribu ĉapelitajn literojn!</span><br/>";
		echo "Vorto : <input type='text' name='vorto' size='35' value='".$row[vorto]."' /><br/>";
		echo "URL : <input type='text' name='dosiero' size='65' value='".$row[dosiero]."' /><br/>";
		echo "<br/><center><input type='submit' value='Registri' name='UPDATE' /></center>";
		echo "</td><td>";
		echo "<div id='vorto'><img src='".$row[dosiero]."' /></div>";
		echo "</td></tr></table>";
		echo "</form></p>";
	} else {
		echo "<p><form method='post' name='formularo'>";
		echo "<table><tr><td valign='top'>";
		echo "Tago : <input type='text' name='tago' size='5' value='".$tago."' />&nbsp;";
		echo "Monato : <input type='text' name='monato' size='5' value='".$monato."' />&nbsp;";
		echo "Jaro : <input type='text' name='jaro' size='5' value='".$jaro."' /><br/>";
		echo "<span style='font-size:x-small;color:red'>Atentu: uzu nur la x-metodon por la vorto. Ne skribu ĉapelitajn literojn!</span><br/>";
		echo "Vorto : <input type='text' name='vorto' size='35' value='' />&nbsp;<input type='button' value='<rad>' onClick=\"insertion('<rad>','</rad>')\" /><br/>";
		// ici on met la liste des fichiers images qui existent
		$fs  = array();
		$base = array();

		$dir = "/arthur/sites/samopiniuloj/dosiero";
		$dh  = opendir($dir);
		while (false !== ($filename = readdir($dh))) {
   			$fs[$filename] = $filename;
		}

		$query = "select dosiero from sam_vortoj";
		mysql_select_db("sam");
		$result = mysql_query($query) or die ("INSERT : Invalid query :".$query);
		while ($row = mysql_fetch_array($result)) {
			$rep = array("dosiero","");
			$fichier = strtr($row[dosiero],array("/dosiero/"=>""));
			$base[$fichier] = $fichier;
		}
		$result = array_diff($fs,$base);
		echo "URL : <select name='dosiero' onChange=\"insertVorton(this.options[this.selectedIndex].value)\">";
		foreach ($result as $value) {
			if (strpos($value,".jpg")!==FALSE) {
				echo "<option value='/dosiero/".$value."'>/dosiero/".$value."\n";
			}
		}
		echo "</select><br/>";
		echo "<br/><center><input type='submit' value='Registri' name='INSERT' /></center>";
		echo "</td><td>";
		echo "<div id='vorto'><img src='../style/malplena.gif' /></div>";
		echo "</td></tr></table>";
		echo "</form></p>";	
	}
}

function utf2x($chaine) {
	$chaine=str_replace("&#264;","Cx",$chaine);
	$chaine=str_replace("&#265;","cx",$chaine);
	$chaine=str_replace("&#284;","Gx",$chaine);
	$chaine=str_replace("&#285;","gx",$chaine);
	$chaine=str_replace("&#292;","Hx",$chaine);
	$chaine=str_replace("&#293;","hx",$chaine);
	$chaine=str_replace("&#308;","Jx",$chaine);
	$chaine=str_replace("&#309;","jx",$chaine);
	$chaine=str_replace("&#348;","Sx",$chaine);
	$chaine=str_replace("&#349;","sx",$chaine);
	$chaine=str_replace("&#364;","Ux",$chaine);
	$chaine=str_replace("&#365;","ux",$chaine);
	// cas des caracteres pas encode
	$chaine=str_replace("Ã„Ë†","Cx",$chaine);
	$chaine=str_replace("Ã„â€°","cx",$chaine);
	$chaine=str_replace("Ã„Å“","Gx",$chaine);
	$chaine=str_replace("Ã„?","gx",$chaine);
	$chaine=str_replace("Ã„Â¤","Hx",$chaine);
	$chaine=str_replace("Ã„Â¥","hx",$chaine);
	$chaine=str_replace("Ã„Â´","Jx",$chaine);
	$chaine=str_replace("Ã„Âµ","jx",$chaine);
	$chaine=str_replace("Ã…Å“","Sx",$chaine);
	$chaine=str_replace("Ã…?","sx",$chaine);
	$chaine=str_replace("Ã…Â¬","Ux",$chaine);
	$chaine=str_replace("Ã…Â­  	","ux",$chaine);
	// cas des caracteres pas encode
	$chaine=str_replace("Ĉ","Cx",$chaine);
	$chaine=str_replace("ĉ","cx",$chaine);
	$chaine=str_replace("Ĝ","Gx",$chaine);
	$chaine=str_replace("ĝ","gx",$chaine);
	$chaine=str_replace("Ĥ","Hx",$chaine);
	$chaine=str_replace("ĥ","hx",$chaine);
	$chaine=str_replace("Ĵ","Jx",$chaine);
	$chaine=str_replace("ĵ","jx",$chaine);
	$chaine=str_replace("Ŝ","Sx",$chaine);
	$chaine=str_replace("ŝ","sx",$chaine);
	$chaine=str_replace("Ŭ","Ux",$chaine);
	$chaine=str_replace("ŭ","ux",$chaine);	
	
	return $chaine;
}

function x2utf($chaine) {
	$chaine=str_replace("Cx","&#264;",$chaine);
	$chaine=str_replace("cx","&#265;",$chaine);
	$chaine=str_replace("Gx","&#284;",$chaine);
	$chaine=str_replace("gx","&#285;",$chaine);
	$chaine=str_replace("Hx","&#292;",$chaine);
	$chaine=str_replace("hx","&#293;",$chaine);
	$chaine=str_replace("Jx","&#308;",$chaine);
	$chaine=str_replace("jx","&#309;",$chaine);
	$chaine=str_replace("Sx","&#348;",$chaine);
	$chaine=str_replace("sx","&#349;",$chaine);
	$chaine=str_replace("Ux","&#364;",$chaine);
	$chaine=str_replace("ux","&#365;",$chaine);
	return $chaine;
}

function konvMinMaj($vorto) {
	$specKar = array(
		"&#265;" => "cx",	
		"&#285;" => "gx",		
		"&#293;" => "hx;",
		"&#309;" => "jx",	
		"&#349;" => "sx",	
		"&#365;" => "ux",
		"&#264;" => "Cx",	
		"&#284;" => "Gx",		
		"&#292;" => "Hx",
		"&#308;" => "Jx",	
		"&#348;" => "Sx",	
		"&#364;" => "Ux",
		"ĉ" => "cx",	
		"ĝ" => "gx",		
		"ĥ" => "hx",
		"ĵ" => "jx",	
		"ŝ" => "sx",	
		"ŭ" => "ux",
		"Ĉ" => "Cx",	
		"Ĝ" => "Gx",		
		"Ĥ" => "Hx",
		"Ĵ" => "Jx",	
		"Ŝ" => "Sx",	
		"Ŭ" => "Ux"
		);
	foreach($specKar as $key => $val) {
		$vorto=str_replace($key,$val,$vorto);
	$vorto=strtoupper($vorto);
	}
	return $vorto;
}

/*
 * trovas novajn vortojn (por Android)
 * EN : id de la lasta vorto
 * EL : listo de novaj vortoj
 */
function troviNovajnVortojn($id) {
	$query = "select id,tago,monato,jaro,vorto,dosiero from sam_vortoj where id>=".$id;
	mysql_select_db("sam");
	$result = mysql_query($query) or die ("SELECT : Invalid query :".$query);
	return $result;
}
/*
 * trovas novajn vortojn laù monato (por Android)
 * EN : monato, jaro
 * EL : listo de novaj vortoj de la sama monato
 */
function troviNovajnVortojnLauMonato($monato,$jaro) {
	$query = "select id,tago,monato,jaro,vorto,dosiero from sam_vortoj where monato=".$monato." and jaro=".$jaro;
	mysql_select_db("sam");
	$result = mysql_query($query) or die ("SELECT : Invalid query :".$query);
	return $result;
}
?>
