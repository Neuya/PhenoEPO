

<p> Attention les données suivantes n'existent pas dans la base de données ! </p>
<p> Pour assurer la cohérence de la base veuillez remplir les informations suivantes manquantes.</p>
<p> Vous pouvez vous référer au tableau ci dessous afin d'éviter d'inscrire un code de stade déjà existant</p>
<?php 
require_once File::build_path(array("View","intrant","list.php"));

echo "<form method='post' action ='index.php'>";

$nombreIntrants = 0;

foreach($tabIntrantsInconnus as $tab)
{
    for ($i=0;$i<count($tab);$i++)
    {
        echo "Le code intrant <strong>'$tab[$i]'</strong>  est inconnu à la base.";
        echo
            "<fieldset>
            <legend>Inserez ici les données pour le traitement <strong>'$tab[$i]'</strong></legend>
            Code de l'intrant : 
            <input type='text' placeholder='Ex : $tab[$i]' name='code$nombreIntrants'><br></br>
            Type de l'intrant :
            <input type ='text' placeholder='Ex : Ajout azote' name='type$nombreIntrants'><br></br>
            Unite de l'intrant :
            <input type='text' placeholder='Ex : Kg/h' name='unite$nombreIntrants'><br></br>
            </fieldset><br></br>";
        $nombreIntrants++;
    }
}

?>

<p> Après avoir confirmé l'envoi, vous retournerez sur la page précédente. </p>

        <input type='hidden' name='action' value='createdIntrantInconnu'>
        <input type='hidden' name='controller' value='traitement'>
        <input type='hidden' name='nombreIntrants' value=<?php echo "$nombreIntrants"?>>
        <button class='btn waves-effect' type='submit'>Insérer l'intrant</button>
</form>