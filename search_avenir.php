<?php
session_start();
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8;">
<?php
include('connexion2.php');

function get_categories(){ //récupère les catégories
    global $bdd;
    $req = $bdd -> prepare("SELECT * from categorie");
    $req -> execute();
    $get_categories = $req -> fetchAll();
    return $get_categories;
}
function dateFR($datePHP1) // transforme la date anglaise (de la base) en date française
{
    list($AAAA, $MM, $JJ) = explode("-", $datePHP1);
    $datePHP2 = $JJ."-".$MM."-".$AAAA;

    return $datePHP2;
}
function get_name($date, $val){ // cherche tout mot clé passé en paramètre dans $val dans le nom ou la description du jeu
    global $bdd;
    $req = $bdd -> prepare("SELECT * from jeux as j, categorie as c, age as a where j.IDCateg = c.IDCategorie and j.IDAge = a.IDAge and DateDeSortie > '$date' and (NomJeu like '%$val%' or Descriptif like '%$val%') order by NomJeu");
    $req -> execute();
    $get_name = $req -> fetchAll();
    return $get_name;
}
// trie la colonne Nom avec Catégorie sauvegardée
function get_nomasc_categ($date, $categ){
    global $bdd;
    $req = $bdd -> prepare("SELECT * from jeux as j, categorie as c, age as a where j.IDCateg = c.IDCategorie and j.IDAge = a.IDAge and IDCateg = '$categ' and DateDeSortie <= '$date' order by NomJeu;");
    $req -> execute();
    $get_nomasc = $req -> fetchAll();
    return $get_nomasc;
}
function get_nomdesc_categ($date, $categ){
    global $bdd;
    $req = $bdd -> prepare("SELECT * from jeux as j, categorie as c, age as a where j.IDCateg = c.IDCategorie and j.IDAge = a.IDAge and IDCateg = '$categ' and DateDeSortie <= '$date' order by NomJeu desc;");
    $req -> execute();
    $get_nomdesc = $req -> fetchAll();
    return $get_nomdesc;
}
//trie la colonne Sortie avec Catégorie sauvegardée
function get_sortieasc_categ($date, $categ){
    global $bdd;
    $req = $bdd -> prepare("SELECT * from jeux as j, categorie as c, age as a where j.IDCateg = c.IDCategorie and j.IDAge = a.IDAge and IDCateg = '$categ' and DateDeSortie > '$date' order by DateDeSortie;");
    $req -> execute();
    $get_nomasc = $req -> fetchAll();
    return $get_nomasc;
}
function get_sortiedesc_categ($date, $categ){
    global $bdd;
    $req = $bdd -> prepare("SELECT * from jeux as j, categorie as c, age as a where j.IDCateg = c.IDCategorie and j.IDAge = a.IDAge and IDCateg = '$categ' and DateDeSortie > '$date' order by DateDeSortie desc;");
    $req -> execute();
    $get_nomasc = $req -> fetchAll();
    return $get_nomasc;
}
// trie la colonne Nom sans Catégorie sauvegardée
function get_nomasc($date){
    global $bdd;
    $req = $bdd -> prepare("SELECT * from jeux as j, categorie as c, age as a where j.IDCateg = c.IDCategorie and j.IDAge = a.IDAge and DateDeSortie > '$date' order by NomJeu;");
    $req -> execute();
    $get_nomasc = $req -> fetchAll();
    return $get_nomasc;
}
function get_nomdesc($date){
    global $bdd;
    $req = $bdd -> prepare("SELECT * from jeux as j, categorie as c, age as a where j.IDCateg = c.IDCategorie and j.IDAge = a.IDAge and DateDeSortie > '$date' order by NomJeu desc;");
    $req -> execute();
    $get_nomdesc = $req -> fetchAll();
    return $get_nomdesc;
}
// trie la colonne Sortie sans Catégorie sauvegardée
function get_sortieasc($date){
    global $bdd;
    $req = $bdd -> prepare("SELECT * from jeux as j, categorie as c, age as a where j.IDCateg = c.IDCategorie and j.IDAge = a.IDAge and DateDeSortie > '$date' order by DateDeSortie;");
    $req -> execute();
    $get_nomasc = $req -> fetchAll();
    return $get_nomasc;
}
function get_sortiedesc($date){
    global $bdd;
    $req = $bdd -> prepare("SELECT * from jeux as j, categorie as c, age as a where j.IDCateg = c.IDCategorie and j.IDAge = a.IDAge and DateDeSortie > '$date' order by DateDeSortie desc;");
    $req -> execute();
    $get_nomasc = $req -> fetchAll();
    return $get_nomasc;
}
//trie par catégorie
function get_bycateg($date, $categ){
    global $bdd;
    $req = $bdd -> prepare("SELECT * from jeux as j, categorie as c, age as a where j.IDCateg = c.IDCategorie and j.IDAge = a.IDAge and IDCateg = '$categ' and DateDeSortie > '$date' order by DateDeSortie desc;");
    $req -> execute();
    $get_bycateg = $req -> fetchAll();
    return $get_bycateg;
}
 function get_jeux($date){ //récupère tous les jeux
    global $bdd;
    $req = $bdd -> prepare("SELECT * from jeux as j, categorie as c, age as a where j.IDCateg = c.IDCategorie and j.IDAge = a.IDAge and DateDeSortie > '$date' order by DateDeSortie;");
    $req -> execute();
    $get_jeux = $req -> fetchAll();
    return $get_jeux;
}
// récupération des données envoyées par l'AJAX
$status = $_POST['status'];
$val = (isset($_POST["val"])) ? addslashes($_POST["val"]) : NULL;
$categ = (isset($_POST["categ"])) ? addslashes($_POST["categ"]) : NULL;

