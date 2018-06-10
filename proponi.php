<?php 
$pagxo="akceptejo";
include "kapo.php";
include "db.php";
include "menuo.php";
$parto = $_REQUEST['parto'];
if ($parto=="") {$parto="1";}
?>
		<div id="bonvenon"><p>
		<?php if ($_SESSION['sam_id']!=null) { 
			echo "Bonvenon, ".troviNomon($_SESSION['sam_id']); 
		} else {
			echo "&nbsp;";
		}?>
		</p></div>
		<div id="regulo">
			<h2>Proponi bildon</h2>
				<p>Vi certe rimarkis ke novaj bildoj aperas &#265;iu-tage en nia ludejo. Beda&#365;rinde, tiuj bildoj ne aperas magie. 
				Por aldoni ilin, ni devas mal&#349;pari horojn por trovi ta&#365;gajn kaj nekopirajtajn bildojn, 
				modifi ilin por havi la grandecon de 140x140 rastrumeroj kaj registri &#265;ion en nian datumbazon.
				</p>
				<p>&#264;ar vi &#349;ategas tiun ludon, vi certe deziras helpi nin. 
				Por helpi nin, vi povas sendi bildon je la <b>&#285;usta grandeco (140x140)</b> al nia retadreso : <b><a href="mailto:samopiniuloj@esperanto-jeunes.org">samopiniuloj@esperanto-jeunes.org</a></b>
				</p>
				<p align="center"><img src="ekzemplo.gif"/></p>				
				<p>Ni Dankegas vin pro tio, <b>la samopiniuloj-teamo</b></p>
				
		</div>
<?php include "piedo.php";?>
