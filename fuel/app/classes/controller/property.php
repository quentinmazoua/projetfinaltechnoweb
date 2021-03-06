<?php

use \Model\Property;
use \Model\User;
use \Model\Rental;
use \Model\Commentaire;
use \Model\Photo;

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
                    $properties[] = array('id' => $property->id, 'nom' => $property->nom, 'adresse' => $property->adresse, 'pays' => $property->pays, 'ville' => $property->ville, 'date_ajout' => $property->date_ajout);
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

                $config = array(
                    'path' => DOCROOT.'files',
                    'randomize' => true,
                    'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
                );     
                
                if ($val->run()) // Si tous les champs du formulaire sont valides
                {
                    Upload::process($config);

                    if(Upload::is_valid())
                    {
                        Upload::save();   
                    }

                    $prefs = "";

                    if(Input::post('preference_animaux') != "on")
                    {
                        $prefs .= 'no_pets';
                    }

                    if(Input::post('preference_cigarettes') != "on")
                    {
                        if($prefs != "")
                        {
                            $prefs .= ";";
                        }
                        $prefs .= 'no_smoking';
                    }                    
                    
                    // Création d'une nouvelle propriété
                    $property = Property::forge()->set(array(
                        'id_proprietaire' => Session::get('user')['user_id'],
                        'nom' => Input::post('nom'),
                        'adresse' => Input::post('adresse'),
                        'pays' => Input::post('pays'),
                        'ville' => Input::post('ville'),
                        'date_ajout' => Date::time()->format("%Y-%m-%d %H:%M:%S"),
                        'preferences' => $prefs
                    ));

                    $property->save(); // Enregistrement de la nouvelle propriété dans la BDD

                    foreach(Upload::get_files() as $file)
                    {
                        $photo = Photo::forge(array(
                            'id_propriete' => $property->id,
                            'path' => $file['saved_as']
                        ));

                        $photo->save();
                    }

                    return Response::redirect("properties");
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

    public function action_edit($id)
    {
        if(Session::get('user') != null)
        {
            if(Input::method() === "POST")
            {

            }
            else
            {
                $view = View::forge('base');

                $view->set_global('title', 'Propriete(Édition)');
                $view->content = View::forge('property/edit');
                $view->content->selectCountry = View::forge('property/country_select');

                return Response::forge($view);
            }
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
                'date_ajout' => $property->date_ajout,
                'preferences' => $property->preferences
            );

            if($property['preferences'] != "")
            {
                $property['preferences'] = explode(';', $property['preferences']);
            }
            else
            {
                $property['preferences'] = array();
            }

            $proprietaire = array(
                'id' => $proprietaire->id, 
                'prenom' => $proprietaire->prenom,
                'nom' => $proprietaire->nom
            );

            $commentaires_db = Commentaire::find(array(
                'where' => array('id_propriete' => $id)
            ));

            $commentaires = array();

            if(count($commentaires_db) > 0)
            {
                foreach($commentaires_db as $commentaire)
                {
                    $locataire = User::find(array(
                        'where' => array('id' => $commentaire->id_locataire)
                    ));

                    $locataire = $locataire[0];

                    $commentaires[] = array(
                        'id_locataire' => $locataire->id,
                        'prenom_locataire' => $locataire->prenom,
                        'nom_locataire' => $locataire->nom,
                        'date_publication' => Date::create_from_string($commentaire->date_publication, "%Y-%m-%d")->format("%d/%m/%Y"),
                        'note' => $commentaire->note,
                        'texte' => $commentaire->texte
                    );
                }
            }

            $photos_db = Photo::find(array(
                'where' => array('id_propriete' => $id)
            ));

            $photos = array();

            if(count($photos_db) > 0)
            {
                foreach($photos_db as $photo)
                {
                    $photos[] = $photo->path;
                }
            }

            $view->set_global('propriete', $property);
            $view->set_global('proprietaire', $proprietaire);
            $view->set_global('galerie', true);
            $view->set_global('commentaires', $commentaires);
            $view->set_global('photos', $photos);

            Session::set_flash('propriete', $property);
            Session::set_flash('proprietaire', $proprietaire);

            return Response::forge($view);
        }
        else
        {
            return Response::forge(Presenter::forge('404'));
        }
    }

    public function action_delete($id)
    {
        if(Session::get('user') != null)
        {
            $property = Property::find_by_pk($id);
            if ($property)
            {
                $property->delete();

                $rentals = Rental::find(array(
                    'where' => array('id_propriete' => $id)
                ));

                if($rentals)
                {
                    foreach($rentals as $rental)
                    {
                        $rental->delete();
                    }
                }
            }

            return Response::redirect("properties");
        }
        else
        {
            return Response::redirect("/");
        }
    }

    public function action_rentals($id)
    {
        if(Session::get('user') != null)
        {
            $rentals_in_db = Rental::find(array(
                    'where' => array('id_propriete' => $id)
            ));

            $rentals = array();

            if(count($rentals_in_db) > 0)
            {
                foreach($rentals_in_db as $rental)
                {
                    $propriete = Property::find(array(
                        'where' => array('id' => $id)
                    ));

                    $locataire = User::find(array(
                        'where' => array('id' => $rental->id_locataire)
                    ));

                    $locataire = $locataire[0];
                    $propriete = $propriete[0];

                    $rentals[] = array(
                        'id' => $rental->id,
                        'id_propriete' => $rental->id_propriete,
                        'propriete' => $propriete->nom,
                        'id_locataire' => $rental->id_locataire,
                        'prenom_locataire' => $locataire->prenom,
                        'nom_locataire' => $locataire->nom,
                        'date_debut' => $rental->date_debut,
                        'duree_sejour' => $rental->duree_sejour,
                        'date_demande' => $rental->date_demande,
                        'statut' => $rental->statut == 0 ? 'Réponse en attente':'Acceptée'
                    );
                }
            }

            $view = View::forge('base');
            $view->content = View::forge('property/rentals');

            $view->set_global('title', 'Demandes de location');
            $view->set_global('rentals', $rentals);

            Session::set_flash('id_propriete', $id);

            return Response::forge($view);
        }
    }

    public function action_comment($id)
    {
        if(Session::get('user') != null)
        {
            if(Input::method() === "POST")
            {
                $val = Validation::forge();

                // Définition des champs du formulaire et des règles de validation
                $val->add('texte', 'commentaire')->add_rule('required');

                $val->set_message('required', 'Le champ :label est obligatoire');        
                
                if ($val->run()) // Si tous les champs du formulaire sont valides
                {
                    $comment_db = Commentaire::find(array(
                        'where' => array('id_locataire' => Session::get('user')['user_id'], 'id_propriete' => $id)
                    ));

                    if(count($comment_db) > 0) // L'utilisateur a déjà commenté cette propriété
                    {
                        Commentaire::update_comment($comment_db[0]->id, Input::post('score'), Input::post('texte'));
                    }
                    else
                    {
                        // Création d'un nouveau commentaire
                        $comment = Commentaire::forge()->set(array(
                            'id_propriete' => $id,
                            'id_locataire' => Session::get('user')['user_id'],
                            'date_publication' => Date::time()->format("%Y-%m-%d"),
                            'note' => Input::post('score'),
                            'texte' => Input::post('texte')
                        ));

                        $comment->save(); // Enregistrement du nouveau commentaire dans la BDD
                    }

                    return Response::redirect("rentals");
                }
                else
                {
                    $view = View::forge('base');
                    $view->content = View::forge('property/comment');

                    $view->set_global('title', 'Publier un commentaire');
                    $view->set_global('id', $id);
                    $view->set_global('errors', $val->errors());

                    return Response::forge($view);    
                }
            }
            else
            {
                $view = View::forge('base');
                $view->content = View::forge('property/comment');

                $view->set_global('title', 'Publier un commentaire');
                $view->set_global('id', $id);

                return Response::forge($view);
            }
        }
        else
        {
            return Response::redirect("/");
        }
    }
}