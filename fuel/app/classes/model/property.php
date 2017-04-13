<?php

namespace Model;

class Property extends \Model_Crud
{
    // Config
    protected static $_table_name = 'proprietes';
    protected static $_primary_key = 'id';
    
    protected static $_properties = array(
    'id',
    'id_proprietaire',
    'adresse',
    'pays',
    'ville',
    'date_ajout'
    );

    protected static $_mass_blacklist = array(
    'id'
    );

}