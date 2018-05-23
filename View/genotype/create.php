<strong><h6>Veillez à avoir bien enregistré votre csv en encodage UTF8 ou Unicode 8 pour éviter tout conflit</h6></strong>
<ul class='collapsible popout' data-collapsible='accordion'>
    <li>
        <div class='collapsible-header'>Template du CSV a respecter<i class='material-icons right'>arrow_drop_down</i></div>
        <div class='collapsible-body'>
            <table>
                <tr>
                    <th>Référence Génotype</th>
                    <th>Groupe</th>
                    <th>Espèce</th>
                </tr>
            </table>
        </div>
    </li>
</ul>
<form method="post" action ="index.php?" enctype='multipart/form-data' onsubmit='return verif_csv()'>
    <input type="hidden" name="action" value="created">
    <input type="hidden" name="controller" value="genotype">
    <fieldset>
        <legend>Inserez ici votre fichier CSV portant sur les Genotypes</legend>
        
        <div class='file-field input-field'>
        <input type="file" name="csvgeno"></input>
        <div class='btn'>Parcourir</div>
        <div class='file-path-wrapper'>
            <input class='file-path validate' type='text'>
        </div>
        </div>
    </fieldset>
    <br></br>
    <input class='btn' type="submit" value="Envoyer le CSV"></input>
</form>