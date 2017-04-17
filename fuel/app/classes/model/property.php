<?php

namespace Model;
use Fuel\Core\DB;

class Property extends \Model_Crud
{
    // Config
    protected static $_table_name = 'proprietes';
    protected static $_primary_key = 'id';
    
    protected static $_properties = array(
    'id',
    'id_proprietaire',
    'nom',
    'adresse',
    'pays',
    'ville',
    'date_ajout'
    );

    protected static $_mass_blacklist = array(
    'id'
    );

    public static function search($q)
    {
        $query = DB::select('*')->from('proprietes')
                                ->where('nom', 'like', '%'.$q.'%')
                                ->or_where('adresse', 'like', '%'.$q.'%')
                                ->or_where('ville', 'like', '%'.$q.'%');
                                
        return $query->execute();
    }
}