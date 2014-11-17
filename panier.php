<?php
    include_once('entete.php');
    
    function dateFR($datePHP1) // transforme la date anglaise (de la base) en date française
    {
        list($AAAA, $MM, $JJ) = explode("-", $datePHP1);
        $datePHP2 = $JJ."-".$MM."-".$AAAA;

        return $datePHP2;
    }
    
    function get_panier($nb, $articles){
        global $bdd;
        switch($nb):
            case 1:
                $req = $bdd -> prepare("Select * from jeux where IDJeux='$articles[0]'");
                break;
            case 2:
                $req = $bdd -> prepare("Select * from jeux where IDJeux='$articles[0]' or IDJeux='$articles[1]'");
                break;
            case 3:
                $req = $bdd -> prepare("Select * from jeux where IDJeux='$articles[0]' or IDJeux='$articles[1]' or IDJeux='$articles[2]'");
                break;
        endswitch;
        $req -> execute();
        $get_panier = $req -> fetchAll();
        return $get_panier;
    }
    
    $nb_articles = sizeof($_SESSION['panier']);
    
if($nb_articles == 0): ?>
    <p>Votre panier est vide.</p>
<?php else:
    $lstPanier = get_panier($nb_articles, $_SESSION['panier']);
?>
    <table>
<?php     
    foreach($lstPanier as $unJeu):
        $id = $unJeu['IDJeux'];
        $nom = $unJeu['NomJeu'];
        $desc = $unJeu['Descriptif'];
        $prix = $unJeu['Prix'];
        $img = "images/".$unJeu['Image'];
        $sortie = dateFR($unJeu['DateDeSortie']);
        // affichage de chaque jeu du panier
?>
    <tr>
        <td><span class="cache"><?php echo $id; ?></span><a class="liendetail" href="detail_jeu.php?id=<?php echo $id; ?>"><?php echo $nom; ?></a></td> <!-- mets le span en caché avec visibility : hidden -->
        <td><a class="" href="detail_jeu.php?id=<?php echo $id; ?>"><img src="<?php echo $img; ?>"/></a></td>
        <td class='contenu_case'><?php echo $desc; ?></td>
        <td class='contenu_case'><?php echo $sortie; ?></td>
        <td class='contenu_case'><?php echo $prix; ?></td>
        <td class='cachepanier'>
                <img class='retirepanier' id="<?php echo $id ?>" src='images/retirer_panier.jpg'/>
        </td> <!-- enlève du panier via jQuery -->
    </tr>
<?php endforeach; ?>
    </table>    
<?php endif;
    include_once('foot.php');
?>

<script>
    $(".retirepanier").click(function (){
        var id = $(this).attr('id');
        $.ajax({
                  type:'POST',
                  url:'gestpanier.php',
                  data:{
                      status : 2,
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