<?php 
    include_once('entete.php');
?>
<div class="formulaire">
    <div id="connection">
        <form id="formconnect">
        <fieldset>
            <legend> Connexion </legend>
            <label for="utilisateur">Pseudo :&nbsp;</label><input type="text" name="pseudo" id="pseudoCo" required /><br /><br />
            <label for="motdepasse">Mot de passe :&nbsp;</label><input type="password" name="mdp" id="mdpCo" required/><br /><br />
            <input type="button" onclick="connexion();" value="Connexion" id="connect"/>
        </fieldset>
        </form>
    </div>
    <div id="inscription">
        <form id="forminscription">
        <fieldset>
            <legend> Inscription </legend>
            <label for="mail">E-mail :*&nbsp;</label><input type="text" name="mail" id="mail" required/><br/><br/>
            <label for="utilisateur">Pseudo :*&nbsp;</label><input type="text" name="pseudo" id="pseudo" required /><br /><br />
            <label for="motdepasse">Mot de passe :*&nbsp;</label><input type="password" name="mdp" id="mdp" required/><br /><br />
            <label for="nom">Nom :*&nbsp;</label><input type="text" name="nom" id="nom" required/><br /><br />
            <label for="prenom">Prénom :*&nbsp;</label><input type="text" name="prenom" id="prenom" required/><br /><br />
            <label for="adresse">Adresse :*&nbsp;</label><input type="text" name="adresse" id="adresse" required/><br /><br />
            <input type="button" onclick="verif();" value="Inscription" id="newmember"/>
        </fieldset>
        </form>
    </div>
</div>
<?php
    include_once('foot.php');
?>
<script>
    function verif(){ //regexp de vérification d'e-mail
        var mail = $('input[name=mail]').val();
        var exp = new RegExp("^[a-z0-9]{2,}([_|\.|-]{1}[a-z0-9]+)*@[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*[\.]{1}[a-z]{2,6}$","gi");
        if(exp.test(mail)){ //test de la regexp
            inscription();
            return true;
        }
        else{
            alert('Adresse mail non valide !');
            return false;
        }
    }
    function connexion(){ //récupération des champs nécessaires à la connexion et envoi d'une requête AJAX
        var pseudo = $('#pseudoCo').val();
        var mdp = $('#mdpCo').val();
        $.ajax({
              type:'POST',
              url:'verifConnexion.php',
              data:{
                  status : 1,
                  pseudo : pseudo,
                  mdp : mdp
              },
              success: function(data,textStatus,jqXHR){
                    $(data).prependTo('#connection');
              },
              error: function(jqXHR, textStatus,errorThrown){
                  alert('une erreur s\'est produite');
              }
            });
        }
    function inscription(){ // récupération des champs nécessaires à l'inscription et envoi d'une requête AJAX
        var mail = $('#mail').val();
        var pseudo = $('#pseudo').val();
        var mdp = $('#mdp').val();
        var nom = $('#nom').val();
        var prenom = $('#prenom').val();
        var adresse = $('#adresse').val();
        $.ajax({
              type:'POST',
              url:'verifConnexion.php',
              data:{
                  status : 2,
                  mail : mail,
                  pseudo : pseudo,
                  mdp : mdp,
                  nom : nom,
                  prenom : prenom,
                  adresse : adresse
              },
              success: function(data,textStatus,jqXHR){
                    $(data).prependTo('#inscription');
              },
              error: function(jqXHR, textStatus,errorThrown){
                  alert('une erreur s\'est produite');
              }
            });
        }
</script>