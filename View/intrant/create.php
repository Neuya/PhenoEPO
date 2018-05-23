<h6>Vous pouvez consulter la liste des intrants déjà présents dans la base situés juste en dessous afin d'éviter de créer un conflit</h6>
<ul class='collapsible popout' data-collapsible='accordion'>
    <li>
        <div class='collapsible-header'>Liste des Intrants<i class='material-icons right'>arrow_drop_down</i></div>
        <div class='collapsible-body'>
            <?php require_once File::build_path(array("View","intrant","list.php")); ?>
        </div>
    </li>
</ul>
<form method='post' action ='index.php' onsubmit='return verif_input()'>
    <fieldset>
        <legend>Inserez ici les données pour le type de traitement</legend>
        Code de l'intrant : 
        <input type="text" placeholder="Ex : azote0" name="code"><br></br>
        Type de l'intrant :
        <input type ="text" placeholder="Ex : Ajout d'azote" name="type"><br></br>
        Unite de l'intrant :
        <input type="text" placeholder="Ex : Kg/h" name="unite"><br></br>
        <input type="hidden" name="action" value="created">
        <input type="hidden" name="controller" value="intrant">
        <button class='btn waves-effect' type="submit">Insérer</button>
    </fieldset>
</form>

<br></br>

