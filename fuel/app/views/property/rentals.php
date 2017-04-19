<?php

if(count($rentals) > 0)
{
    echo '<br><br><br><table class="table table-hover">';
    echo "<th>Propriété</th>";
    echo "<th>Locataire</th>";
    echo "<th>Date du séjour</th>";
    echo "<th>Durée du séjour</th>";
    echo "<th>Demande effectuée le</th>";
    echo "<th>Statut</th>";
    echo "<th>Actions</th>";

    foreach($rentals as $rental)
    {
        echo '<tr>';
        $date_sejour = Date::create_from_string($rental["date_debut"], "%Y-%m-%d")->format("%d/%m/%Y");
        $date_demande = Date::create_from_string($rental["date_demande"], "%Y-%m-%d %H:%M:%S")->format("%d/%m/%Y à %H:%M:%S UTC");
        echo '<td><a href="'.Router::get('view_property', array($rental['id_propriete'])).'">'.$rental["propriete"].'</td><td><a href="'.Router::get('view_user', array($rental['id_locataire'])).'">'.$rental['prenom_locataire'].' '.$rental['nom_locataire'].'</a></td><td>'.$date_sejour.'</td><td>'.$rental['duree_sejour'].' nuits</td><td>'.$date_demande.'</td><td>'.$rental['statut'].'<td><a title="Accepter cette demande de location" href="'.Router::get('accept_rental', array($rental['id'])).'"><span class="glyphicon glyphicon-ok"></span></a>&nbsp;&nbsp;&nbsp;<a title="Refuser cette demande de location" href="'.Router::get('cancel_rental', array($rental["id"])).'"><font color="red"><span class="glyphicon glyphicon-trash"></span></font></a></td>';
        echo '</tr>';
    }

    echo '</table>';
}
else
{
    echo "<br><br><p>Vous n'avez pas encore de demande de location pour cette propriété.</p>";
}