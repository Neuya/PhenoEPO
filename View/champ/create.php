<?php 
echo "Vous vous apprêtez à insérer un champ dans la Station :<strong> ".$station->getNom().""
        . "</strong> située en <strong>".$station->getPays().""
        . "</strong> à <strong>".$station->getVille()."</strong>";

?>


<form action="index.php" method="post">
    <input type="hidden" name="action" value="created">
    <input type="hidden" name="controller" value ="champ">
    <input type="hidden" name="idStation" value="<?php echo $idStation ?>">
    <fieldset>
        <legend>Inserez ici vos données sur le champ</legend>
        Nom :
        <input type="text" name="nom" class='validate'>
        <br></br>
        Longitude :
        <input type="text" name="longitude" class='validate'>
        <br></br>
        Latitude :
        <input type="text" name="latitude" class='validate'>
        <br></br>
        Altitude :
        <input type="text" name="altitude" class='validate'>
        <br></br>
        <?php
        
        echo "<select name='typeSol'>";
        
        foreach ($tabTypeSol as $tab)
        {
            echo "<option>$tab[0]</option>";
        }
        echo "</select>";
        echo "<select name = profondeur>";
        
        foreach ($tabProfondeur as $tab)
        {
            echo "<option>$tab[0]</option>";
        }
        
        echo "</select>";
    ?>
    </fieldset>
    <button type="submit" class="btn waves-effect waves-light">Inserer le champ</button>
    
    
    
    
</form>
