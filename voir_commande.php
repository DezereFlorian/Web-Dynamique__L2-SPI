<?php
session_start();
?>
<?php
include('connexion2.php');

function contenu_commande($id){ //récupère le contenu de la commande
    global $bdd;
    $req = $bdd -> prepare("SELECT * from jeux, commandefinale where jeux.IDJeux = commandefinale.IDJeux and IDCommande = '$id'");
    $req -> execute();
    $contenu_commande = $req -> fetchAll();
    return $contenu_commande;
}

$idcommande = $_POST["id"];
// affichage du contenu de la commande
$lstJeux = contenu_commande($idcommande);
?>
    <p class='ajax'>
<?php foreach($lstJeux as $unJeu): 
    $idjeu = $unJeu['IDJeux'];
    $nomjeu = $unJeu['NomJeu'];
    
?>
    <a href='detail_jeu.php?id=<?php echo $idjeu; ?>' class='lienbasique'><?php echo $nomjeu; ?></a>
    <br/>
<?php endforeach; ?>
    </p>