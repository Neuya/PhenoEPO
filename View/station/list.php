<?php
require_once File::build_path(array('Model','ModelStation.php'));

?>
        <form method='post' action='index.php' class="input-field">
            <fieldset>
            <legend>Rechercher des stations</legend>
            <input type='hidden' name="action" value='recherche'>
            <input type='hidden' name="controller" value="station">
            <div class="row">
                <div class="col s6">
                    <span class="" >Par nom :</span>
            <input type="search" placeholder="Entrez un nom de Station" name="nomStation">
                </div>
            <div class="col s6">
           Par pays :
            <select name="paysStation">
                <option>Tous les pays</option>
                <?php
               $liste_pays = ModelStation::getPaysStations();
               for($i=0;$i<count($liste_pays);$i++)
               {
                   echo "<option>".$liste_pays[$i][0]."</option>";
               }
                ?>
                
            </select>   
            </div>
            </div>
            <button class="btn waves-effect waves-light" type="submit">RECHERCHER
              <i class="material-icons right">search</i>
              </button>
            </fieldset>
   
  
        </form>
<h5 style="color :red;">Avant d'insérer un champ ou un csv de type essai veuillez au préalable sélectionner la station.</h5>
<?php 

echo "<p>Afin de voir tous les champs d'une station, veuillez cliquer sur l'une d'entre elles</p>";
echo "<div class='collection'>";

foreach ($tab_station as $tab)
{
    echo "<a class='collection-item' href='index.php?action=readAllChampByStation&controller=champ&idStation=".$tab->getId()."'>";
    echo "<h5>Nom : ".$tab->getNom()."</h5>";
    echo "<h6>Ville : ".$tab->getVille()."</h6>";
    echo "Longitude : ".$tab->getLongitude();
    echo " Latitude : ".$tab->getLatitude()."";
    echo "<p class='black-text text-lighten-4 right'>";
    if($tab->aChampInconnu() || !$tab->aChamp())
    {
        echo "Aucun champ dans la base";
    }
    else
    {
        echo $tab->countChampsStation()." champ(s) dans la base";
    }
    echo "</p><br></br>";
    echo "</a>";
}

echo "</div>";

?>

<blockquote>
<p>La station que vous cherchez ne figure pas dans la base?</p>
<a href="index.php?action=create&controller=station" class="btn waves-effect waves-light">
    Insérer une nouvelle station dans la base</a> 
</blockquote>