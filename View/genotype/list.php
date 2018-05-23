<form method='post' action='index.php' class='input-field'>
            <input type='hidden' name="action" value='recherche'>
            <input type='hidden' name="controller" value="genotype">
            <fieldset>
                <legend>Rechercher un génotype</legend>
                Par référence:
                <input type ="search" placeholder="Entrez une référence de génotype" name="refGeno">
              
                <div class='row'>
                <div class='col s6'>
                    Par groupe : 
                    <select name="groupeGeno">
                        <option>Tous les groupes</option>
                        <?php
                        for ($i=0;$i<count($groupes);$i++)
                        {
                            echo "<option>".$groupes[$i][0]."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class='col s6'>
                    Par espèce :
                    <select name="espece">
                        <option>Toutes les espèces</option>
                        <?php
                        for ($i=0;$i<count($especes);$i++)
                        {
                            echo "<option>".$especes[$i][0]."</option>";
                        }
                        ?>
                    </select>
                </div>
                </div>
                <button type="submit" class="btn waves-effect waves-light">Rechercher</button>
            </fieldset>
</form>

<p>Vous souhaitez ajouter des génotypes à la base?</p>
<a class='btn' href="index.php?action=create&controller=genotype">Insérer des génotypes</a>
<br></br>
<table class='striped'><tr><th>Référence</th><th>Groupe</th><th>Espece</th></tr>
    
    <?php
    
        foreach($genotypes as $tab)
        {
            echo "<tr><td>$tab[0]</td>"
                . "<td>$tab[2]</td>"
                . "<td>$tab[1]</td></tr>";
        }
    
    ?>
</table>
