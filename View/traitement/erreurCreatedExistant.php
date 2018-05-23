<h4>Attention, vous avez fait une erreur dans la page précédente.</h4>
<h5>Vérifiez bien l'orthographe des références avant de valider</h5>
<h5>Vérifiez également que vous avez bien coché "Nouvel ITK" si vous souhaitez insérer nouvel itinéraire technique</h5>
<p> Références inexistantes : </p>
<blockquote>
<?php

for($i=0;$i<count($tab_ref_inconnu);$i++)
{
    echo $tab_ref_inconnu[$i]." n'existe pas dans la base de données"; 
}

?>
</blockquote>
    
<a href="javascript:history.go(-1)" class="btn">Retour à l'insertion des ITK</a>
