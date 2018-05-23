<ul class="pagination" style="text-align:  center; background-color : #A1BBA4;">
    <li class="disabled"><a href="#!"><i class="mdi-navigation-chevron-left"></i></a></li>
    <li class="active"><a href="#!">1) Essais </a></li>
    <li class="waves-effect"><a href="#!">2) ITK</a></li>
    <li class="waves-effect"><a href="#!">3) UEs</a></li>
    <li class="waves-effect"><a href="#!">4) Phénotypes</a></li>
    <li class="waves-effect"><a href="#!">5) Validation</a></li>
    <li class="waves-effect"><a href="#!"><i class="mdi-navigation-chevron-right"></i></a></li>
</ul><br></br>
<h5>Dans cette partie vous devrez choisir si les essais que vous avez insérés via 
    votre csv sont portés sur des plantes individuelles</h5><br></br>

<?php
$compteur=0;

$tab_id_essais = unserialize($tab_id_essais);
echo "<form action = 'index.php?' method='post'>";
for ($i=0;$i<count($tab_id_essais);$i++)
{
    $essai = ModelEssai::getById($tab_id_essais[$i]);
    
        echo "<fieldset>"
            ."<h6>Nom de l'essai : <span style='color: red;'>".$essai->getNom().'</h6>'
            ."<p><label><input type='checkbox' name=check$compteur /><span>Plantes Individuelles</span></label></p>". 
              "</fieldset>";
    $compteur++;
}
$tab_id_essais = serialize($tab_id_essais);
echo "<br></br>";
echo "<input type=hidden name=action value=created >";
echo "<input type=hidden name=controller value=essai>";
echo "<input type=hidden name=tab_ref_itk value=$tab_ref_itk>";
echo "<input type=hidden name=tab_id_essais value=$tab_id_essais>";
echo "<button type='submit' class='btn waves-effect'>Confirmer</button>";
echo "</form>";