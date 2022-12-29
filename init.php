<?php
session_start();
//chargement de l' autoloader

require 'vendor/autoload.php';

$GLOBALS["command"]=[];

function  commande(String $commande){
    $data =  system($commande, $retour);
    return $data;
}

function serializeJson($json){
   $array = [];
   foreach ($json as $key => $value) {
    if(is_object($value)){
        $array[$key] = serializeJson((array)$value);
       
    }elseif(is_array($value)){
        $array[$key] = serializeJson($value);
    }else{
        $array[$key] = $value;
    }
   }
   return $array;
}

function execute($valeur){
    $output=null;
    $retval=null;
     exec($valeur,$output, $retval);
     return $output;
}
function url_serveur($link){
    $structure = new st();
 $url = str_replace("public/", "",$structure->asset($link));
 return $url;
}
function abort($header){
    header($header);
    echo json_encode(["response"=>"bad request"]);
    die;
}
function key_compare_func($key1, $key2)
{
    if ($key1["id"] == $key2["id"])
        return 1;
    
    else
        return 0;
}
 
function array_compare($comparer, $comparant){
    $final = [];
    foreach ($comparer as $key => $value) {
        if(!in_array($value, $comparant)){
            array_push($final, $value);
        }
    }
    return $final;
}

function reduce($str1, $str2)
  {
    return $str1 .", " . $str2;
  }

function reduce2($str1, $str2){
    return $str1 .", :".$str2;
}
function reduce3($nb1, $nb2){
    // var_dump($nb2);
    // die;
    return [ "data"=>$nb1["data"]+$nb2["data"]];
}
function operation($el){
    return array_reduce($el, "reduce3", ["data"=>0]);
}

function clemax($tableau){//tire la clé du plus grand nombre dans les valeurs d'un tableau
    if(is_array($tableau)){
    $maximum=$tableau[0];
    $cle=0;
    for($i=0;$i<count($tableau); $i++){
        if($tableau[$i]>$maximum){
            $maximum=$tableau[$i];
            $cle=$i;
        }
    }
    return $cle;
}else{return $tableau;} }

function clemax_array_assoc($array){
    if(!empty($array)){
        $max = premier_element($array);

    }else{ $max = null;}
   
    foreach ($array as $key => $value) {
        if($value>$max){
            $max = $value;
        }
       
    }
    return cle_element($max, $array);
}
function transform_array_assoc_to_index($array){
    
    $new_array = array();
    foreach ($array as $key => $value) {
        $new_array[compter_tableau($new_array)]=$value;
    }
    return $new_array;
}
function remove_element_in_array($cle_element, $array){
    $new_array = array();
    foreach ($array as $key => $value) {
        if($key!=$cle_element){
            $new_array[$key]=$value;
        }
    }
    return $new_array;
}

 // Compress image
        function compressImage($source, $destination, $quality) {
            $info = getimagesize($source);
           
            switch ($info['mime']) {
                case 'image/jpeg': $image = imagecreatefromjpeg($source);
                    break;
                case 'image/jpg': $image = imagecreatefromjpeg($source);
                    break;
                case 'image/gif': $image = imagecreatefromgif($source);
                    break;
                case 'image/png': $image = imagecreatefrompng($source);
                    # code...
                    break;
                default: $image = imagecreatefromjpeg($source);
                    break;
            }

            imagejpeg($image, $destination, $quality);

        }
        // fonction de calcul temps de publication
function temp($temp){


$difference=$temp;
$mois=floor($difference/2592000);
$jour=floor(($difference-($mois*2592000))/86400);
$ecriture=($difference-($mois*2592000)-($jour*86400))/3600;
$heure=floor($ecriture);
    $minute=floor(($difference-($mois*2592000)-($jour*86400)-($heure*3600))/60);
    
    
    if($mois>=1){
        $letemp="$mois mois";
    }
    // $letemp="$mois mois, $jour jr, $heure hr et $minute min";
    elseif($jour>1){
        $letemp="$jour jours ";
    }

    elseif($jour>0){
        $letemp="$jour jour ";
    }
    // $letemp="$jour jr, $heure hr et $minute min";
         elseif($heure>1){$letemp="$heure heures";}
    elseif ($heure>0) {
        $letemp="$heure heure et $minute minutes";
    }

    elseif($minute>1){$letemp="$minute minutes";}

    elseif($minute>0){$letemp="$minute minute";}

    else{$letemp=" un instant";}
    return $letemp;
}

