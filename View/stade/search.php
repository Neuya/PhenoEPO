<?php

if(empty($stade))
{
    echo "<p style='color : red'>Aucun stade ne correspond à votre recherche</p>";
    echo "<blockquote>
        Vous souhaitez ajouter des stades à la base de données?  <br></br>
    <a class='btn waves-effect waves-light' href='index.php?action=create&controller=stade'>Ajouter un ou plusieurs stades à la base</a>
    </blockquote>";
}
else
{
require_once File::build_path(array("View","stade","list.php"));
}   

