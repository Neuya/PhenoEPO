
<?php

require_once File::build_path(array('Model','ModelChamp.php'));


echo "Champs de la Station :<strong> ".$station->getNom().""
        . "</strong> située en <strong>".$station->getPays().""
        . "</strong> à <strong>".$station->getVille()."</strong>";


if($station->aChamp())
{
    echo "<p>Vous pouvez ajouter un champ via un bouton <a href=#> bas de cette page</a></p>";
    echo "<h5 class='red-text lighten' >Avant d'insérer un csv essai dans la base veuillez sélectionner le champ où il(s) se situe(nt).</h5><br></br>";
foreach($tab_champ as $tab)
{
    echo "<div class='collection'>";
    echo "<a class='collection-item' href='index.php?action=readAllByChamp&controller=essai&idChamp=".$tab->getId()."'>";
    echo "<h5>Nom : ".$tab->getNom()."</h5><h6>Latitude : ".$tab->getLatitude()." Longitude : ".$tab->getLongitude()."</h6>"
            . "<br>Altitude : ".$tab->getAltitude()."m";
    echo "<p class='black-text text-lighten-4 right'>"
    .$tab->countNbEssaisChamp()." essai(s) effectué(s) dans ce champ</p><br></br>";
    echo "</a>";
    echo "</div>";
    echo "<a class='btn' href='index.php?action=create&controller=essai&idChamp=".$tab->getId()."'>AJOUTER UN ESSAI DANS CE"
            . " CHAMP</a>";
    echo " ";
    echo "<a class='btn' href='index.php?action=update&controller=champ"
    . "&idStation=".$station->getId()."&idChamp=".$tab->getId()."'>Modifier "
            . "les données de ce CHAMP</a>";
   
}
}
else
{
    echo "<p>Cette station n'a aucun champ enregistré dans la base.</p>";
    
    if($station->aChampInconnu())
    {
        $idChamp = $tab_champ[0]->getId();
        echo "<p>Néanmoins, des essais on déjà étés insérés directement dans la station</p>";
        echo "<a class='btn' href='index.php?action=readAllByChamp&controller=essai&idChamp=$idChamp'>Consulter les essais insérés dans cette station</a>";
          echo " <a class='btn'  href='index.php?action=create&controller=essai&idChamp=$idChamp'>"
                  . "AJOUTER UN ESSAI DANS CETTE"
            . " STATION</a>";
    }
    else
    {
        echo "<p>Aucun essai n'a été inséré dans cette station également</p>";
        echo "<a style='width : 50%; margin-left : 25%;' class='btn' href='index.php?action=create&controller=champ&idStation=".$station->getId()
        . "&inconnu=1'>AJOUTER DES ESSAIS DANS CETTE"
            . " STATION</a>";
        echo "<strong><p style='color : red;'>NB : Il est préférable d'insérer d'abord un champ dans la station avant d'y insérer un essai,"
        . "si cela vous est impossible cliquez sur le bouton ci-dessus.</p></strong>";
    }
    
}

echo "<blockquote>";
echo "<p>Vous pouvez ajouter un champ à cette station :</p>";
    echo "<a class='btn waves-effect waves-ripple' href='index.php?action=create&controller=champ&idStation=".$station->getId()."&inconnu=0'>"
            ."INSERER UN CHAMP DANS CETTE STATION</a>";
    echo "</blockquote>";