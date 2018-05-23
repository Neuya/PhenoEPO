<?php

require_once File::build_path(array("Model","ModelIntrant.php"));
require_once File::build_path(array("Model","ModelTraitement.php"));

echo "<h5>Cliquez sur l'une des années suivantes pour ouvrir l'ensemble"
. " des ITK effectués qui y ont été effectués</h5><br></br>";

echo "<ul class='collapsible popout' data-collapsible='accordion'>";

for ($i=0;$i<count($tab_annees);$i++)
{
        
    $tab_ref_ITK = ModelTraitement::getRefByYear($tab_annees[$i][0]);
    echo "<li>";
    echo "<div class='collapsible-header'>".$tab_annees[$i][0]."<i class='material-icons right'>arrow_drop_down</i></div>";
    echo "<div class='collapsible-body'>";
    echo "<p style='color : white'>Cliquez sur une référence pour voir les traitements correspondants</p>";
    echo "<ul class='collapsible'>";
    for ($j = 0 ; $j < count($tab_ref_ITK) ; $j++)
    {
        $itk = ModelTraitement::getITKByRef($tab_ref_ITK[$j][0]);
        $traitements = ModelTraitement::getAllByRef($tab_ref_ITK[$j][0]);
        echo "<li>";
        echo "<div class='collapsible-header'>".$tab_ref_ITK[$j][0]."<i class='material-icons right'>arrow_drop_down</i></div>";
        echo "<div class='collapsible-body'>";
        $date = new DateTime($itk[0][1]);
        echo "<blockquote>";
        echo "<h5 style='color : red'>Date de semis : ".$date->format("d/m/Y")."</h5>";
        echo "<h6 style='color : green' >Densité linéaire : ". $itk[0][2] ." plantes / m<sup>2</sup>"; 
        echo "<h6 style='color : green'>Espace inter-lignes : ".$itk[0][3]." cm</span></h6>";
        echo "</blockquote>";
        echo "<p style='color : white' >Tableau des traitements : </p>";
        echo "<table class='striped' style='border 1px solid black'>"
        . "<tr><th>Traitement</th><th>Date</th><th>Dose</th><th>Stade</th></tr>";

            foreach ($traitements as $tab)
            {
                $date = new DateTime($tab->getDate());
                $intrant = ModelIntrant::getById($tab->getCodeIntrant());
                echo "<tr>"
                ."<td>".$intrant->getType()."</td>"
                ."<td>".$date->format("d/m/Y")."</td>"
                ."<td>".$tab->getDose()." ".$intrant->getUnite()."</td>"
                ."<td><a target='_blank' href='index.php?action=read&controller=stade&idStade"
                . "=".$tab->getIdStade()."'>".$tab->getIdStade()."</a></td>"
                ."</tr>";
            }

        echo "</table>"
        . "</div>";
        echo "</li>";
        
    }
    echo "</ul>";
    echo "</div></li>";
    
}

echo "</ul>";
