<?
include "../db.php";
malfermiDatumbazon();
 
$fs  = array();
$base = array();

$dir = "/arthur/sites/samopiniuloj/dosiero";
$dh  = opendir($dir);
while (false !== ($filename = readdir($dh))) {
   $fs[$filename] = $filename;
}

$query = "select dosiero from sam_vortoj";
mysql_select_db("ikurso");
$result = mysql_query($query) or die ("INSERT : Invalid query :".$query);
while ($row = mysql_fetch_array($result)) {
	$rep = array("dosiero","");
	$fichier = strtr($row[dosiero],array("/dosiero/"=>""));
	$base[$fichier] = $fichier;
}
$result = array_diff($fs,$base);
echo "<pre>";
print_r($result);
echo "</pre>";
?>
