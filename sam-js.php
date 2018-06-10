<?php
date_default_timezone_set('Europe/Paris');
header('Content-type: application/javascript');
include "db.php";
$agado = $_REQUEST['agado'];
$sam_retadreso = $_REQUEST['sam_retadreso'];
$sam_fonto = $_REQUEST['sam_fonto'];
$personnomo = $_REQUEST['personnomo'];

?>

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
		document.location="/ludu.php";
	}
	
<?


function echo_js($chaine) {
	echo "document.write(\"".str_replace('"','\\"',$chaine)."\");\n";
}

// fonction pour l'enregistrement
function verifiRadikon($mot,$vorto_id) {
	$radikoj = troviRadikon($vorto_id);
	for ($i=0;$i<count($radikoj[1]);$i++) {
		$radiko = trim($radikoj[1][$i]);
		if (!(strpos(konvMinMaj($mot), konvMinMaj($radiko))===FALSE)) {
			return "Radiko%20trovita";
		}
	}
	return null;
}


// prend les jours en parametre s'ils sont donnés ou alors le jour d'aujourd'hui
if ($_REQUEST['tago']!=null) {$tago = $_REQUEST['tago'];} else {$tago = date('d');}
if ($_REQUEST['monato']!=null) {$monato = $_REQUEST['monato'];} else {$monato = date('m');}
if ($_REQUEST['jaro']!=null) { $jaro = $_REQUEST['jaro'];} else {$jaro = date('Y');}
// pour les jours des rezultat, pareil, mais prendre la veille si aucun parametre n'est donnee
$hier = time() - (24 * 60 * 60);
if ($_REQUEST['rezultoj_tago']!=null) {$rezultoj_tago = $_REQUEST['rezultoj_tago'];} else {$rezultoj_tago = date('d',$hier);}
if ($_REQUEST['rezultoj_monato']!=null) {$rezultoj_monato = $_REQUEST['rezultoj_monato'];} else {$rezultoj_monato = date('m',$hier);}
if ($_REQUEST['rezultoj_jaro']!=null) { $rezultoj_jaro = $_REQUEST['rezultoj_jaro'];} else {$rezultoj_jaro = date('Y',$hier);}
// on ouvre la base de données que si nécessaire
if (($agado=="ludo") or ($agado=="ludis") or ($agado=="alighilo") or ($agado=="ludantorezulto") or ($agado=="vortrezulto")) {
	malfermiDatumbazon();
}

