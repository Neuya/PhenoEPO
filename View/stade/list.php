<form method='post' action='index.php'>
            <input type='hidden' name="action" value='recherche'>
            <input type='hidden' name="controller" value="stade">
            <fieldset>
                <legend>Rechercher un stade</legend>
                <div class='input-field'>
                    <input id='id' type="text" name="idStade" class='validate'>
                    <label for='id'>Code du stade</label>
                </div>
                <div class='input-field'>
                    <input id='description' type="text" name="description" class='validate'>
                    <label for='description'>Description</label>
                </div>
                 <button type="submit" class="btn waves-effect waves-light">Rechercher</button>
            </fieldset>
</form>
<br></br>


        <?php
    echo "<table class='striped' style='border : 1px solid black; overflow : hidden;'><tr><th>Code Stade</th><th>Description</th></tr>";
foreach ($stade as $_stade)
{
    echo "<tr><td>".$_stade->getIdStade();
    echo "</td><td style='table-layout:fixed;overflow : hidden; max-width:500px;' >".$_stade->getDescription()."<a "
            . "href='index.php?action=update&controller=stade&idStade=".$_stade->getIdStade()."'>"
            . "<i style='color : green;' class='material-icons right'>create</i></a>";    
    echo "</td></tr>";
}
echo "</table>";
?>
<blockquote>
    Le stade que vous recherchez ne figure pas dans la liste? <br></br>
<a class="btn waves-effect waves-light" href='index.php?action=create&controller=stade'>Ajouter un ou plusieurs stades à la base</a>
</blockquote>