// fonction de calcul temps de publication
function temp_publication($temp){

$timestamp=time();
$difference=$timestamp-$temp;
$mois=floor($difference/2592000);
$jour=floor(($difference-($mois*2592000))/86400);
$ecriture=($difference-($mois*2592000)-($jour*86400))/3600;
$heure=floor($ecriture);
    $minute=floor(($difference-($mois*2592000)-($jour*86400)-($heure*3600))/60);  
    if($mois>=1){
        $letemp="$mois mois";}elseif($jour>1){
        $letemp="$jour jours ";}elseif($jour>0){$letemp="$jour jour ";}
         elseif($heure>1){$letemp="$heure heures";}elseif ($heure>0) {$letemp="$heure heure"; }
elseif($minute>1){$letemp="$minute minutes";}
    elseif($minute>0){$letemp="$minute minute";}

    else{$letemp=" un instant";}
    return $letemp;
}

function found_cle_array_imbriquee($cle, $array_imbrique){
$retourne = false;
    foreach ($array_imbrique as $key => $value) {
        //var_dump($array_imbrique[$key]);
        foreach ($value as $cles => $valeur) {
            if($cle == $valeur){
                $retourne = $cles;
               
            }
        }
    }
    if($retourne){
        return $retourne;
    }else{
        return false;
    }
}
function type_document($sorte){
    // verificateur des types des documents sur bbv
    $aleat=str_shuffle("abcdefghijklmnopqrstuvwxyzesDDgtYYbn897432").''.time();
switch($sorte){
    case 'image/gif':$fichier='fichier'.$aleat.'.gif'; $type='image';
        break;
    case 'image/png':$fichier='fichier'.$aleat.'.png'; $type='image';
        break;
    case 'image/jpg':$fichier='fichier'.$aleat.'.jpg'; $type='image';
        break;
    case 'image/jpeg':$fichier='fichier'.$aleat.'.jpeg'; $type='image';
        break;
    case 'application/pdf':$fichier='fichier'.$aleat.'.pdf'; $type='fichier';
        break;
    case 'text/plain':$fichier='fichier'.$aleat.'.txt'; $type='texte';
        break;
    case 'audio/mpeg':$fichier='fichier'.$aleat.'.mp3'; $type='audio';
        break;
    case 'audio/mp3':$fichier='fichier'.$aleat.'.mp3'; $type='audio';
        break;
    case 'audio/ogg':$fichier='fichier'.$aleat.'.ogg'; $type='audio';
        break;
    case 'audio/wav':$fichier='fichier'.$aleat.'.wav'; $type='audio';
        break;
    case 'video/mp4':$fichier='fichier'.$aleat.'.mp4'; $type='video';
        break;
    case 'video/avi':$fichier='fichier'.$aleat.'.avi'; $type='video';
        break;
    case 'video/mpeg':$fichier='fichier'.$aleat.'.mpg'; $type='video';
        break;
    default: $fichier='defaut.png'; $type="imagette";
}
$arrayName = array('document' =>$fichier ,
                            'type' =>$type);
return $arrayName;
}
function age_maidusa($age_utilisateur){
    //controle l'age de l'utilisateur
$array_control = array("5-10", "11-18", "19-25", "adulte");
if(in_array($age_utilisateur, $array_control)){
    return true;
}else{return false;}

}
function control_sexe($sexe){
$array_control = array("masculin", "feminin");
if(in_array($sexe, $array_control)){return true;}else{return false;}
}

function est_dans_le_tableau($variable, $tableau){
    return in_array($variable, $tableau);
}
function get_name($identifiant){
$base = new base();
$donnees = $base->requette("SELECT * FROM utilisateur_identifier WHERE identifiant_speciale=\"".$identifiant."\"");
if($donnees){return html_filtres($donnees['nom']);}else{return false;}
}
function ecrire($variable){
    ?><?=$variable; ?><?php 
}

