<?php

namespace Model;
use Fuel\Core\DB;

class User extends \Model_Crud
{
    // Config
    protected static $_table_name = 'utilisateurs';
    protected static $_primary_key = 'id';
    
    protected static $_properties = array(
    'id',
    'prenom',
    'nom',
    'email',
    'password',
    'date_inscription',
    'image_profil'
    );

    protected static $_mass_blacklist = array(
    'id'
    );

    public static function search($q)
    {
        $query = DB::select('id', 'prenom', 'nom')->from('utilisateurs')
                                ->where('prenom', 'like', '%'.$q.'%')
                                ->or_where('nom', 'like', '%'.$q.'%');

        return $query->execute();
    }
}