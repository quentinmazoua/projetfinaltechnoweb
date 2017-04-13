<?php

use \Model\Property;

class Controller_Property extends Controller
{

    public function action_properties()
    {
        if(Session::get('user') != null)
        {
            $view = View::forge('base');
            $view->content = View::forge('property/properties');

            $view->set_global('title', 'Mes propriétés');

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
                $val->add('adresse', 'adresse')->add_rule('required');

                $val->add('ville', 'ville')->add_rule('required');

                $val->set_message('required', 'Le champ :label est obligatoire');        
                
                if ($val->run()) // Si tous les champs du formulaire sont valides
                {
                    $view = View::forge('base');

                        // Création d'une nouvelle propriété
                        $property = Property::forge()->set(array(
                            'id_proprietaire' => Session::get('user')['user_id'],
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
}