function cle_existe($cle, $tableau){
    //debogueur(cle_element($cle, $tableau));
   return array_key_exists($cle, $tableau);
}
function debogueur($variable){
    var_dump($variable);
}
 
  function html_filtres($filtre){
    return htmlspecialchars($filtre);
}
function texte_aleatoire($texte){
    return str_shuffle($texte);
}
function remplacer($terme, $remplaceur, $texte){
   return str_replace($terme, $remplaceur, $texte);
}
function echappe_guillemet($texte){
  return remplacer('"', "'", $texte);
}
function filtre_nombre($texte){
    return filter_var($texte, FILTER_SANITIZE_NUMBER_INT);
}
function filtre_html($texte){
   return filter_var($texte, FILTER_SANITIZE_SPECIAL_CHARS);
}
function filtre_email($email){
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}
function existe($variable){
    return isset($variable);
}
function ilya($tableau2, $tableau1){
// la fonction compare deux tableau dont le 1 contient lui-meme des tableaux
    // et le 2 est simple
    $x=0;
    $nb = count($tableau1);
    for($i=0; $i<count($tableau1); $i++){
     for($a=0; $a<count($tableau1[$i]); $a++){
     if(isset($tableau2[$a])){
        if($tableau2[$a]==$tableau1[$i][$a]){
            $x++;
        }
     }
     }
    }
    if(count($tableau2)<=$x){
        return true;
    }else{
        return false;
    }
}
function longueur_chaine($chaine){
    return strlen($chaine);
}

function longueur_chaine_filtre($chaine, $masque){
    return strcspn($chaine, $masque);
}
function compter_tableau($valeur){
    return count($valeur);
}
function filter_tableau($variable){
    return is_array($variable);
}
function filter_int($variable){
    return is_int($variable);
}
function filter_string($variable){
    return is_string($variable);
}
function c_est_un_tableau($variable){
    return is_array($variable);
}
function cle_element($recherche, $tableau){
    return array_search($recherche, $tableau);
}

function melanger2tableau($tableau1, $tableau2){
    return array_merge($tableau1, $tableau2);
}
function distribution_frequence($tableau){
    return array_count_values($tableau);
}

function ajouter_au_tableau(&$tableau, $valeur){
    return array_push($tableau, $valeur);
}

function supprimer_element_par_cle($tableau, $cle){
    $nouveau_tableau = array();
    
foreach ($tableau as $key => $value) {
    
    if($key == $cle){}else{
   ajouter_au_tableau($nouveau_tableau, $value);
    //debogueur($nouveau_tableau);
}
}
return $nouveau_tableau;
}
function is_true($variable){
  if($variable){
    return true;
  }else{return false;}
}
function extraire_tableau_par_cle_assoc($tableau, $cle){
    $tableau_a_retourner = array();
    foreach ($tableau as $key => $value) {
        //debogueur($value);
        $tableau_a_retourner[compter_tableau($tableau_a_retourner)] = $value[$cle];
    }
    //debogueur($tableau_a_retourner);
return $tableau_a_retourner;
}

function vide($variable){
    return empty($variable);
}
function trie_aleatoire($tableau, $nombre_element_a_recupere){
  $tableau_a_retourner = array();
if(count($tableau)>$nombre_element_a_recupere){
   // var_dump($nombre_element_a_recupere);
$tableau_des_cles = array_rand($tableau, $nombre_element_a_recupere);
for($i=0; $i<count($tableau_des_cles); $i++){
  $tableau_a_retourner[count($tableau_des_cles)] = $tableau[$tableau_des_cles[$i]]; 
  $tableau_a_retourner = array_ordonne($tableau_a_retourner);
}
}else{
  $tableau_a_retourner = $tableau;
}
return $tableau_a_retourner;
}
 function decouper_en_tableau($delimiter, $variable){
    return explode($delimiter, $variable);
}
function taille_image($image){
    if(file_exists($image)){
       return getimagesize($image);
    }else{
      return false; 
    } }
function has_array($array){ // cette fonction verifie si un tableau contient un autre tableau et retourne la clé du dernier element tableau trouvé
    $cle = false;
   // $return = false;
for($i=0; $i<count($array); $i++){
    if(filter_tableau($array[$i])){
        
        $cle = $i;
    }
}
return $cle;
}
function premier_chaine_dans_tableau($tableau){
    $valeur = false;
    for($i=0; $i<count($tableau); $i++){
        if(filter_string($tableau[$i])){
       $valeur = $tableau[$i];
       $i = count($tableau);
        }
    }
    return $valeur;
}
function puissance($nombre, $exposant){
    return $nombre**$exposant;
}

