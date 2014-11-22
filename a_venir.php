<?php
    include_once('entete.php');
    
    function get_jeux($date){ //récupère tous les jeux
        global $bdd;
        $req = $bdd -> prepare("SELECT * from jeux as j, categorie as c, age as a where DateDeSortie > '$date' and j.IDCateg = c.IDCategorie and j.IDAge = a.IDAge order by DateDeSortie;");
        $req -> execute();
        $get_jeux = $req -> fetchAll();
        return $get_jeux;
    }
    function dateFR($datePHP1) // transforme la date anglaise (de la base) en date française
    {
        list($AAAA, $MM, $JJ) = explode("-", $datePHP1);
        $datePHP2 = $JJ."-".$MM."-".$AAAA;

        return $datePHP2;
    }
    $date=date("Y-m-d"); //date d'aujourd'hui
    $lstJeux = get_jeux($date); // lance la fonction de récupération des jeux

    
    // affichage du tableau avec tous les jeux
    ?>
<table>
    <tr class='titre_case'>
        <th>Nom</th>
        <th>Image</th>
        <th>Description</th>
        <th>Date de sortie</th>
        <th>Catégorie</th>
        <th>Age</th>
        <th></th>
    </tr>
    <?php
        foreach($lstJeux as $unJeu): // Pour chaque jeu, associer dans les variables correspondantes pour l'affichage
            $id = $unJeu['IDJeux'];
            $nom = $unJeu['NomJeu'];
            $desc = $unJeu['Descriptif'];
            $img = "images/".$unJeu['Image'];
            $sortie = dateFR($unJeu['DateDeSortie']);
            $categ = $unJeu['NomCateg'];
            $age = $unJeu['TrancheAge'];
// affichage de chaque jeu
    ?>
        <tr>
            <td>
                 <a class="" href="detail_jeu.php?id=<?php echo $id; ?>"><span class="nomnew"><?php echo $nom;?></span></a>
            </td> <!-- mets le span en caché avec visibility : hidden -->
            <td>
                <a class="" href="detail_jeu.php?id=<?php echo $id; ?>"><img src="<?php echo $img; ?>"/></a>
            </td>
            <td class='contenu_case'><?php echo $desc; ?></td>
            <td class='contenu_case'><?php echo $sortie; ?></td>
            <td class='contenu_case'><?php echo $categ; ?></td>
            <td class='contenu_case'><?php echo $age; ?></td>
            <td class='cachepanier'>
                    Indisponible pour le moment
            </td>
        </tr>
    <?php
        endforeach;
    ?>
</table>

<?php 
    include_once('foot.php');
?>

<script>
    $(".addpanier").click(function (){ //requête AJAX pour ajouter au panier un jeu d'après son identifiant
        var id = $(this).attr('id');
        $.ajax({
                  type:'POST',
                  url:'gestpanier.php',
                  data:{
                      status : 1,
                      id : id
                  },
                  success: function(data,textStatus,jqXHR){
                        $(data).prependTo('table');
                  },
                  error: function(jqXHR, textStatus,errorThrown){
                      alert('une erreur s\'est produite');
                  }
                });
    });
</script>