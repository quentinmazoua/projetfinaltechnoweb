<?php

use \Model\Rental;
use \Model\Property;
use \Model\User;

class Controller_Rental extends Controller
{

    public function action_rentals()
    {
        if(Session::get('user') != null)
        {
            $rentals_in_db = Rental::find(array(
                    'where' => array('id_locataire' => Session::get('user')['user_id'])
            ));

            $rentals = array();

            foreach($rentals_in_db as $rental)
            {
                $propriete = Property::find(array(
                    'where' => array('id' => $rental->id_propriete)
                ));

                $proprietaire = User::find(array(
                    'where' => array('id' => $propriete[0]->id_proprietaire)
                ));

                $propriete = $propriete[0];
                $proprietaire = $proprietaire[0];

                $rentals[] = array(
                    'id_propriete' => $rental->id_propriete,
                    'propriete' => $propriete->nom,
                    'id_proprietaire' => $proprietaire->id,
                    'prenom_proprietaire' => $proprietaire->prenom,
                    'nom_proprietaire' => $proprietaire->nom,
                    'date_debut' => $rental->date_debut,
                    'duree_sejour' => $rental->duree_sejour,
                    'date_demande' => $rental->date_demande,
                    'statut' => $rental->statut == 0 ? 'Réponse en attente':'Acceptée'
                );
            }

            $view = View::forge('base');
            $view->content = View::forge('rental/rentals');

            $view->set_global('title', 'Mes locations');
            $view->set_global('rentals', $rentals);

            return Response::forge($view);
        }
        else
        {
            return Response::redirect("/");
        }
    }

    public function action_rent_request($id)
    {
        if(Session::get('user') != null)
        {
            $view = View::forge('base');
            $view->content = View::forge('rental/rent_request');

            $view->set_global('title', 'Demande de location');
            if(Session::get_flash('propriete', null, false) != null)
            {
                $property = Session::get_flash('propriete', null, true);
            }
            else
            {
                $property_in_db = Property::find(array(
                    'where' => array('id' => $id)
                ));

                $property = $property_in_db[0];

                $property = array(
                    'id' => $property->id,
                    'id_proprietaire' => $property->id_proprietaire,
                    'nom' => $property->nom, 
                    'adresse' => $property->adresse, 
                    'pays' => $property->pays, 
                    'ville' => $property->ville, 
                    'date_ajout' => $property->date_ajout
                );
            }
            if(Session::get_flash('proprietaire', null, false) != null)
            {
                $proprietaire = Session::get_flash('proprietaire', null, true);
            }
            else
            {
                $proprietaire_in_db = User::find(array(
                    'where' => array('id' => $property['id_proprietaire'])
                ));

                $proprietaire = $proprietaire_in_db[0];

                $proprietaire = array(
                    'id' => $proprietaire->id,
                    'prenom' => $proprietaire->prenom,                     
                    'nom' => $proprietaire->nom, 
                );
            }  

            $view->set_global('propriete', $property);
            $view->set_global('proprietaire', $proprietaire);

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
                $val->add('date_sejour', 'date_sejour')->add_rule('required');

                $val->add('duree_sejour', 'duree_sejour')->add_rule('required');

                $val->set_message('required', 'Le champ :label est obligatoire');        
                
                if ($val->run()) // Si tous les champs du formulaire sont valides
                {
                    $view = View::forge('base');

                    //TODO Checkez si la propriété est libre pour la période choisie
                   if(Rental::est_libre(Input::post('id_propriete'), Input::post('date_sejour'), Input::post('duree_sejour')) === "OUI")
                   {
                        // Création d'une nouvelle location
                        $rental = Rental::forge()->set(array(
                            'id_propriete' => Input::post('id_propriete'),
                            'id_locataire' => Session::get('user')['user_id'],
                            'date_debut' => Input::post('date_sejour'),
                            'duree_sejour' => Input::post('duree_sejour'),
                            'date_demande' => Date::time()->format("%Y-%m-%d %H:%M:%S"),
                            'statut' => 0
                        ));
                    
                        $rental->save(); // Enregistrement de la nouvelle location dans la BDD

                        return Response::redirect("rentals");
                   }
                   else
                   {
                        Session::set_flash('not-available', true);

                        return Response::redirect(Router::get('rent_request', array(Input::post('id_propriete'))));
                   }
                }
                else // Sinon le formulaire contient des erreurs
                {
                    Session::set_flash('errors', $val->error());

                    return Response::redirect(Router::get('rent_request', array(Input::post('id_propriete'))));
                }
            }
            else
            {
                return Response::redirect_back();
            }
        }
        else
        {
            return Response::redirect("/");
        }
    }
}