<ul class="pagination" style="text-align:  center; background-color : #A1BBA4;">
    <li class="disabled"><a href="#!"><i class="mdi-navigation-chevron-left"></i></a></li>
    <li class="active green"><a href="#!">1) Essais</a></li>
    <li class="active green"><a href="#!">2) ITK</a></li>
    <li class="active green"><a href="#!">3) UEs</a></li>
    <li class="waves-effect"><a href="#!">4) Phénotypes</a></li>
    <li class="waves-effect"><a href="#!">5) Validation</a></li>
    <li class="waves-effect"><a href="#!"><i class="mdi-navigation-chevron-right"></i></a></li>
  </ul>

<img src='img/valide.png' id='img_valide'>
<h5>Vos données sur les UEs ont bien étées insérées dans la base</h5>
<?php




/*<p>Afin de retourner à la page d'insertion pour les essais</p>
<form method="post">
    
    <input type='hidden' name='tab_itk' value='<?php echo $tab_ref_itk ?>'>
    <input type="hidden" name="tab_id_essais" value='<?php echo $tab_id_essais?>'>
    <input type='hidden' name='action' value='created'>
    <input type='hidden' name='controller' value='essai'>
    <input type='hidden' name='savedTraitement' value='<?php echo $savedTraitement ?>'>
    <input type='hidden' name='savedUE' value='<?php echo $savedUE ?>'>
    <button class='btn' type='submit'>Retourner à l'insertion</button>
    
</form> */?>
<br></br>
<a href="index.php?action=create&controller=phenotype" class="btn waves-effect" id='btn_centre'>Ajouter des phénotypes aux essais</a>
