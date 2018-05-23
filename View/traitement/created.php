<ul class="pagination" style="text-align:  center; background-color : #A1BBA4;">
    <li><a href="#!"><i class="mdi-navigation-chevron-left"></i></a></li>
    <li class="active green"><a href="#!">1) Essais</a></li>
    <li class="active green"><a href="#!">2) ITK</a></li>
    <li class="waves-effect"><a href="#!">3) UEs</a></li>
    <li class="waves-effect"><a href="#!">4) Phénotypes</a></li>
    <li class="waves-effect"><a href="#!">5) Validation</a></li>
    <li class="waves-effect"><a href="#!"><i class="mdi-navigation-chevron-right"></i></a></li>
</ul>
<img src="img/valide.png" id='img_valide'>

<?php


echo "<h6>Vos traitements sur les essais ont correctement étés insérés !</h6>";
?>

<p>Cliquez sur ce bouton afin de pouvoir insérer des UEs à vos essais :</p>
<form method="post">
    <input type='hidden' name='tab_ref_itk' value='<?php echo $tab_ref_itk ?>'> 
    <input type="hidden" name="tab_id_essais" value='<?php echo $tab_id_essais ?>'>
    <input type='hidden' name='action' value='create'>
    <input type='hidden' name='controller' value='UE'>
    <button class='btn' id="btn_centre" type='submit'>Insérer des Unités Expérimentales</button>
</form>



