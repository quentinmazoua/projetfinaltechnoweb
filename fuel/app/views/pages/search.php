<br>
<p>Résultats pour votre recherche <?php echo $query ?>:</p>
<br>
<p>Propriétés (<?php echo count($proprietes);?> résultat(s)):</p>
<?php 
foreach($proprietes as $propriete)
{
    echo '<p><a href="'.Router::get('view_property', array($propriete["id"])).'">'.$propriete["nom"].'</a> '.$propriete["adresse"].' '.$propriete["ville"].' '.$propriete["pays"].'</p>';
}
?>
<br>
<p>Utilisateurs (<?php echo count($utilisateurs);?> résultat(s)):</p>
<?php 
foreach($utilisateurs as $utilisateur)
{
    echo '<p><a href="'.Router::get('view_user', array($utilisateur["id"])).'">'.$utilisateur["prenom"].' '.$utilisateur["nom"].'</a></p>';
}
?>