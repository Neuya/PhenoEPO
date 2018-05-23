<h5>L'application a détecté des erreurs dans le csv que vous avez inséré</h5>
<img src='img/error.png' id="img_valide">
<h6>Les erreurs sont listées ci dessous : </h6>

<?php
$compteur = 0;

foreach($tab_ligne_geno as $tab)
{
    if(count($tab)>0)
    {
    echo "<ul class=collapsible>";
    echo "<li>";
    echo "<div class=collapsible-header><h6 style ='color:red'> ERREUR(S)"
    . " dans le CSV : $tab_fichier_errone[$compteur]<i class='material-icons right'>arrow_drop_down</i>"
            . "</h6></div>";  
    echo "<div class=collapsible-body>";
    echo "<p style='border : 1px solid black; text-align:center; background-color : white;'>";
    for ($i=0;$i<count($tab);$i++)
    {
        
        echo "<br></br>". $tab[$i]." cette référence de génotype n'existe pas!<br></br>";
    }    
    echo "</p>";
    echo "</div>";
    echo "</li>";
    echo "</ul>";
    }
}?>

<h6 style='text-align:center'>Que souhaitez vous faire?</h6>
<a href='javascript:history.go(-1)' class="btn waves-effect" id="btn_centre">Retourner à l'insertion des UE</a><br></br>
<a href='index.php?action=create&controller=genotype' 
   class="btn waves-effect" id="btn_centre" target='_blank'>Insérer des génotypes
    <i class="material-icons right">call_made</i></a><br></br>
    <a href='index.php?action=readAll&controller=genotype' class='btn waves-effect' 
       id='btn_centre' target='_blank'>Consulter la liste des génotypes
        <i class="material-icons right">call_made</i></a>