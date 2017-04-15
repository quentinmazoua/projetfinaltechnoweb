<?php

use \Model\User;

class Controller_User extends Controller
{

    public function action_login() // Affichage du formulaire de connexion
    {
        if(Session::get('user') === null)
        {
            $view = View::forge('base');

            if(Input::method() === 'POST')
            {
                $val = Validation::forge();

                // Définition des champs du formulaire et des règles de validation
                $val->add('email', 'adresse mail')->add_rule('required')
                    ->add_rule('valid_email');

                $val->add('password', 'mot de passe')->add_rule('required')
                    ->add_rule('min_length', 6)
                    ->add_rule('max_length', 10);

                $val->set_message('required', 'Le champ :label est obligatoire');
                $val->set_message('valid_email', 'Le champ :label doit contenir une adresse mail valide');
                $val->set_message('min_length', 'Le champ :label doit contenir au moins 6 caractères');
                $val->set_message('max_length', 'Le champ :label doit contenir au maximum 20 caractères');        
            
                if ($val->run()) // Si tous les champs du formulaire sont valides
                {
                    $user_in_db = User::find(array(
                        'where' => array('email' => Input::post('email'), 'password' => Input::post('password')) // Recherche de l'utilisateur dans la BDD
                    ));

                    if(count($user_in_db) == 1) // Si l'utilisateur existe dans la BDD
                    {
                        $user = $user_in_db[0];

                        if(Input::post('rememberMe') === "on")
                        {
                            Session::create()->set_config('expiration_time', 0);
                        }
                        else
                        {
                            Session::create()->set_config('expiration_time', 7200)->set_config('expire_on_close', true);
                        }
                        Session::set('user', array(
                            'user_id' => $user->id,
                            'user_firstname' => $user->prenom, 
                            'user_lastname' => $user->nom, 
                            'user_email' => $user->email, 
                            'user_date_inscription' => $user->date_inscription,
                            'user_image' => $user->image_profil
                        ));
                        return Response::redirect("/");
                    }
                    else
                    {
                        $view->set_global('title', 'Connexion');
                        $view->set_global('authentication_failed', true);
                        $view->content = View::forge('user/login');

                        return Response::forge($view);
                    }
                    
                }
                else // Le formulaire contient des erreurs
                {
                    $view->set_global('title', 'Connexion');
                    $view->set_global('errors', $val->error());
                    $view->content = View::forge('user/login');

                    return Response::forge($view);
                }
            }
            else
            {
                $view->set_global('title', 'Connexion');
                $view->content = View::forge('user/login');

                return Response::forge($view);
            }
        }
        else
        {
            return Response::redirect("/");
        }
    }

    public function action_register() // Affichage du formulaire de connexion
    {
        if(Session::get('user') === null)
        {
            if(Input::method() === 'POST')
            {
                $val = Validation::forge();

                // Définition des champs du formulaire et des règles de validation
                $val->add('prenom', 'prénom')->add_rule('required');

                $val->add('nom', 'nom')->add_rule('required');

                $val->add('email', 'adresse mail')->add_rule('required')
                    ->add_rule('valid_email');

                $val->add('password', 'mot de passe')->add_rule('required')
                    ->add_rule('min_length', 6)
                    ->add_rule('max_length', 10);

                $val->set_message('required', 'Le champ :label est obligatoire');
                $val->set_message('valid_email', 'Le champ :label doit contenir une adresse mail valide');
                $val->set_message('min_length', 'Le champ :label doit contenir au moins 6 caractères');
                $val->set_message('max_length', 'Le champ :label doit contenir au maximum 20 caractères');        
                
                if ($val->run()) // Si tous les champs du formulaire sont valides
                {
                    $view = View::forge('base');

                    $email_in_db = User::find(array(
                        'where' => array('email' => Input::post('email')) // Recherche de l'adresse mail dans la BDD
                    ));

                    if(count($email_in_db) == 1) // Si l'adresse mail est déjà utilisée dans la BDD
                    {
                        $view->set_global('email_taken', true);
                        $view->set_global('title', 'Inscription');
                        $view->content = View::forge('user/register');
                    }
                    else
                    {
                        // Création d'un nouvel utilisateur
                        $user = User::forge()->set(array(
                            'prenom' => Input::post('prenom'),
                            'nom' => Input::post('nom'),
                            'email' => Input::post('email'),
                            'password' => Input::post('password'),
                            'date_inscription' => Date::time()->format("%Y-%m-%d %H:%M:%S")
                        ));

                        $user->save(); // Enregistrement du nouvel utilisateur dans la BDD

                        Session::set_flash('new_user', Input::post('prenom'));
                        return Response::redirect("login");
                    }

                    return Response::forge($view);
                }
                else // Sinon le formulaire contient des erreurs
                {
                    $view = View::forge('base');

                    $view->set_global('title', 'Inscription');
                    $view->set_global('errors', $val->error());
                    $view->content = View::forge('user/register');

                    return Response::forge($view);
                }
            }
            else
            {
                $view = View::forge('base');

                $view->set_global('title', 'Inscription');
                $view->content = View::forge('user/register');

                return Response::forge($view);
            }
        }
        else
        {
            return Response::redirect("/");
        }
    }

    public function action_account()
    {
        if(Session::get('user') != null)
        {
            $view = View::forge('base');
            $view->content = View::forge('user/account');

            $view->set_global('title', 'Mon compte');
            return Response::forge($view);
        }
        else
        {
            return Response::redirect("/");
        }
    }

    public function action_edit()
    {
        if(Session::get('user') != null)
        {
            $view = View::forge('base');
            $view->content = View::forge('user/account');

            $view->set_global('title', 'Mon compte');

            return Response::forge($view);
        }
        else
        {
            return Response::redirect("/");
        }
    }

    public function action_logout()
    {
        Session::destroy();
        return Response::redirect('/');
    }

    public function action_view($id)
    {
        $user_in_db = User::find(array(
            'where' => array('id' => $id) // Recherche de l'utilisateur dans la BDD
        ));

        $user = $user_in_db[0];

        $user = array(
            'prenom' => $user->prenom,
            'nom' => $user->nom,
            'email' => $user->email,
            'image_profil' => $user->image_profil,
            'date_inscription' => $user->date_inscription
        );

        $view = View::forge('base');
        $view->content = View::forge('user/user');

        $view->set_global('title', $user['prenom']." ".$user['nom']);
        $view->set_global('user', $user);

        return Response::forge($view);
    }
}