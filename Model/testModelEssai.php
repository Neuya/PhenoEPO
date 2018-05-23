<?php

require_once "Model.php";       
require_once "ModelEssai.php";

$essai = new ModelEssai(NULL,5,5,25,5,8,"42.150","-45.125",2,1);

$essai->save();

