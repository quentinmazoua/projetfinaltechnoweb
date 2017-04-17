<?php

namespace Model;
use Fuel\Core\Date;
use Fuel\Core\DB;

class Commentaire extends \Model_Crud
{
    // Config
    protected static $_table_name = 'commentaires';
    protected static $_primary_key = 'id';
    
    protected static $_properties = array(
    'id',
    'id_propriete',
    'id_locataire',
    'date_publication',
    'note',
    'texte'
    );

    protected static $_mass_blacklist = array(
    'id'
    );

    public static function update_comment($id, $note, $texte)
    {
        $query = DB::update('commentaires');

        $query->set(array('note' => $note, 'texte' => $texte, 'date_publication' => Date::time()->format("%Y-%m-%d")))->where('id', $id);

        $query->execute();
    }
}