function cle_element_semblable($array, $verificateur){
    $array_retour = array();
    foreach ($array as $key => $value) {
        if($value == $verificateur){
            $array_retour[compter_tableau($array_retour)] = $key;
        }
    }
    return $array_retour;
}

function premier_element($array){
//if()
   // var_dump($array);
    $compteur = 0;
    $premier_element = null;
    foreach ($array as $key => $value) {
        if($compteur == 0){
        $premier_element = $value;
        $compteur++; }
    }
    return $premier_element;
}

function dernier_element($array){
//if()
    $compteur = 0;
    $dernier_element = null;
    foreach ($array as $key => $value) {
        if($key == compter_tableau($array)-1){
        $dernier_element = $value;
        $compteur++; }
    }
    return $dernier_element;
}


function array_ordonne($array){
  $new_array = array();
  foreach ($array as $element) {
   $new_array[count($new_array)] = $element;
  }
  return $new_array;
}
function n_ieme_chaine_dans_tableau($tableau, $rang){
   $valeur = false;
   $compteur = 0;
    for($i=0; $i<count($tableau); $i++){
        if(filter_string($tableau[$i])){
            $compteur++;
            if($compteur==$rang){
       $valeur = $tableau[$i];
       $i = count($tableau);}
        }
    }
    return $valeur;
 
}
function get_array_filter($array, $array_cle){
    $new_array = array();
    foreach ($array as $key => $value) {
        $i = compter_tableau($new_array);
        //var_dump($value);
        for($inc=0; $inc<compter_tableau($array_cle); $inc++){
        $new_array[$i][$array_cle[$inc]] =     $value[$array_cle[$inc]];
        //var_dump($value[$array_cle[$inc]]);
        }
        
    }
   return $new_array;
}
function renome_cle_tableau($tableau, $tableau_des_cles){
    if(empty($tableau)){$tableau_a_retourner = array();}
    foreach ($tableau as $cle => $value) {
        foreach ($tableau_des_cles as $key => $valeurs) {
            if($cle == $key){
                $tableau_a_retourner[$valeurs] = $value;
            }
        }
    }
return $tableau_a_retourner;
}
$fncf_maidusa = true;


function add_au_tableau($tableau, $element_a_ajouter){

        return array_push($tableau, $element_a_ajouter);
    }
function DirSize($path , $recursive=TRUE){ 
    $result = 0; 
    if(!is_dir($path) || !is_readable($path)) 
    return 0; 
    $fd = dir($path); 
    while($file = $fd->read()){ 
    if(($file != ".") && ($file != "..")){
    if(@is_dir("$path$file/")) 
    $result += $recursive?DirSize("$path$file/"):0; 
    else 
    $result += filesize("$path$file"); 
    } 
    } 
    $fd->close(); 
    return $result; 
    }

function compare2tableau_associatif($tableau1, $tableau2, $ignore=""){ //les 2 tableaux divent avoir les memes clés
    //@ignore est une clé à ignoré dans la comparaison
    $result = true;
    foreach ($tableau1 as $key => $value) {
        if($tableau2[$key] == $value ){}elseif(!empty($ignore)){
            if($key==$ignore){}else{$result = false;}
        }else{$result = false;}
    }
    return $result;
}
function remove_numeric_keys($array){
    $new_array = array();
    foreach ($array as $key => $value) {
        if(c_est_un_entier($key)){}else{
            $new_array[$key] = $value;
        }
    }
    return $new_array;

}

function c_est_un_entier($valeur){
   
$value  = false;
if($valeur == '0' | is_int($valeur)){$value=true;  }elseif($valeur=='-1' && (intval($valeur)==-1)){$value = true;}else{
    if(intval($valeur)!=0 && !is_int($valeur)){$value = true;}
}
return $value;
}
function remove_colonne_in_array($colonne, $array){
    $new_array = array();
    foreach ($array as $key => $value) {
        if($key==$colonne){}else{
            $new_array[$key]=$value;
        }
    }
    return $new_array;

}
function array_has_boolean($array){
    $retour = false;
    foreach ($array as $key => $value) {
        if(is_bool($value)){$retour = true;}
        
    }

    return $retour;

}

