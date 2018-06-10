<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Samopiniuloj</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="KEYWORDS" content="Samopiniuloj" />
<meta name="robots" content="nofollow"/>
<meta name="viewport"  content="initial-scale=1, width=device-width">
<link type="text/css" media="screen and (max-width: 990px)" rel="stylesheet" href="style/sam2.css" title="Samopiniuloj" />
<link type="text/css" media="screen and (min-width: 991px)" rel="stylesheet" href="style/sam.css" title="Samopiniuloj" />
<link rel="shortcut icon" href="http://samopiniuloj.esperanto-jeunes.org/ico.gif" />
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-1302916-4";
urchinTracker();
</script>
<script type="text/javascript" src="xAlUtf8.js"></script>
<script type="text/javascript">
	var nbclic = 0;
	function atentu(f)
    {
        nbclic++;
        if (nbclic>1)
        {
            alert('Ne necesas alklaki plurajn fojojn!'+nbclic);
            nbclic=0;
        }
        else
        {
            f.submit();
        }
    }
	function resolution() {
		document.cookie="resolution="+screen.width+"*"+screen.height;
		document.location="<?php echo $_SERVER['PHP_SELF']; ?>";
	}
</script>
</head>
<?php 
	if (!isset($_COOKIE['resolution'])) {
		echo '<body onload="resolution();">';
} else {
		echo '<body>';
}
?>
<!-- <body> -->
<div id="kapo">
	<div id="titolo">
		<h1>Samopiniuloj</h1>
	</div>
</div>
<?php if ($_REQUEST['eraro']!="") { ?>
<div class="eraro"><?=$_REQUEST['eraro'] ?></div>
<?php } ?>
<?php if ($fripono) { ?>
<div class="eraro">Ha ha ha ! Fripono </div>
<?php } ?>