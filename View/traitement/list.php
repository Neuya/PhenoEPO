<?php
require_once File::build_path(array("Model","ModelIntrant.php"));

echo "<h6>Vous trouverez ci contre l'ensemble des traitements relatifs à l'essai sélectionné</h6><br></br>";

echo "<table class='striped' style='border : 1px solid black'>"
. "<tr><th>Traitement</th><th>Date</th><th>Dose</th><th>Stade</th></tr>";


foreach ($traitements as $tab)
{
    $date = new DateTime($tab->getDate());
    $intrant = ModelIntrant::getById($tab->getCodeIntrant());
    echo "<tr>"
        ."<td>".$intrant->getType()."</td>"
        ."<td>".$date->format("d/m/Y")."</td>"
        ."<td>".$tab->getDose()." ".$intrant->getUnite()."</td>"
        ."<td><a href='index.php?action=read&controller=stade&idStade"
            . "=".$tab->getIdStade()."'>".$tab->getIdStade()."</a></td>"
        ."</tr>";
}

echo "</table>";

?>
<br></br>
<a href='javascript:history.go(-1)' class='btn' id='btn_centre'>Retour aux essais</a>