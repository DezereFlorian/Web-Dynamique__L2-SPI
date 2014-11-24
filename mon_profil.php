<?php
    include_once('entete.php');
    
    function dateFR($datePHP1) // transforme la date anglaise (de la base) en date française
    {
        list($AAAA, $MM, $JJ) = explode("-", $datePHP1);
        $datePHP2 = $JJ."-".$MM."-".$AAAA;

        return $datePHP2;
    }
    function get_nbcommande($id){ // récupère le nombre de commandes effectuées par le client
        global $bdd;
        $req = $bdd -> prepare("SELECT Count(*) from commande where IDClient = '$id'");
        $req -> execute();
        $get_nbcommande = $req -> fetchColumn();
        return $get_nbcommande;
    }
    function get_commande($id){ // récupère toutes les commandes du client
        global $bdd;
        $req = $bdd -> prepare("select * from commande where IDClient = '$id'");
        $req -> execute();
        $get_commmande = $req -> fetchAll();
        return $get_commmande;
    }
    function nb_jeux_commande($idcommande){ // récupère le nombre de jeux d'une commande
        global $bdd;
        $req = $bdd -> prepare("select count(*) from commandefinale where IDCommande = '$idcommande'");
        $req -> execute();
        $nb_jeux_commande = $req -> fetchColumn();
        return $nb_jeux_commande;
    }

if($connect == 0): // si pas connecté mais quand même curieux d'aller sur la page ?>
    <p>
        T'es un petit malin toi, tu veux venir ici sans être connecté ? C'est dommage que j'ai prévu ton coup. Bisous ! ♥
    </p>
<?php else:
    $idclient = $_SESSION['id'];
    $nb_commande = get_nbcommande($idclient);
?>
    <p>Vous avez effectué <?php echo $nb_commande; ?> commandes dans notre ludothèque.</p>
    <hr/>
<?php 
    $lstCommande = get_commande($idclient);
?>
    <table>
<?php // affichage des commandes
    foreach($lstCommande as $uneCommande):
        $nb_jeux_commande = nb_jeux_commande($uneCommande['IDCommande']);
        $datecommande = dateFR($uneCommande['DateCommande']);
        $dateretour = dateFR($uneCommande['DateRetour']);
        $horaire = $uneCommande['HoraireCommande'];
        $idCommande = $uneCommande['IDCommande'];
?>
        <tr id='<?php echo $idCommande; ?>' class='commande'>
            <td class='profiltable'>À venir chercher le <?php echo $datecommande; ?> entre <?php echo $horaire; ?>h et <?php echo $horaire+1; ?>h.</td>
            <td class='profiltable'>À rendre le <?php echo $dateretour; ?>.</td>
            <td class='profiltable'><?php echo $nb_jeux_commande; ?> jeu(x) réservé(s).</td>
        </tr>
        <tr><td colspan='3' id='jeu<?php echo $idCommande; ?>' class='hidden'></td></tr>
        
<?php endforeach; ?>
    </table>
<?php endif;

    include_once('foot.php'); 
?>

<script>
    $('tr').click(function(){ // affiche le contenu de la commande au clic sur la ligne de la commande en question
        var id = $(this).attr('id');
        $.ajax({
                  type:'POST',
                  url:'voir_commande.php',
                  data:{
                      id: id
                  },
                  success: function(data,textStatus,jqXHR){
                        $('.ajax').remove();
                        $(data).appendTo('#jeu'+id);
                  },
                  error: function(jqXHR, textStatus,errorThrown){
                      alert('une erreur s\'est produite');
                  }
                });
    });
</script>