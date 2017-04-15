<?php

namespace Model;
use Fuel\Core\Date;

class Rental extends \Model_Crud
{
    // Config
    protected static $_table_name = 'locations';
    protected static $_primary_key = 'id';
    
    protected static $_properties = array(
    'id',
    'id_propriete',
    'id_locataire',
    'date_debut',
    'duree_sejour',
    'date_demande',
    'statut'
    );

    protected static $_mass_blacklist = array(
    'id'
    );

    public static function est_libre($propriete, $date, $jours)
    {
        $res = Rental::find(array(
            'where' => array('id_propriete' => $propriete)
        ));

        foreach($res as $rental)
        {
            $date_voulue = Date::create_from_string($date, "%Y-%m-%d")->get_timestamp();
            $date_autre = Date::create_from_string($rental->date_debut, "%Y-%m-%d")->get_timestamp();
            
            $jours_voulue = $jours * 86400;
            $jours_autre = $rental->duree_sejour * 86400;

            if($date_voulue > $date_autre)
            {
                if(($date_voulue + $jours_voulue) < ($date_autre +  $jours_autre))
                {
                    return "NON";
                }
            }
            else
            {
                if((($date_voulue + $jours_voulue) > $date_autre) && (($date_voulue + $jours_voulue) < $date_autre + $jours_autre))
                {
                    return "NON";
                }
            }
        }

        return "OUI";
    } 
}