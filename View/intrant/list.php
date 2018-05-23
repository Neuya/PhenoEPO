<p>Ci-contre la liste de l'ensemble des intrants présents dans la base de données</p>
<table class='striped' style='border : 1px solid black'>
    <tr>
        <th>Code</th>
        <th>Type</th>
        <th>Unite</th>
    </tr>
<?php 

foreach($tabIntrants as $tab)
{
    echo "<tr><td>".$tab->getCode()."</td><td>".$tab->getType()."</td><td>".$tab->getUnite()."</td></tr>"; 
}

?>

</table>

<br></br>
<?php 
if(!$insertion)
{
    
echo ""
."<p>L'intrant que vous recherchez n'est pas dans la base?</p>"
."<a class='btn' href='index.php?action=create&controller=intrant'>Insérer un nouvel intrant</a>"
."<br></br>";
}