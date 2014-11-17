<?php
session_start();
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8;">
<?php
include('connexion.php');

$idjeu = $_POST["id"];


if (isset($_SESSION['id'])): 
    if ($_POST['status']==1):
        if (sizeof($_SESSION['panier'])<3):
            if(array_search($idjeu, $_SESSION['panier'])==false):
                $_SESSION['panier'][] = $idjeu;
            endif;     
        else:
            echo "<script>if(confirm('Votre panier est plein, vous ne pouvez pas ajouter plus de 3 jeux à votre commande.\nAppuyez sur Ok pour \u00eatre redirig\u00e9 vers votre panier, Annuler pour rester sur cette page.')){var adresse = 'panier.php'; window.location = adresse;};</script>";
        endif;
    else:
        $idjeuretire = array_search($idjeu, $_SESSION['panier']);
        unset($_SESSION['panier'][$idjeuretire]);
        $_SESSION['panier'] = array_values($_SESSION['panier']);
    endif;
else:
    ?>
<script>
    function ok(){
        if(confirm('Vous n\'\u00eates pas connect\u00e9.\nAppuyez sur Ok pour \u00eatre redirig\u00e9 vers la page de connexion, Annuler pour rester sur cette page.'))
        {
            var adresse = 'seconnecter.php';
            window.location = adresse;
        } 
    }
    ok();
</script>";

<?php endif;

?>
