<?php
session_start();
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8;">
<?php
include('connexion.php');

$idjeu = $_POST["id"];
if ($_POST['status']==1):
    if (sizeof($_SESSION['panier'])<=3):
        $_SESSION['panier'][] = $idjeu;
    else:
        echo "<script>if(confirm('Votre panier est plein, vous ne pouvez pas ajouter plus de 3 jeux à votre commande.\nAppuyez sur Ok pour \u00eatre redirig\u00e9 vers votre panier, Annuler pour rester sur cette page.')){var adresse = 'panier.php'; window.location = adresse;};</script>";
    endif;
else:
    $idjeuretire = array_search($idjeu, $_SESSION['panier']);
    unset($_SESSION['panier'][$idjeuretire]);
endif;
?>
