<?php

//use \Model\Rental;

class Controller_Rental extends Controller
{

    public function action_rentals()
    {
        if(Session::get('user') != null)
        {
            $view = View::forge('base');
            $view->content = View::forge('rental/rentals');

            $view->set_global('title', 'Mes locations');

            return Response::forge($view);
        }
        else
        {
            return Response::redirect("/");
        }
    }
}