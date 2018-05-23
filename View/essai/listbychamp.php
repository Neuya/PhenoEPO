<?php

echo "<div class='collection'>";

foreach($tab_essai as $tab)
{
    $surfaceUE = $tab->getLargeurPassage()*$tab->getLongueurPlanche();
    echo "<div class='collection-item'>";
    echo "<br>";
    echo "<span style='color : red;'>Nom : ".$tab->getNom();
    echo "</span></br>";
    echo "<br>";
    echo "Nombre de planches : ".$tab->getNbPlanches();
    echo "</br>";
    echo "<br>";
    echo "Longueur d'une planche : ".$tab->getLongueurPlanche();
    echo "</br>";
    echo "<br>";
    echo "Nombre de passages : ".$tab->getNbPassages();
    echo "</br>";
    echo "<br>";
    echo "Surface d'une Unité Expérimentale : ".$surfaceUE." m²";
    echo "</br>";
    echo "<br>";
    echo "Latitude Essai : ".$tab->getLatitude();
    echo "</br>";
    echo "<br>";
    echo "Longitude Essai : ".$tab->getLongitude();
    echo "</br>";
    echo "<br>";
    echo "</div>";
    echo "<a href='index.php?action=readAll&controller=traitement&idEssai=".$tab->getId()."' class='btn'>Consulter l'itinéraire technique</a>";
}

echo "</div>";