$date=date("Y-m-d"); //date d'aujourd'hui
switch($status): //utilise les fonctions en fonction du status, décidé sur la page listant les jeux
    case 1:
        $lstJeux = get_name($date, $val);
        break;;
    case 2:
        if($categ == 0):
            $lstJeux = get_nomasc($date);
        else:
            $lstJeux = get_nomasc_categ($date, $categ);
        endif;
        break;
    case 3:
        if($categ == 0):
            $lstJeux = get_nomdesc($date);
        else:
            $lstJeux = get_nomdesc_categ($date, $categ);
        endif;
        break;
    case 4:
        if($categ == 0):
            $lstJeux = get_sortieasc($date);
        else:
            $lstJeux = get_sortieasc_categ($date, $categ);
        endif;
        break;
    case 5:
        if($categ == 0):
            $lstJeux = get_sortiedesc($date);
        else:
            $lstJeux = get_sortiedesc_categ($date, $categ);
        endif;
        break;
    case 6:
        if($categ == 0):
            $lstJeux = get_jeux($date);
        else:
            $lstJeux = get_bycateg($date, $categ);
        endif;
        break;
endswitch;
// affichage du résultat du tri
if (count($lstJeux) == 0): ?>
    Aucun jeu ne correspond à votre recherche. <a href="a_venir.php" class="lienbasique">Cliquez ici</a> pour recharger la page des jeux.
<?php else: ?>
<table class="tableaujeux">
    <tr class='titre_case'>
        <th><img id ="nomdesc" src="images/fleche_haut.png" alt="fleche_haut" class="flechehaut recherche"/>Nom<img id ="nomasc" src="images/fleche_bas.png" alt="fleche_bas" class="flechebas recherche"/></th>
        <th>Image</th>
        <th>Description</th>
        <th><img id="sortiedesc" src="images/fleche_haut.png" alt="fleche_haut" class="flechehaut recherche"/>Sortie<img id="sortieasc" src="images/fleche_bas.png" alt="fleche_bas" class="flechebas recherche"/></th>
        <th>
        <?php $lstCateg = get_categories(); ?>
            <select id="categ">
                <optgroup label ="Catégorie">
                    <option value="0" <?php if ($categ ==0): echo 'selected'; endif; ?> >Tous</option>
                    <?php foreach($lstCateg as $uneCateg):
                        $idcateg = $uneCateg['IDCategorie'];
                        $nomcateg = $uneCateg['NomCateg'];?>
                    <option value="<?php echo $idcateg; ?>" <?php if ($categ ==$idcateg): echo 'selected'; endif; ?>><?php echo $nomcateg; ?></option>
                    <?php endforeach; ?>
                </optgroup>
            </select>
        </th>
        <th>Age</th>
        <th></th>
    </tr>
<?php
    foreach($lstJeux as $unJeu): // Pour chaque jeu, associer dans les variables correspondantes pour l'affichage
        $id = $unJeu['IDJeux'];
        $nom = $unJeu['NomJeu'];
        $desc = $unJeu['Descriptif'];
        $img = "images/produits/".$unJeu['Image'];
        $sortie = dateFR($unJeu['DateDeSortie']);
        $categ = $unJeu['NomCateg'];
        $age = $unJeu['TrancheAge'];
// affichage de chaque jeu
?>
    <tr>
        <td>
            <a class="" href="detail_jeu.php?id=<?php echo $id; ?>"><span class="nomnew"><?php echo $nom;?></span></a>
        </td>
        <td><a class="nomnew" href="detail_jeu.php?id=<?php echo $id; ?>"><img class="produit" src="<?php echo $img; ?>"/></a></td>
        <td class='contenu_case description_case'><?php echo $desc; ?></td>
        <td class='contenu_case'><?php echo $sortie; ?></td>
        <td class='contenu_case'><?php echo $categ; ?></td>
        <td class='contenu_case'><?php echo $age; ?></td>
        <td class='cachepanier'>
                    Indisponible pour le moment
        </td>
    </tr>
<?php endforeach; ?>
</table>
<?php endif; ?>
<script>
    $(".recherche").on('click',function(){ //requête AJAX pour ajouter au panier en utilisant l'identifiant
        var id = $(this).attr('id');
        switch(id){
            case 'searchimg':
                var val = $(this).prev('input').val();
                var status = 1;
                break;
            case 'nomdesc':
                var val = '';
                var status = 2;
                break;
            case 'nomasc':
                var val = '';
                var status = 3;
                break;
            case 'sortiedesc':
                var val = '';
                var status = 4;
                break;
            case 'sortieasc':
                var val = '';
                var status = 5;
                break;
        }
        var categ = $('#categ').val();
        $.ajax({
                  type:'POST',
                  url:'search_avenir.php',
                  data:{
                      status : status,
                      val : val,
                      categ : categ
                  },
                  success: function(data,textStatus,jqXHR){
                        $('table').html(data);
                  },
                  error: function(jqXHR, textStatus,errorThrown){
                      alert('une erreur s\'est produite');
                  }
                });
    });
    
    $('#categ').on('change',function(){ // en cliquant sur une flèche, ou l'icone Recherche, envoie une requête AJAX aboutissant à un tri
        var categ = $('#categ').val();
        var val = '';
        var status = 6;
        $.ajax({
                  type:'POST',
                  url:'search_avenir.php',
                  data:{
                      status : status,
                      val : val,
                      categ : categ
                  },
                  success: function(data,textStatus,jqXHR){
                        $('table').html(data);
                  },
                  error: function(jqXHR, textStatus,errorThrown){
                      alert('une erreur s\'est produite');
                  }
                });
    });
</script>

