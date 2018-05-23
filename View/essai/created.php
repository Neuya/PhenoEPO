<ul class="pagination" style="text-align:  center; background-color : #A1BBA4;">
    <li class="disabled"><a href="#!"><i class="mdi-navigation-chevron-left"></i></a></li>
    <li class="active green"><a href="#!">1) Essais </a></li>
    <li class="waves-effect"><a href="#!">2) ITK</a></li>
    <li class="waves-effect"><a href="#!">3) UEs</a></li>
    <li class="waves-effect"><a href="#!">4) Phénotypes</a></li>
    <li class="waves-effect"><a href="#!">5) Validation</a></li>
    <li class="waves-effect"><a href="#!"><i class="mdi-navigation-chevron-right"></i></a></li>
  </ul>
<h6>Votre csv de type essais a correctement été inséré et les données se sont bien sauvegardées dans la base.</h6>



<?php

    $tab_id_essais=unserialize($tab_id_essais);
    echo "<blockquote>";
    echo "Les données du csv contenant les information sur les essais avec les noms suivants : ";
    
    for ($i=0;$i<count($tab_id_essais);$i++)
    {
        
        echo "<p>- ".ModelEssai::getById($tab_id_essais[$i])->getNom()."</p>";
        
    }
    echo "Ont bien étés insérés dans la base.";
    echo "</blockquote>";

    $tab_id_essais=serialize($tab_id_essais);
    
    for($i=0;$i<count($tab_ref_itk);$i++)
    {
        if(ModelTraitement::aTraitement($tab_ref_itk[$i]))
        {
            echo "<h6>La référence ITK $tab_ref_itk[$i] existe dans la base de données !</h6>";
        }
    }

    $tab_ref_itk=unserialize($tab_ref_itk);
    for($i=0;$i<count($tab_ref_itk);$i++)
    {
        if(ModelTraitement::aTraitement($tab_ref_itk[$i]))
        {
            echo "<h6>La référence ITK $tab_ref_itk[$i] existe dans la base de données !</h6>";
        }
    }
    $tab_ref_itk=serialize($tab_ref_itk);
    
    echo "<p>Cliquez sur le bouton suivant pour assignez des ITK à vos essais</p>";
    echo "<a class=btn id=btn_centre href='index.php?controller=traitement&action=createExistant&tab_id_essais=$tab_id_essais&tab_ref_itk=$tab_ref_itk'>Ajouter "
    . "un ITK aux essais</a>";


?>

 