if ($agado=="ludis") {
	// ici on enregistre les resultats
	// on recupere quelques infos :
	$ludanto_id = troviIdElRetadreso($sam_retadreso);
	$vorto_id = troviVortonId($tago,$monato,$jaro);
	
	$jamprop = troviProponojn($vorto_id,$ludanto_id);
	for ($i=0;$i<8;$i++) {
		if ($jamprop[$i]!=null) {
			$vortaro[$jamprop[$i]]='jes';
		}
	}
	$prop[0]=trim($_REQUEST["prop0"]);
	$prop[1]=trim($_REQUEST["prop1"]);
	$prop[2]=trim($_REQUEST["prop2"]);
	$prop[3]=trim($_REQUEST["prop3"]);
	$prop[4]=trim($_REQUEST["prop4"]);
	$prop[5]=trim($_REQUEST["prop5"]);
	$prop[6]=trim($_REQUEST["prop6"]);
	$prop[7]=trim($_REQUEST["prop7"]);
	
	for ($i=0;$i<8;$i++) {
		//if ($prop[$i]!=null) {
			$res = verifiRadikon($prop[$i],$vorto_id);
			if ($res!=null) {
				$eraro = $res;
				continue;
			}
			if (($vortaro[strtolower($prop[$i])]==null)||($prop[$i]==null)) {
				$vortaro[strtolower($prop[$i])]='jes';
				registriProponon($vorto_id,$ludanto_id,$prop[$i],$i);
			} 
		//}
	}	
} 
if ($agado=="alighilo") {	
	// ici on memorise l'inscription (son prénom) du joueur 
	alighasNomonKajRetadreson($personnomo,$sam_retadreso,$sam_fonto);
}
if (($agado=="ludo") or ($agado=="ludis") or ($agado=="alighilo")) {
	// que le joueur s'inscrive, ait joué ou vient d'arriver, on lui affiche le jeu (rempli éventuellement)
	$kromnomo = troviNomonElRetadreso($sam_retadreso);
	// si le joueur n'est pas en base, on lui demande de se présenter
	if ($kromnomo==NULL) {
		echo_js("Vi neniam ludis tie, kiu estas via nomo ?<br/>");
		// formulaire de prénom + liens avec agado = "alighilo"
		echo("document.write(\"<form method='GET' action='\"+location.href+\"'>\");");
		echo_js("Mia nomo estas : ");
		echo_js("<input type='hidden' name='agado' value='alighilo'>");
		echo_js("<input type='text' name='personnomo'>");
		echo_js("<input type='submit' value='Ek!'>");
		echo_js("</form>");
	} else {
	// on recupere quelques infos :
	$ludanto_id = troviIdElRetadreso($sam_retadreso);
	$vorto = troviVorton($tago,$monato,$jaro);
	$vorto_id = troviVortonId($tago,$monato,$jaro);
	// AFFICHAGE du jeu
	echo("document.write(\"<div id='menuo'><a href='\"+location.href+\"?agado=ludantorezulto'>Rezultoj la&#365; ludantoj</a> / <a href='\"+location.href+\"?agado=vortrezulto'>Rezultoj la&#365; vorto</a></div>\");"); // 
	echo_js("<div id='bonvenon'>Bonvenon, ".$kromnomo."</div>");
	echo_js("<div id='ludo'>");
		echo_js("<div class='parto'>");
			echo_js('<div class="dato">');
			echo_js("<p>La vorto de tiu tago estas :</p>");
			echo_js('<p class="vorto">'.x2utf($vorto).'</p>');
				echo_js('<div id="vorto"><img src="http://samopiniuloj.esperanto-jeunes.org/'.troviBildon($tago,$monato,$jaro).'" /></div>');
			echo_js('</div>');
		echo_js('<div class="parto">');
			echo_js('<p>Viaj proponoj :<span class="rimarko"><br />(vi rajtas &#349;an&#285;i ilin &#285;is la horlimo)</span></p>');
			echo_js('<p class="rimarko">Tajpu cx, sx... por ricevi &#265;, &#349;...</p>');
			echo("document.write(\"<form name='ludoform' method='get' action='\"+location.href+\"' onsubmit='atentu(this.form);'>\");"); // on est obligé de les passer en GET pour pouvoir récuperer les paramètres en javascript via l'url
			echo_js('<input type="hidden" name="vorto_id" value="'.$vorto_id.'" />');
			echo_js('<input type="hidden" name="agado" value="ludis" />');
			
			// liste des mots 
			echo_js('<table>');
			for ($i=0;$i<8;$i++) { 
						// Emmanuelle (7.10.2006) : conversion des x en lettres accentuées pour l'affichage
						$propono = x2utf(troviProponon($vorto_id,$ludanto_id,$i));
				echo_js('<tr>');
					echo_js('<td class="num">&nbsp;'.($i+1).'&nbsp;</td>');
					echo_js('<td><input ');
					if ($propono) {
						echo_js(" class=\"jam\"");
					} 
					echo_js('type="input" name="prop'.$i.'" value="'.$propono.'" onkeyup="xAlUtf8(this)"/></td>');
				echo_js('</tr>');
			}	
			echo_js('</table>');
			echo_js('<input type="submit" value="sendu">');
			
			//fin de la liste des mots	
			echo_js('</form>');
		echo_js("</div>"); // div parto	
		echo_js("</div>");	
		echo_js("</div>");
	}	
 } elseif ($agado=="ludantorezulto") {
 	// pour les resultats, on affiche les resultats de la veille
	//echo_js("kikoo tag");
	$ludanto_id = troviIdElRetadreso($sam_retadreso);
	//echo_js($ludanto_id);
	//echo_js("<br/>".$rezultoj_monato);
	//echo_js("<br/>".$rezultoj_jaro);
	//echo_js("<br/>".$rezultoj_tago);
	$ludintoj = montriRezulton($rezultoj_tago,$rezultoj_monato,$rezultoj_jaro);
	$nbLudintoj = sizeof($ludintoj);
	$i=0; $antauxa=0; $col=0; $vico=0;
	echo_js("<table>");
	foreach ($ludintoj as $ludinto) {
		echo_js("<tr ");
		if ($ludanto_id==$ludinto['id']){
			echo_js(" class='dika'");
		}
		echo_js(">");
		if ($ludinto['poentoj']!=$antauxa) {
			$vico=$i+1;
			echo_js("<td class='rimarko' width='25'>".$vico."</td>"); 
		} else {
			echo_js("<td class='rimarko'>&nbsp;</td>");
		}
		$antauxa=$ludinto['poentoj'];
		echo_js("<td>".$ludinto['kromnomo']."</td>");
		echo_js("<td width='25' style='dekstre'>".$ludinto['poentoj']."</td></tr>");
		$i++;
	}
	echo_js("</table>");
	
} elseif ($agado=="vortrezulto") {
	//echo_js("kikoo vortrezulto");
	$ludanto_id = troviIdElRetadreso($sam_retadreso);
	$rezultoj=montriStatistikojn($rezultoj_tago,$rezultoj_monato,$rezultoj_jaro,$ludanto_id);
	// nombre de propositions total = taille du tableau
	$nbProponoj=count($rezultoj);
	// nombre d'élements par colonne = l'arrondi superieur dans la division par 4
	$nbParCol = ceil($nbProponoj / 4 );
	echo_js("<table>");
	$i=0;
	// affichage des mots sur 4 colonnes
	foreach ($rezultoj as $rezulto) {
		//print_r($rezulto);
		//if ($i==0) {echo "<td valign='top' width='25%'><table>";}
		echo_js("<tr");
		if ($rezulto['proponitaVorto'] > 0) {echo_js(" style='font-weight:bold'");}
		echo_js("><td");
		if ($rezulto['kiom']==1) {echo_js(" class=griza");};
		echo_js(">".x2utf($rezulto['propono'])."</td>");
		if ($rezulto['kiom']==1) {echo_js("<td class='helbruna'>0</td></tr>");}
		else {echo_js("<td class='rimarko'>".$rezulto['kiom']."</td></tr>");}
		//echo_js(">".$rezulto['kiom']."</td></tr>");
		$i++;
		// si $i a atteint le nombre d'element par colonne, on ferme une table (de la colonne)
		//if ($i==$nbParCol) {$i=0; echo "</table></td>";}					
	}
	//if ($i) {echo "</table></td></tr>";}
	echo_js("</table>");
	
} else {

?>

/* fonction pour récupérer les variables */
function getVar (nomVariable) {
	var infos = location.href.substring(location.href.indexOf("?")+1, location.href.length)+"&"
	if (infos.indexOf("#")!=-1)
	infos = infos.substring(0,infos.indexOf("#"))+"&"
	var variable="";
	{
	nomVariable = nomVariable + "="
	var taille = nomVariable.length
	if (infos.indexOf(nomVariable)!=-1)
		variable = infos.substring(infos.indexOf(nomVariable)+taille,infos.length).substring(0,infos.substring(infos.indexOf(nomVariable)+taille,infos.length).indexOf("&"))
	}
	return variable
} 

function writeHiddenVar() {
	// on recupere les parametres depuis le ? et on ajoute un & à la fin
	var infos = location.href.substring(location.href.indexOf("?")+1, location.href.length)+"&"
	// si on a un diese (anchre à l'intérieur de la page), on ne prends que l'url jusqu'à ce diese et on ajoute un & à la fin
	if (infos.indexOf("#")!=-1) {
		infos = infos.substring(0,infos.indexOf("#"))+"&"
	}
	var variable="";
	var value="";
	while (infos.indexOf("=")!=-1) {
		//document.write("infos "+infos+"<br/>");
		variable = infos.substring(0,infos.indexOf("="));
		valeur = infos.substring(infos.indexOf("=")+1,infos.indexOf("&"));
		//document.write("variable:"+variable+"<br/>");
		//document.write("valeur:"+valeur+"<br/>");
		// on réduit la chaine de parametre de l'url en retirant la premiere variable, sa valeur et les 2 caracteres = et &
		infos = infos.substring(variable.length + valeur.length+2,infos.length);
		if (variable!="departement"){
			document.write("<input type='hidden' name='"+variable+"' value='"+valeur+"'>");
		}
	}
} 
// ni prenu la argumentojn el la URL
var agado = getVar("agado");
var personnomo = getVar("personnomo");
var prop0 = getVar("prop0");
var prop1 = getVar("prop1");
var prop2 = getVar("prop2");
var prop3 = getVar("prop3");
var prop4 = getVar("prop4");
var prop5 = getVar("prop5");
var prop6 = getVar("prop6");
var prop7 = getVar("prop7");

//
if (typeof(sam_fonto)=='undefined'){
	document.write("<span class='eraro'>La retejo malbone estis agordita. Bonvolu kontakti la respondeculon ) (erarkodo : sam_fonto mankas)</span>");
}else if (typeof(sam_retadreso)=='undefined'){
	document.write("<span class='eraro'>La retejo malbone estis agordita. Bonvolu kontakti la respondeculon ) (erarkodo : sam_retadreso mankas)</span>");
} else {
	document.write('<style type="text/css">');
	document.write('<!--');
	document.write('/*  ... ici sont d&eacute;finis les formats ... */');
	document.write('.jam {');
	document.write('background-color:#CCCCCC;');
	document.write('{');
	document.write('-->');
	document.write('</style>');

	if (agado==""){
		agado="ludo";
	}	
	if ((agado=="ludis") || (agado=="ludantorezulto")|| (agado=="vortrezulto")) {
		document.write('<script src="http://samopiniuloj.esperanto-jeunes.org/sam-js.php?agado='+agado+'&sam_retadreso='+sam_retadreso+'&sam_fonto='+sam_fonto+'&personnomo='+personnomo+'&prop0='+prop0+'&prop1='+prop1+'&prop2='+prop2+'&prop3='+prop3+'&prop4='+prop4+'&prop5='+prop5+'&prop6='+prop6+'&prop7='+prop7+'"></script>');
	} else {
		// ludo
		document.write('<script src="http://samopiniuloj.esperanto-jeunes.org/xAlUtf8.js"></script>');
		document.write('<script src="http://samopiniuloj.esperanto-jeunes.org/sam-js.php?agado='+agado+'&sam_retadreso='+sam_retadreso+'&sam_fonto='+sam_fonto+'&personnomo='+personnomo+'"></script>');
	}
}

<?
}
?>