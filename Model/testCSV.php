<?php

require_once "ModelEssai.php";

$csv = file("../csvtest.csv");
$i=0;
$essai = [];
foreach($csv as $line)
{
  $essai[] = str_getcsv($line);
  $ligne = $essai[$i][0];
  echo $ligne;
  echo "_|$i|_"; 
  $i++;
}

ModelEssai::recupCSV($csv,1);
