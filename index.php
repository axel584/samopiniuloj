<?php 
session_start();
$pagxo="akceptejo";
include "db.php";
include "kapo.php";
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

		
			<h2>Reguloj</h2>
			<?php if ($parto=="1") {?>
				<p>Samopiniuloj estas simpla ludo. Ĉiutage aperas nova vorto kaj vi devas trovi 8 vortojn,
				 kiuj rilatas al tiu vorto sed kiuj ne enhavas saman radikon. Ekzemple, se aperas la vorto 
				 &ldquo;<b>luno</b>&rdquo; vi rajtas proponi :
				</p>
				<ul> 
					<li>Suno</li>
					<li>Eklipso</li>
					<li>Armstrong</li>
					<li>Astro</li>
					<li>Satelito</li>
					<li>...</li>
				</ul>
				<p>Vi ne rajtas proponi &ldquo;&nbsp;<b>lun</b>arko&nbsp;&rdquo; aŭ alian vorton, kiu enhavas tiun radikon.</p>
				<p>Tamen vi rajtas proponi vortojn kun la sama radiko, se tiu radiko ne estas en la vorto de la tago.</p>
				<p>Ekzemple, vi rajtas proponi &ldquo;paroli&rdquo; kaj &ldquo;parolo&rdquo; kaj &ldquo;parola&rdquo; : por la sistemo temas pri tri malsamaj vortoj.
				Same &ldquo;parolo&rdquo; kaj &ldquo;paroloj&rdquo; estas konsiderataj kiel malsamaj vortoj.</p>
				<p class="ligo"><a href="index.php?parto=2">antaŭen<img src='style/antauxen.gif' alt=">>"/></a></p>
			<?php } else { ?>
		
				<p>Se vorto ne taŭgas, la sistemo malakceptas &#285;in kaj vi tuj povas proponi alian vorton.</p>
				<p><strong>Atentu pri la uskleco!</strong> Se unu ludanto proponis &ldquo;<strong>L</strong>uno&rdquo; 
				kaj unu alia proponis &ldquo;<strong>l</strong>uno&rdquo;, 
				ili gajnas neniun poenton por tiuj vortoj &#265;ar por la sistemo, tiuj vortoj malsimilas. 
				Do prefereble skribu nur per minuskloj, krom komence de propraj nomoj.</p>
				<p>Post 24 horoj<span class="rimarko"><sup>*</sup></span>, &#265;iuj ludantoj ricevas poentojn se ili havas la samajn vortojn kiel la aliaj.
				Se neniu alia proponis la saman vorton, tiu vorto ricevigas neniun poenton al la ludinto.</p>
				<p>Provu, estas facile !</p>
				<p class="rimarko"><strong>Atentu!</strong> Kaze de friponado (ekzemple se ludantoj videble konsentis por proponi la samajn
					vortojn kaj tiel ricevi pli da poentoj) la administrantoj povos malakcepti la friponintojn, 
					forviŝi ties proponojn kaj poentojn.</p>  
				<br /><p class="rimarko">* nova luda tago komenciĝas je la 23a UTC. Rezultoj aperas post unu horo.</p>
				<p class="ligo"><a href="index.php?parto=1"><img src='style/retroen.gif' alt="<<"/> retroen</a></p>
			<?php } ?>
		</div>
<?php include "piedo.php";?>
