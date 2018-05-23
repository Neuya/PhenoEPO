<?php 
echo "<p>Vous vous apprêtez à insérer un champ dans la Station :<strong> ".$station->getNom().""
        . "</strong> située en <strong>".$station->getPays().""
        . "</strong> à <strong>".$station->getVille()."</strong></p>";

?>


<form action="index.php" method="post">
    <input type="hidden" name="action" value="updated">
    <input type="hidden" name="controller" value ="champ">
    <input type="hidden" name="idStation" value="<?php echo $idStation ?>">
    <fieldset>
        <legend>Inserez ici vos données à modifier sur le champ</legend>
        Nom :
        <input type="text" name="nom" value="<?php echo $champ->getNom();?>">
        <br></br>
        Longitude :
        <input type="text" name="longitude" value="<?php echo $champ->getLongitude();?>">
        <br></br>
        Latitude :
        <input type="text" name="latitude" value="<?php echo $champ->getLatitude();?>">
        <br></br>
        Altitude :
        <input type="text" name="altitude" value="<?php echo $champ->getAltitude();?>">
        <br></br>
    </fieldset>
    <button type="submit" class="btn waves-effect waves-light">Modifier le champ</button>
    
    
    
    
</form>