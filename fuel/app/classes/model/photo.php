<?php

namespace Model;
//use Fuel\Core\DB;

class Photo extends \Model_Crud
{
    // Config
    protected static $_table_name = 'photos';
    protected static $_primary_key = 'id';
    
    protected static $_properties = array(
        'id',
        'id_propriete',
        'path'
    );

    protected static $_mass_blacklist = array(
        'id'
    );
}