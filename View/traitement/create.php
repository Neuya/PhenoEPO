<ul class="pagination" style="text-align:  center; background-color : #A1BBA4;">
    <li ><a href="#!"><i class="mdi-navigation-chevron-left"></i></a></li>
    <li class="active green"><a href="#!">1) Essais insérés</a></li>
    <li class="active"><a href="#!">2) ITK</a></li>
    <li class="waves-effect"><a href="#!">3) UEs</a></li>
    <li class="waves-effect"><a href="#!">4) Phénotypes</a></li>
    <li class="waves-effect"><a href="#!">5) Validation</a></li>
    <li class="waves-effect"><a href="#!"><i class="mdi-navigation-chevron-right"></i></a></li>
  </ul>

<?php 
if ($pagetitle != "Insertion de traitements")
{
    echo "<h6>Vos données ont correctement été insérées, veuillez poursuivre l'insertion des traitements</h6>";
}


?>

<strong><h5>Attention vérifiez bien que les types d'intrants et les codes des stades que vous 
        allez insérer existent bien dans la base de données. Le cas échéant vous serez contraints 
        d'insérer un CSV ou de remplir un formulaire afin de rajouter les données manquantes.</h5></strong>
<ul class='collapsible popout' data-collapsible='accordion'>
    <li>
        <div class='collapsible-header'>Liste des Intrants<i class='material-icons right'>arrow_drop_down</i></div>
        <div class='collapsible-body'>
            <?php require_once File::build_path(array("View","intrant","list.php")); ?>
        </div>
    </li>
</ul>
<a class='btn waves-effect' id='btn_centre' href="index.php?action=readAll&controller=Stade" target="_blank">
    Liste des Stades<i class="material-icons right">call_made</i></a>
<strong><h6>Veillez également à avoir bien enregistré votre csv en encodage UTF8 ou Unicode 8
        tout en ayant décoché l'option "Enregistrer les cellules comme affichées" pour éviter tout conflit</h6></strong>
<ul class='collapsible popout' data-collapsible='accordion'>
    <li>
        <div class='collapsible-header'>Template du CSV a respecter<i class='material-icons right'>arrow_drop_down</i></div>
        <div class='collapsible-body'>
            <table>
                <tr>
                    <th>Date</th>
                    <th>Dose</th>
                    <th>Code Stade</th>
                    <th>Type Intrant</th>
                </tr>
            </table>
        </div>
    </li>
</ul>


<?php 
require_once File::build_path(array("Model","ModelSemis.php"));
require_once File::build_path(array("Model","ModelTraitement.php"));

$listeNoms = ModelSemis::getAllNom();
$options = "";
for ($i=0;$i<count($listeNoms);$i++)
{
    $options = $options."<option>".$listeNoms[$i][0]."</option>";
}
echo "<p>Vous trouverez ci contre une demande de fichiers pour l'ensemble des reférences ITK insérées dans l'essai n'existant pas dans la base</p>";
echo "<form enctype='multipart/form-data' method='post' action='index.php' onsubmit='return verif_input();'>";
echo  "<input type='hidden' name='action' value='created'>"
    ."<input type='hidden' name='controller' value='traitement'>";

//  $tab_ref_itk = unserialize($tab_ref_itk);
    
$tab_itk_send = [];

$compteur = 0;

for ($i=0;$i<count($tab_ref_itk);$i++)
{
    
    if (!ModelTraitement::aTraitement($tab_ref_itk[$i]))
    {
        $tab_itk_send[] = $tab_ref_itk[$i];
            echo "<fieldset>"
             ."<legend>Inserez ici votre fichier CSV portant sur le traitement</legend>"
             ."<strong style='color : red;' >Référence ITK : ".$tab_ref_itk[$i]."</strong><br></br>"
             ."Date Semis : <input class='validate' type='date' name='dateSemis$compteur'></input><br></br>"
             ."<div class='row'>"
            . "<div class='col s6'>"
             ."Densité linéaire : <input class='validate' type=number name='densite$compteur'></input></div>"
             ."<div class='col s6'>"
             ."Espace Inter-Lignes : <input class='validate' type=number name='espace$compteur'></input></div><br></br></div>"
             ."<div class='file-field input-field'>"
                ."<div class='btn'>"
                    ."<span>Parcourir</span>"
                    ."<input class='fichiers' type='file' name='csvITK$compteur' >"
                ."</div>"
                ."<div class='file-path-wrapper'>"
                    ."<input class='file-path validate' type='text'>"
                ."</div>"
             ."</div>"
        ."</fieldset>"
        ."<br></br>";
        $compteur++;
    }
  /*  else
    {
        echo "<h6>La référence ITK $tab_ref_itk[$i] existe déjà dans la base de données,"
                . "des traitements y ont étés insérés ultérieurement</h6>";
    }*/
}
$tab_itk_send = serialize($tab_itk_send);
$tab_id_send = serialize($tab_id_essais);

echo "<input type='hidden' name='tab_id_essais' value=$tab_id_send></input>";
echo "<input type='hidden' name='tab_itk' value=$tab_itk_send></input>";
echo "<input class='btn' type='submit' value='Envoyer'></input>";
echo "</form>";

?>
 
