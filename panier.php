<?php
    include_once('entete.php');
    
    function dateFR($datePHP1) // transforme la date anglaise (de la base) en date française
    {
        list($AAAA, $MM, $JJ) = explode("-", $datePHP1);
        $datePHP2 = $JJ."-".$MM."-".$AAAA;

        return $datePHP2;
    }
    
    function get_panier($nb, $articles){ //récupère les jeux du panier
        global $bdd;
        switch($nb): // en fonction du nombre de jeux dans le panier, ajuste la requête pour choisir celle qui affichera tous les jeux du panier
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
    
if($connect == 0): ?>
    <p>
        T'es un petit malin toi, tu veux venir ici sans être connecté ? C'est dommage que j'ai prévu ton coup. Bisous ! ♥
    </p>
<?php else:
    $nb_articles = sizeof($_SESSION['panier']); // calcul du nombre de jeux présents dans le panier
    
?>

<h2>Votre panier</h2><br/>

<?php if($nb_articles == 0): //si il n'y a aucun jeu
?> 
    <p>Votre panier est vide.</p>
<?php else: //si il y a des jeux, récupération des jeux via la fonction
    $lstPanier = get_panier($nb_articles, $_SESSION['panier']);
?>
    <table>
<?php     
    foreach($lstPanier as $unJeu):
        $id = $unJeu['IDJeux'];
        $nom = $unJeu['NomJeu'];
        $desc = $unJeu['Descriptif'];
        $img = "images/".$unJeu['Image'];
        $sortie = dateFR($unJeu['DateDeSortie']);
        // affichage de chaque jeu du panier
?>
        
    <tr>
        <td>
            <a class="" href="detail_jeu.php?id=<?php echo $id; ?>"><span class="nomnew"><?php echo $nom;?></span></a>
        </td>
        <td><a class="" href="detail_jeu.php?id=<?php echo $id; ?>"><img src="<?php echo $img; ?>"/></a></td>
        <td class='contenu_case'><?php echo $desc; ?></td>
        <td class='contenu_case'><?php echo $sortie; ?></td>
        <td class='cachepanier'>
                <img class='retirepanier' id="<?php echo $id ?>" src='images/retirer_panier.jpg'/>
        </td> <!-- retire du panier via jQuery -->
    </tr>
<?php endforeach; ?>
    </table>    
    
    <p>
        <?php if ($nb_articles == 1): ?>
        <button id="reservation">Réservez ce jeu !</button>
        <?php endif;
        if ($nb_articles > 1): ?>
        <button id="reservation">Réservez ces jeux !</button>
        <?php endif; ?>
    </p>
    <p id="datereservation">
        Choisissez la date et l'heure à laquelle vous souhaitez venir chercher votre réservation :<br/>

        <select id="time">
            <?php for($j=9;$j<18;$j++): 
                if($j < 12 || $j > 13): ?>
            <option value="<?php echo $j; ?>"><?php echo $j;?>h - <?php echo $j+1; ?>h</option>
            <?php endif; endfor; ?>
        </select>
        <select id="moiscommande">
            <?php for($i=1;$i<4;$i++): ?>
            <option value="<?php echo $i; ?>"><?php echo $i; ?> mois</option>
            <?php endfor; ?>
        </select>
    </p>
<?php endif;
    
endif;
    include_once('foot.php');
?>

<script>
    $(".retirepanier").click(function (){ //requête AJAX pour retirer du panier le jeu d'après son identifiant.
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
    
    $('#reservation').click(function(){
        $('#time').before('<label for="date">Date :&nbsp;</label><input type="text" id="date" />');
        $('#date').datepicker({ 
            dateFormat: "yy-mm-dd"
        });
        $('#date').datepicker($.datepicker.regional[ "fr" ]);
        $('#moiscommande').after('<input type="button" onclick="validerCommande();" id="valider" value="Commander"/>');
        
        $('#datereservation').slideDown("slow");
    });
    
    function validerCommande(){
        
        var date = $('#date').val();
        var nbmois = $('#moiscommande').val();
        var heure = $('#time').val();
        $.ajax({
                  type:'POST',
                  url:'commande.php',
                  data:{
                      nbmois : nbmois,
                      date : date,
                      heure : heure
                  },
                  success: function(data,textStatus,jqXHR){
                        $(data).prependTo('table');
                  },
                  error: function(jqXHR, textStatus,errorThrown){
                      alert('une erreur s\'est produite');
                  }
                });
    }
</script>