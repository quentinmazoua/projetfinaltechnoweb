<?php

echo '<br><a href="'.Router::get('property/add').'"><button class="btn btn-primary">Ajouter une propriété</button></a>';

if(count($proprietes) > 0)
{
    echo '<br><br><br><table class="table table-hover">';
    echo "<th>Nom</th>";
    echo "<th>Adresse</th>";
    echo "<th>Pays</th>";
    echo "<th>Ville</th>";
    echo "<th>Date d'ajout</th>";
    echo "<th>Photos</th>";
    echo "<th>Actions</th>";

    foreach($proprietes as $propriete)
    {
        echo '<tr>';
        $date = Date::create_from_string($propriete["date_ajout"], "%Y-%m-%d %H:%M:%S")->format("%d/%m/%Y à %H:%M:%S UTC");
        echo '<td><a href="'.Router::get('view_property', array($propriete["id"])).'">'.$propriete["nom"].'</a></td><td>'.$propriete["adresse"].'</td><td>'.$propriete["pays"].'</td><td>'.$propriete["ville"].'</td><td>'.$date.'</td><td><a href="#">Voir</a></td><td><a title="Éditer cette propriété" href="'.Router::get('edit_property', array($propriete['id'])).'"><font color="blue"><span class="glyphicon glyphicon-pencil"></span></font></a>&nbsp;&nbsp;&nbsp;<a title="Supprimer cette propriété" href="'.Router::get('delete_property', array($propriete['id'])).'"><font color="red"><span class="glyphicon glyphicon-trash"></span></font></a>&nbsp;&nbsp;&nbsp;<a title="Voir les demandes de location pour cette propriété" href="'.Router::get('property_rentals', array($propriete['id'])).'"><span class="glyphicon glyphicon-calendar"></span></a></td>';
        echo '</tr>';
    }

    echo '</table>';
}
else
{
    echo "<br><br><p>Vous n'avez pas encore publié de propriété sur le site.</p>";
}