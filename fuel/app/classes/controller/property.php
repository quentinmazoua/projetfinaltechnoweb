<?php

use \Model\Property;
use \Model\User;

class Controller_Property extends Controller
{

    public function action_properties()
    {
        if(Session::get('user') != null)
        {
            $properties_in_db = Property::find(array(
                'where' => array('id_proprietaire' => Session::get('user')['user_id']) // Recherche des propriétés de l'utilisateur dans la BDD
            ));

            $properties = array();

            if(count($properties_in_db) > 0)
            {
                foreach($properties_in_db as $property)
                {
                    $properties[] = array('nom' => $property->nom, 'adresse' => $property->adresse, 'pays' => $property->pays, 'ville' => $property->ville, 'date_ajout' => $property->date_ajout);
                }
            }
            
            $view = View::forge('base');
            $view->content = View::forge('property/properties');

            $view->set_global('title', 'Mes propriétés');
            $view->set_global('proprietes', $properties);

            return Response::forge($view);
        }
        else
        {
            return Response::redirect("/");
        }
    }

    public function action_add()
    {
        if(Session::get('user') != null)
        {
            if(Input::method() === "POST")
            {
                $val = Validation::forge();

                // Définition des champs du formulaire et des règles de validation
                $val->add('nom', 'nom')->add_rule('required');

                $val->add('adresse', 'adresse')->add_rule('required');

                $val->add('ville', 'ville')->add_rule('required');

                $val->set_message('required', 'Le champ :label est obligatoire');        
                
                if ($val->run()) // Si tous les champs du formulaire sont valides
                {
                    $view = View::forge('base');

                        // Création d'une nouvelle propriété
                        $property = Property::forge()->set(array(
                            'id_proprietaire' => Session::get('user')['user_id'],
                            'nom' => Input::post('nom'),
                            'adresse' => Input::post('adresse'),
                            'pays' => Input::post('pays'),
                            'ville' => Input::post('ville'),
                            'date_ajout' => Date::time()->format("%Y-%m-%d %H:%M:%S")
                        ));

                        $property->save(); // Enregistrement de la nouvelle propriété dans la BDD

                        $view->set_global('title', 'Mes propriétés');
                        $view->content = View::forge('property/properties');

                    return Response::forge($view);
                }
                else // Sinon le formulaire contient des erreurs
                {
                    $view = View::forge('base');

                    $view->set_global('title', 'Ajouter une propriété');
                    $view->set_global('errors', $val->error());
                    $view->content = View::forge('property/add_property');
                    $view->content->selectCountry = View::forge('property/country_select');

                    return Response::forge($view);
                }
            }
            else
            {
                $view = View::forge('base');
                $view->content = View::forge('property/add_property');
                $view->content->selectCountry = View::forge('property/country_select');

                $view->set_global('title', 'Ajouter une propriété');

                return Response::forge($view);
            }
        }
        else
        {
            return Response::redirect("/");
        }
    }

    public function action_view($id)
    {
        $property_in_db = Property::find(array(
            'where' => array('id' => $id)
        ));

        if(count($property_in_db) > 0)
        {
            $property = $property_in_db[0];

            $view = View::forge('base');
            $view->content = View::forge('property/property');

            $view->set_global('title', $property->nom);

            $proprietaire_in_db = User::find(array(
                'where' => array('id' => $property->id_proprietaire)
            ));

            $proprietaire = $proprietaire_in_db[0];

            $property = array(
                'id' => $property->id,
                'id_proprietaire' => $property->id_proprietaire,
                'nom' => $property->nom, 
                'adresse' => $property->adresse, 
                'pays' => $property->pays, 
                'ville' => $property->ville, 
                'date_ajout' => $property->date_ajout
            );

            $proprietaire = array(
                'id' => $proprietaire->id, 
                'prenom' => $proprietaire->prenom,
                'nom' => $proprietaire->nom
            );

            $view->set_global('propriete', $property);
            $view->set_global('proprietaire', $proprietaire);

            Session::set_flash('propriete', $property);
            Session::set_flash('proprietaire', $proprietaire);

            return Response::forge($view);
        }
        else
        {
            return Response::forge(Presenter::forge('404'));
        }
    }
}