function extract_boolean_in_array($array){//retourne un booleen qui est dans un tableau cette fonction doit s'utiliser en association avec la fonction  array_has_boolean ex : if(array_has_boolean($tableau)){ $variable = extract_boolean_in_array($tableau);}
$retour = false;
foreach ($array as $key => $value) {
    // if(is_bool($value)){
    //     $retour = $value
    // }
}

return $retour;
}
function limiteur_textes($textes, $nb_caractere){
    if($nb_caractere>strlen($textes)){
        $final = $textes;
    }else{$final = substr($textes, 0, $nb_caractere)."...";}

    return $final;
}
function tri_rapide(&$tableau, $indicedebut, $indicefin){
    if ($indicedebut < $indicefin) {
        $tab_partitionner = partition($tableau, $indicedebut, $indicefin);
        $tableau = $tab_partitionner['tableau'];
        $milieu = $tab_partitionner['milieu'];
         tri_rapide($tableau, $indicedebut, $milieu);
         tri_rapide($tableau, $milieu+1, compter_tableau($tableau));

    }

 return $tableau;
}

function partition($tableau, $debut, $fin){
$x = $tableau[$fin];
$i = $debut-1;
for ($j=$debut; $j < $fin; $j++) { 
    if($tableau[$j]<$x){
        $i++;
       // $x=$tableau[$fin];
        $tampon = $tableau[$i];
        $tableau[$i] = $tableau[$j];
        $tableau[$j] = $tampon;
    }
}

$tampon = $tableau[$i+1];
$tableau[$i+1] = $tableau[$fin];
$tableau[$fin] = $tampon;

return array("tableau"=>$tableau, "milieu"=>$fin);

}
function multiple_alternative_interval($valeur, $tableau_de_valeur){ 
    //cette fonction retourne true si $valeur se trouve dans l'une des intervalle du tableau de valeurs
    // tableau de valeur contient un tableau à 2 dimension dont chaque element contient une valeur maximale et une minimale 
    // ex: $tab = array(array("min"=>2, "max"=>6), array("min"=>12, "max"=>74), array("min"=>82, "max"=>96));
    $retour = false;
    foreach ($tableau_de_valeur as $key => $value) {
       if($valeur>=$value['min'] && $valeur<=$value['max']){
        $retour = true;
       }
    }

return $retour;
}
function valeur_proches($valeur, $tableau_des_valeurs, $positif=false){
    //cette fonction retourne la valeur du tableau qui est la plus proches de la valeurs données 
    //si positif est à true on ne cherche que des valeurs superieur ou égale à la valeur
    //var_dump($positif);
    //echo $valeur."<".$tableau_des_valeurs[2];
  if(!$positif){
    $cette_valeur = $tableau_des_valeurs[0];
    $pivot = 9999999999;//abs($cette_valeur-$valeur);

    foreach ($tableau_des_valeurs as $key => $value) {
        if($pivot>abs($value-$valeur)){
            $cette_valeur = $value;
            $pivot =abs($value-$valeur); 
        }
    }
     }else{

         $cette_valeur = $tableau_des_valeurs[0];
    $pivot = 9999999999;//abs($cette_valeur-$valeur);
    $pivot_signe = $cette_valeur-$valeur;
   //echo $pivot_signe." ";
    foreach ($tableau_des_valeurs as $key => $value) { 
       
        if($pivot>abs($value-$valeur) && ($value-$valeur)>=0){
            $cette_valeur = $value;
            $pivot = abs($cette_valeur-$valeur); 
            $pivot_signe = $cette_valeur-$valeur;
            
        }
    }
    //echo $pivot_signe." ";
    if($pivot_signe<0){$cette_valeur = false;}

     }


     return $cette_valeur;

}
function trie_par_colonne($tableau, $colonne, $ordre){
//cette fonction trie un tableau en tenant compte d'une colonne comme en sql
//exemple ORDER BY date, le tableau doit contenir des elements tableau associatif
//$ordre nous dit si nous devons trier de manière ascendant ou descendant
    //var_dump($tableau);
    $tab_retour = array();
$tab_colonne=array();
foreach ($tableau as $key => $value) {
    //var_dump($value);
    $tab_colonne[compter_tableau($tab_colonne)] = $value[$colonne];
}
if($ordre=="ascendant"){
sort($tab_colonne);
}else{
rsort($tab_colonne);
}

foreach ($tab_colonne as $key => $value) {
 $cles = recherche_cle_in_array($tableau, $colonne, $value);
   $tab_retour[compter_tableau($tab_retour)] = $tableau[$cles];
   supprimer_element_par_cle($tableau, $cles);

}

return $tab_retour;
}
function recherche_cle_in_array($tableau, $colonne, $valeur){
    foreach ($tableau as $key => $value) {
        if($value[$colonne] == $valeur){
            return $key;
        }
    }
}

