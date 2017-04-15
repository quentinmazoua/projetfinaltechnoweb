<?php
echo "<br>";
echo '<h2>'.$propriete["nom"];
if(Session::get('user') === null || Session::get('user')['user_id'] === $propriete['id_proprietaire'])
{
    echo '&nbsp;&nbsp;<a href=""><button class="btn btn-primary" disabled>Demande de location</button></a>';
}
else
{
    echo '&nbsp;&nbsp;<a href="'.Router::get("rent_request", array($propriete["id"])).'"><button class="btn btn-primary">Demande de location</button></a>';        
}
echo '</h2>';
echo "<hr>";
echo "<p>".$propriete["adresse"]."</p>";
echo "<p>".$propriete["pays"]."</p>";
echo "<p>".$propriete["ville"]."</p>";
echo "<p>Propriétaire: <a href='".Router::get('view_user', array($propriete['id_proprietaire']))."'>".$proprietaire["prenom"]." ".$proprietaire["nom"]."</a></p>";
$date = Date::create_from_string($propriete["date_ajout"], "%Y-%m-%d %H:%M:%S")->format("%d/%m/%Y à %H:%M:%S UTC");
echo "<p>Publiée le ".$date."</p>";
echo "<br><p>Galerie photos:</p>";