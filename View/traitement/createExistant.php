<ul class="pagination" style="text-align:  center; background-color : #A1BBA4;">
    <li class="disabled"><a href="#!"><i class="mdi-navigation-chevron-left"></i></a></li>
    <li class="active green "><a href="#!">1) Essais insérés</a></li>
    <li class="active"><a href="#!">2) ITK</a></li>
    <li class="waves-effect"><a href="#!">3) UEs</a></li>
    <li class="waves-effect"><a href="#!">4) Phénotypes</a></li>
    <li class="waves-effect"><a href="#!">5) Validation</a></li>
    <li class="waves-effect"><a href="#!"><i class="mdi-navigation-chevron-right"></i></a></li>
  </ul>

<?php


$compteur = 0;

echo "<h4>Vous trouverez ci contre l'ensemble des essais et la référence"
. " ITK correspondante que vous avez insérés</h4>";
echo "<h5 style='color :red'>Vous pouvez modifier la référence que vous avez inséré, s'il s'agit"
. " d'un nouvel ITK veuillez cocher la case correspondante</h5>";
echo "<h6>Vous pourrez trouver l'ensemble des itinéraires existants en bas de page</h6>";
echo "<form method='post' action='index.php'>";
for ($i=0;$i<count($tab_id_essais);$i++)
{
    $essai = ModelEssai::getById($tab_id_essais[$i]);
    
    if (ModelTraitement::aTraitement($essai->getRefITK()))
    {
        echo "<fieldset>
              <h5>Référence d'itinéraire technique de l'essai : <span style='color : red;'>". $essai->getNom()."</span></h5>".
              "<input type='text' name='ref$compteur' value='".$essai->getRefITK()."'>".
              "<p><label><input type='checkbox' name=check$compteur /><span>Nouvel ITK</span></label></p>". 
              "</fieldset>";
    }
    else
    {
        echo "<h6>Cette référence n'existe pas, vous pouvez néanmoins modifier "
        . "la valeur que vous avez insérée dans le csv afin d'ajouter un itinéraire"
                . " existant à cet essai ou la conserver pour y insérer un nouveau en maintenant coché 'nouvel ITK'.</h6>";
        echo "<fieldset>"
              ."<h5>Référence d'itinéraire technique de l'essai : <span style='color : red;'>". $essai->getNom()."</span></h5>".
              "<input type='text' name='ref$compteur' value='".$essai->getRefITK()."'>".
              "<p><label><input type='checkbox' value='check$compteur' checked='checked' name=check$compteur /><span>Nouvel ITK</span></label></p>". 
              "</fieldset>";
    }
    $compteur++;
}
$tab_id_essais = serialize($tab_id_essais);
echo "<br></br>";
echo "<button class='btn' type='submit'>Valider</button>";
echo "<input type='hidden' name=action value=createdExistant>";
echo "<input type='hidden' name=controller value=traitement>";
echo "<input type='hidden' name='compteur' value='$compteur'>";
echo "<input type='hidden' name='tab_id_essais' value='$tab_id_essais'>";
echo "<input type='hidden' name='tab_ref_itk' value='$tab_ref_itk'>";
echo "</form><br></br>";

require_once File::build_path(array("View","traitement","listITK.php"));