function taille_en_octet($var){

ob_start();
 var_dump($var);
 //$var = ob_get_contents();
 $taille = ob_get_length();
 ob_end_clean();
return $taille;
}
function compare($tableau1, $tableau2){
    if(empty(array_diff_assoc($tableau1, $tableau2))){
        return true;
    }else{return false;}

}
function is_associative_array($tableau){
    $retourne = false;
foreach ($tableau as $key => $value) {
    if(is_int($key)){}else{$retourne = true; return $retourne;}
}
return $retourne;
}
function transform_dec_en_hexa($texte){
    return bin2hex($texte);

}
function transform_hexa_en_dec($texte){
    return hex2bin($texte);
}
function transform_all_hexa_en_dec($donnees, $cle_texte){
    $data = array();
foreach ($donnees as $key => $value) {
    $value[$cle_texte] = transform_hexa_en_dec($value[$cle_texte]);
    array_push($data, $value);
}
return $data;
}
function transform_all_dec_en_hexa($donnees, $cle_texte1, $cle_texte2=""){
    $data = array();
foreach ($donnees as $key => $value) {
    $value[$cle_texte1] = transform_dec_en_hexa($value[$cle_texte1]);
    if(!empty($cle_texte2)){
        $value[$cle_texte2] = transform_dec_en_hexa($value[$cle_texte2]);
    }
    array_push($data, $value);
}
return $data;
}

function get_url(){
     if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'){
    $url = "https"; 
  }else{
    $url = "http"; 
  }
    
  // Ajoutez // à l'URL.
  $url .= "://"; 
    
  // Ajoutez l'hôte (nom de domaine, ip) à l'URL.
  $url .= $_SERVER['HTTP_HOST']; 
    
  // Ajouter l'emplacement de la ressource demandée à l'URL
  $url .= $_SERVER['REQUEST_URI']; 
      
  // Afficher l'URL
  return $url; 
}
function get_page_name($url){
    $tab = explode("/", $url);
    $last = explode("?", $tab[compter_tableau($tab)-1]);
    $page_name = compter_tableau($last)>1 ? $last[compter_tableau($last)-2] : $last[compter_tableau($last)-1];

    return $page_name;
}
function request_header($url){
    $tab = explode("/", $url);
    $last = explode("?", $tab[compter_tableau($tab)-1]);
   // var_dump($tab);
    $var = explode("&", $last[compter_tableau($last)-1]);
    $array_retour = array();
    foreach ($var as $key => $value) {
        if(preg_match("/=/", $value)){
         $array_retour[compter_tableau($array_retour)][explode("=", $value)[0]] = explode("=", $value)[1];
        }
     } 
   return $array_retour;
}



function get_repertoire($repertoire){
    $dir = $repertoire;
$fichiers = array() ;
while( $nom = $dir->read() ) $fichiers[] = $nom ;
return $fichiers;
}
function impose_order_in_array($array, $colonne_order){//exige un certain ordre dans les colonnes
    //array est un tableau associatif
 $tableau = array();
 foreach ($colonne_order as $key => $value) {
    $tableau[$value] = $array[$value];
 }
 return $tableau;
}
function substr2($textes, $debut, $fin){
$textes_a_retourner = '';
for($i=0; $i<strlen($textes); $i++){
    if($i>=$debut && $i<=$fin ){
        $textes_a_retourner = $textes_a_retourner.''.$textes[$i];
    }
}
 return $textes_a_retourner;
}
function texte_aleatoire_unique(){
    return str_shuffle("abcdefghijklmnopqrstuvwxyz1234567890").''.time();
}
function generate_identifiant(){
    return time()."".str_shuffle("abcdefghijklmnopqrstuvwxyz1234567890");
}
use \models\structure;
function route(){
    
    return str_replace(structure::data()['domaine'], "", get_url());
}


?>