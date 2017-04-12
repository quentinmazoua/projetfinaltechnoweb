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

            return $view;
        }
        catch(Exception $e)
        {
            return $this->action_404();
        }
    }
}