<?php 
include "db.php";
malfermiDatumbazon();

// tiu funkcio kontrolas, cxu adreso validas kaj ekzistas
function checkEmail($email)
{
	if ($email=="") {return FALSE;}
	if (eregi("^[a-zA-Z0-9_]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$]", $email)) {return FALSE;}
	list($Username, $Domain) = split("@",$email);
	if(getmxrr($Domain, $MXHost)) {return TRUE;}
	else {
	  if(fsockopen($Domain, 25, $errno, $errstr, 30)) {return TRUE;}
	  else {return FALSE;}
     }
}

$mesagxkapo="MIME-Version: 1.0\n";
$charset="utf-8";
$mesagxkapo.="Content-type:text/html;charset=".$charset."\n";			
$mesagxkapo.="From: Samopiniuloj <emmanuelle@esperanto-jeunes.org>\n";
if (checkEmail($_POST['sendinto'])) {
	if ($_POST["komento"]) {
		$mesagxkapo.="Cc: <".$_POST['sendinto'].">\n";
		$mesagxkapo.="Date: ".date("D, j M Y H:i:s ").chr(13);
		$adresatoj="emmanuelle@esperanto-jeunes.org,axel@esperanto-jeunes.org";
		$enhavo="<html><head><title>samopiniuloj-reago</title>\n";
		$enhavo.="<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"\n>";
		$enhavo.="<style>body{font-family:\"Courier New\", Courier, sans-serif;font-size:small}</style>\n";
		$enhavo.="</head><body>";
		$enhavo.="<p style='color:green;border-bottom:1px dashed green;'>Mesa&#285;o de ".$_POST['sendinto']." "; 
		if ($_SESSION['sam_id']) {$enhavo.="(".troviNomon($_SESSION['sam_id']).") ";}
		$enhavo.=":</p>\n";
		$enhavo.="<p>".stripslashes(nl2br($_POST['komento']))."</p>";
		$objekto="samopiniuloj-reago";
		mail($adresatoj,$objekto,$enhavo,$mesagxkapo);
		
		include "kapo.php";
		include "menuo.php";
		?>
		<div id="ludo">
			<div id="parto">
				<form>
				<!--
				<?php if ($_GET["eraro"]=="1"){
					echo "<p class='eraro'>Vi forgesis vian retadreson.</p>";
				} elseif ($_GET["eraro"]=="2"){
					echo "<p class='eraro'>Via mesa&#285;o estas malplena.</p>";
				} ?>
				-->
				<?php if ($_SESSION['sam_id']=="") { ?>
				<p>Via retadreso (deviga):<br/>
				<input type='text' name='sendinto' size='50' value="<?echo $_POST['sendinto'];?>">
				</p>
				<?php } ?>
				<p>Via mesa&#285;o:<br/>
				<textarea name="komento" rows="8" cols="60"  onkeyup='xAlUtf8(this)' ><?echo stripSlashes($_POST['komento']);?></textarea>
				</p>
				</form>
				<p><strong>Via mesa&#285;o estas sendita. Dankon pro via reago!</strong></p>
			</div>
		</div>
		<?php include "piedo.php";?>		
<?php 	
	} else {
		header("Location:reago.php?eraro=Via%20teksto%20estas%20malplena");
	}	
} else {
	header("Location:reago.php?eraro=Vi%20forgesis%20vian%20retadreson");
}
?>