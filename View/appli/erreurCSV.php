
<h5>L'application a détecté des erreurs dans le ou les fichier(s) csv que vous avez inséré(s)</h5>
<img src='img/error.png' id="img_valide">

<h6>Il semblerait que le ou les csv(s) que vous avez inséré(s) ne respecte(nt) pas les templates
    établis : </h6>

<h6>Fichier(s) en cause :<span style='color : red'> <?php
foreach($tab_csv_errones as $tab)
{
    echo "<br></br>".$tab;
}
?></span></h6>

<p>Veuillez corriger les erreurs avant d'insérer à nouveau</p>

<a href='javascript:history.go(-1)' class='btn waves-effect' id='btn_centre'>
    Retourner à la page précédente
</a>