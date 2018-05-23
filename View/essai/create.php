<ul class="pagination" style="text-align:  center; background-color : #A1BBA4;">
    <li class="disabled"><a href="#!"><i class="mdi-navigation-chevron-left"></i></a></li>
    <li class="active"><a href="#!">1) Essais </a></li>
    <li class="waves-effect"><a href="#!">2) ITK</a></li>
    <li class="waves-effect"><a href="#!">3) UEs</a></li>
    <li class="waves-effect"><a href="#!">4) Phénotypes</a></li>
    <li class="waves-effect"><a href="#!">5) Validation</a></li>
    <li class="waves-effect"><a href="#!"><i class="mdi-navigation-chevron-right"></i></a></li>
  </ul>
<?php 
    
    require_once File::build_path(array("Model","ModelEssai.php"));
    require_once File::build_path(array("Model","ModelChamp.php"));
    $champEssai = $champ;
    $idChamp=$champEssai->getId();
    $station = ModelChamp::getStationById($champEssai->getIdStation());
    
    if(!$station->aChampInconnu())
    {
    echo "Vous vous apprêtez a insérer un CSV essai dans le champ nommé : ".$champEssai->getNom();
    echo "<br></br>Ce champ est situé dans la station : ".$station->getNom()." "
            . "en ".$station->getPays()." à ".$station->getVille().".<br></br>";
    }
    else
    {
        echo "Vous vous apprêtez a insérer un essai directement dans la station nommée : <strong>".$station->getNom().""
                . " "
                . "</strong>en<strong> ".$station->getPays()."</strong> à <strong>".$station->getVille()."."
                . "</strong><br></br>";
    }
?>

<strong><h6>Veillez à avoir bien enregistré votre csv en encodage UTF8 ou Unicode 8 pour éviter tout conflit</h6></strong>
<ul class='collapsible popout' data-collapsible='accordion'>
    <li>
        <div class='collapsible-header'>Template du CSV a respecter<i class='material-icons right'>arrow_drop_down</i></div>
        <div class='collapsible-body'>
            <table style='font-size:12px;'>
                <tr>
                    <th>Nom</th>
                    <th>NbPlanches</th>
                    <th>NbPassages</th>
                    <th>LongueurPlanche</th>
                    <th>LargeurPlanche</th>
                    <th>NbLignes</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th>RéférenceITK</th>
                </tr>
            </table>
        </div>
    </li>
</ul>
<form enctype="multipart/form-data" method="post" action="index.php" id="formessai" onsubmit='return verif_input()'>
    <input type='hidden' name='action' value='createdPlante'>
    <input type='hidden' name='controller' value='essai'>
    <?php echo "<input type='hidden' name='idChamp' value='$idChamp'>"; ?>    
    <fieldset>
        <legend>Inserez ici votre fichier CSV de type essai</legend>
        <br></br>
        <div class="file-field input-field">
            <div class="btn">
                <span>Parcourir</span>
                <input  type="file" name="csvessai" >
            </div>
            <div class="file-path-wrapper">
                <input class="file-path validate" type="text">
            </div>
            
        </div>
    </fieldset>
    <br></br>
    <input class="btn" type="submit" value="Inserer l'essai"></input>
   
</form><br></br>    