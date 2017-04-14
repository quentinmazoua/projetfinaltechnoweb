<?php

/**
 * The welcome 404 presenter.
 *
 * @package  app
 * @extends  Presenter
 */
class Presenter_404 extends Presenter
{
	/**
	 * Prepare the view data, keeping this in here helps clean up
	 * the controller.
	 *
	 * @return void
	 */
	public function view()
	{
		$messages = array('Oups', 'Erreur', 'Oh Oh!', 'Non, pas ici.', 'Hum?');
		$this->title = $messages[array_rand($messages)];
	}
}
