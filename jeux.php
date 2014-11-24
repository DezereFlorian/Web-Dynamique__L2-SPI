    <?php
    include_once('entete.php');
     
    function get_jeux($date){ //récupère tous les jeux
        global $bdd;
        $req = $bdd -> prepare("SELECT * from jeux as j, categorie as c, age as a where j.IDCateg = c.IDCategorie and j.IDAge = a.IDAge and DateDeSortie <= '$date' order by DateDeSortie desc;");
        $req -> execute();
        $get_jeux = $req -> fetchAll();
        return $get_jeux;
    }
    function get_categories(){ //récupère toutes les catégories
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
    $date=date("Y-m-d"); //date d'aujourd'hui
    $lstJeux = get_jeux($date); // lance la fonction de récupération des jeux

    
    // affichage du tableau avec tous les jeux
    ?>
<p> <!-- l'input de recherche -->
    <input type="search" id="search" name="search" value="Rechercher"/><img src="images/search.png" alt="search" id="searchimg" class="recherche"/>
</p>
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
                    <option value="0" selected>Tous</option>
                    <?php foreach($lstCateg as $uneCateg):
                        $idcateg = $uneCateg['IDCategorie'];
                        $nomcateg = $uneCateg['NomCateg'];?>
                    <option value="<?php echo $idcateg; ?>"><?php echo $nomcateg; ?></option>
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
            $stock = $unJeu['Stock'];
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
                <?php if($stock > 0): ?>
                    <img class='addpanier' id="<?php echo $id ?>" src='images/panier_fleche.jpg'/>
                <?php else: ?>
                    Indisponible
                <?php endif; ?>
            </td> <!-- ajout au panier via jQuery -->
        </tr>
    <?php
        endforeach;
    ?>
</table>

<?php
    include_once('foot.php');
?>

<script>
    $(".addpanier").click(function (){ //requête AJAX pour ajouter au panier en utilisant l'identifiant
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
    
    $(".recherche").on('click',function(){ // en cliquant sur une flèche, ou l'icone Recherche, envoie une requête AJAX aboutissant à un tri
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
                  url:'search.php',
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
    
    $('#categ').on('change',function(){ // en changeant la catégorie de la liste déroulante, trie les jeux
        var categ = $('#categ').val();
        var val = '';
        var status = 6;
        $.ajax({
                  type:'POST',
                  url:'search.php',
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