<?php

namespace Model;

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
    'date_inscription'
    );

    protected static $_mass_blacklist = array(
    'id'
    );

}