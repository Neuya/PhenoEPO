<form class='formValidate' id='formValidate' action="index.php" method="post" onsubmit='return verif_input()'>
    <input type="hidden" name="action" value="created">
    <input type="hidden" name="controller" value ="station">
   
    <fieldset >
        <legend>Inserez ici vos données sur la station</legend>

            <div class='row'>
                Nom de la station : 
                <br></br>
                <div class='input-field col s12'>
                    <input id='nom' type="text" name="nom" class='validate'>
                    <label for='nom'>Nom</label>
                </div>
                Lieu : 
                <br></br>
                <div class='input-field col s6'>
                    <input type="text" name="ville" class='validate'>
                    <label for='ville'>Ville</label>
                </div>
                <div class='input-field col s6'>
                    <input type="text" name="pays" class='validate'>
                    <label for='pays'>Pays</label>
                </div>
                Coordonnées géographiques :
                <br></br>
                <div class='input-field col s6'>
                    <input type="text" name="longi" class='validate'>
                    <label for='longi'>Longitude</label>
                </div>
                <div class='input-field col s6'>
                    <input type="text" name="lati" class='validate'>
                    <label for='lati'>Latitude</label>
                </div>
        </div>
    </fieldset>
    <br></br>
    <button type="submit" class="btn waves-effect waves-light">Inserer la station</button>
    
    
    
    
</form>