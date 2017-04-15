<?php

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
                $view = View::forge('base');

                $view->set_global('title', 'Résultats de votre recherche');
                $view->set_global('query', Input::get('q'));
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