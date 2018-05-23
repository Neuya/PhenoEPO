<?php


echo "<h5> Modification de la description du stade : $idStade</h5><br></br>";

?>

<form method="post" action="index.php?">
    <input type="hidden" name="action" value="updated">
    <input type="hidden" name="controller" value="stade">
    <input type="hidden" name="idStade" value="<?php echo $idStade; ?>">
    <fieldset>
    Description:
    <input type="text" name="description" value="<?php echo $stade->getDescription(); ?>">
    </fieldset>
    <br></br>
    <button type="submit" class="btn">Valider</button
    
</form>

<br></br>