<blockquote><p> Attention les stades suivants n'existent pas dans la base de données ! </p>

<?php 

foreach($tabStadesInconnus as $tab)
{
    for ($i=0;$i<count($tab);$i++)
    {
    echo "<p> Le stade $tab[$i] est inconnu à la base! </p>";
    }
}
?>
    
</blockquote>


<p> Pour assurer la cohérence des données veuillez insérer un csv de type Stade afin de compléter les stades manquants </p>
<p> Après avoir envoyé le csv, vous retournerez sur la page précédente pour l'insertion des données sur les traitements </p>

<form method="post" action ="index.php?" enctype='multipart/form-data'>
    <input type="hidden" name="action" value="createdStadeInconnu">
    <input type="hidden" name="controller" value="traitement">
<fieldset>
        <input type="file" name="csvstade"></input>
        <legend>Inserez ici votre fichier CSV portant sur les stades</legend>
    </fieldset>
    <input class='btn' type="submit" value="Envoyer le CSV"></input>

</form>