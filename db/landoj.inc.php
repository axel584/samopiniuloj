<?php
/*
 * trovas nomon de lando, laux la kodo
 */
function troviLandon($kodo) {
	$query = "select nomo from landoj where lingvo='EO' and kodo='".$kodo."'";
	mysql_select_db("sam");
	$result = mysql_query($query) or die ("INSERT : Invalid query :".$query);
	$row = mysql_fetch_array($result);
	return $row['nomo'];
}
/*
 * trovas liston de cxiuj landoj
 * EL : listo de landoj
 */
function listiLandojn() {
     $demando =  "select kodo, nomo from landoj where lingvo='EO' order by nomo"; 
     mysql_select_db( "sam"); 
     $result = mysql_query($demando) or die (  "SELECT : malbona demando :".$demando); 
     $i=0;
     while($row = mysql_fetch_array($result)) {
		$lando[$i]['kodo'] = $row['kodo'];
		$lando[$i]['nomo'] = $row['nomo'];
		$i++;
     }
     return $lando;
}

?>