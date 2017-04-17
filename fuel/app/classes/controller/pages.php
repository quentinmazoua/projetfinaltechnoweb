<?php

use \Model\User;
use \Model\Property;

class Controller_Pages extends Controller
{
	public function action_index()
	{
        return $this->action_page();
	}
	
	public function action_404()
	{
		return Response::forge(Presenter::forge('404'), 404);
	}

    public function action_page($page = 'home')
    {
        try
        {
            $view = View::forge('base');

            $view->set_global('title', ucfirst($page));
            $view->content = View::forge('pages/'.$page);

            return Response::forge($view);
        }
        catch(Exception $e)
        {
            return $this->action_404();
        }
    }

    public function action_search()
    {
        if(Input::method() === "GET")
        {
            if(Input::get('q') != "")
            {
                $q = Input::get('q');

                $search_users = User::search(Input::get('q'));
                $search_properties = Property::search(Input::get('q'));

                if(count($search_users) === 0)
                {
                    $search_users = array();
                }

                if(count($search_properties) === 0)
                {
                    $search_properties = array();
                }

                $view = View::forge('base');

                $view->set_global('title', 'Résultats de votre recherche');
                $view->set_global('query', Input::get('q'));
                $view->set_global('utilisateurs', $search_users);
                $view->set_global('proprietes', $search_properties);

                $view->content = View::forge('pages/search');

                return Response::forge($view);
            }
            else
            {
                return Response::redirect("/");
            }
        }
        else
        {
            return Response::redirect("/");
        }
    }
}