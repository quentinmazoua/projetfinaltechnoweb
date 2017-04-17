<?php
echo "<br>";
echo '<div class="row">';
echo '<div class="col-md-10"><h2>'.$propriete["nom"];
if(Session::get('user') === null || Session::get('user')['user_id'] === $propriete['id_proprietaire'])
{
    echo '&nbsp;&nbsp;<a href=""><button class="btn btn-primary" disabled>Demande de location</button></a>';
}
else
{
    echo '&nbsp;&nbsp;<a href="'.Router::get("rent_request", array($propriete["id"])).'"><button class="btn btn-primary">Demande de location</button></a>';        
}
echo '</h2></div>';
echo '<div class="col-md-2">';
echo '<div class="fb-share-button" data-href="'.Router::get('view_property', array($propriete["id"])).'" data-layout="button_count" data-size="small" data-mobile-iframe="false"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse">Partager</a></div>';
echo '&nbsp;&nbsp;<a href="#" style="position:absolute;vertical-align:text-top;"><font color="#B40404" size="4em"><span class="glyphicon glyphicon-flag" title="Signaler un contenu inapproprié"></span></font></a>';
echo '</div>';
echo '</div>';
echo "<hr>";
echo '<div class="row">';
echo '<div class="col-md-6">';
echo "<p>".$propriete["adresse"]."</p>";
echo "<p>".$propriete["pays"]."</p>";
echo "<p>".$propriete["ville"]."</p>";
echo "<p>Propriétaire: <a href='".Router::get('view_user', array($propriete['id_proprietaire']))."'>".$proprietaire["prenom"]." ".$proprietaire["nom"]."</a></p>";
$date = Date::create_from_string($propriete["date_ajout"], "%Y-%m-%d %H:%M:%S")->format("%d/%m/%Y à %H:%M:%S UTC");
echo "<p>Publiée le ".$date."</p>";
echo '</div>';
echo '<div class="col-md-6"  style="height:200px;overflow:auto;">';
echo '<p>Commentaires:</p>';
if(count($commentaires) > 0)
{
    foreach($commentaires as $commentaire)
    {
        echo '<div class="row"><div class="col-md-4" style="width:200px;">'.$commentaire["prenom_locataire"].' '.str_split($commentaire["nom_locataire"])[0].'. ('.$commentaire["date_publication"].'): </div><div class="col-md-4" style="position:absolute;margin-left:100px;"><div style="margin-left:0px;left:0px;" class="note" data-score="'.$commentaire["note"].'"></div></div></div>';
        echo '<pre>'.$commentaire["texte"].'</pre>';
        echo "<br>";
    }    
}
else
{
    echo "<br><p>Cette propriété n'a pas encore reçu de commentaire.</p>";
}
echo '</div>';
echo '</div>';
echo "<br><p>Galerie photos:</p>";
?>
<div class="fotorama" data-nav="thumbs">>
  <img src="http://s.fotorama.io/1.jpg">
  <img src="http://s.fotorama.io/2.jpg">
</div>
<br><br>