<form method="post" action ="index.php?" enctype='multipart/form-data' onsubmit="return verif_csv()">
    <input type="hidden" name="action" value="created">
    <input type="hidden" name="controller" value="ue">
    
<ul class="pagination" style="text-align:  center; background-color : #A1BBA4;">
    <li class="disabled"><a href="#!"><i class="mdi-navigation-chevron-left"></i></a></li>
    <li class="active green"><a href="#!">1) Essais</a></li>
    <li class="active green"><a href="#!">2) ITK</a></li>
    <li class="active"><a href="#!">3) UEs</a></li>
    <li class="waves-effect"><a href="#!">4) Phénotypes</a></li>
    <li class="waves-effect"><a href="#!">5) Validation</a></li>
    <li class="waves-effect"><a href="#!"><i class="mdi-navigation-chevron-right"></i></a></li>
  </ul>
    <h5>Avant l'insertion des CSV vérifiez que les références des génotypes existent
        bien dans la base : </h5>
    <a href='index.php?action=readAll&controller=genotype' class='btn waves-effect' 
       id='btn_centre' target='_blank'>Consulter la liste des génotypes
        <i class="material-icons right">call_made</i></a>
<ul class='collapsible popout' data-collapsible='accordion'>
    <li>
        <div class='collapsible-header'>Template du CSV a respecter<i class='material-icons right'>arrow_drop_down</i></div>
        <div class='collapsible-body'>
            <h5 style='color:white'>CSV UE pour essai normal :</h5>
            <table>
                <tr>
                    <th>Référence Génotype</th>
                    <th>Num Passage</th>
                    <th>Num Planche</th>
                </tr>
            </table>
            <h5 style='color:white'>CSV UE pour essai de type plantes individuelles :</h5> 
             <table>
                  <tr>
                    <th>Référence Génotype</th>
                    <th>Num Passage</th>
                    <th>Num Planche</th>
                    <th>Num Ligne</th>
                    <th>Num Plante</th>
                </tr>
            </table>   
        </div>
    </li>
</ul>
<?php
require_once File::build_path(array("Model","ModelEssai.php"));


$tab_id_essais = unserialize(myGet("tab_id_essais"));
$compteur = 0;

for ($i=0;$i<count($tab_id_essais);$i++)
{
        
        
        $essai = ModelEssai::getById($tab_id_essais[$i]); 
        if(!$essai->aUE())
        {
        echo "<fieldset>
        <legend>Inserez ici votre fichier CSV portant sur les UE de l'essai : " . $essai->getNom(). "</legend>
       <h6 style='color : red;'>Nom de l'essai : ".$essai->getNom()."</h6>
        Longitude : ".$essai->getLongitude()."<br></br>
        Latitude : ".$essai->getLatitude()."<br></br>
        
        <div class='file-field input-field'>
            <input type='file' class='fichiers' name='csvUE$compteur'></input>
            <div class='btn'><span>Parcourir</span></div>
            <div class='file-path-wrapper'>
                <input class='file-path validate' type='text'>
            </div>
        </div>
        <input type='hidden' name='idEssai$compteur' value='".$essai->getId()."'>
         </fieldset><br></br>";
        $compteur++;
        }

}
$tab_id_essais = serialize($tab_id_essais);
?>
    
    <br></br>
    <input type='hidden' name='compteur' value='<?php echo $compteur ?>'>
    <input type='hidden' name='tab_ref_itk' value='<?php echo $tab_ref_itk ?>'>
    <input type='hidden' name='savedTraitement' value='<?php echo $savedTraitement?>'>
    <input type="hidden" name="tab_id_essais" value='<?php echo $tab_id_essais?>'>

    <button type='submit' class='btn'>Envoyer</button>
</form>
