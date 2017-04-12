<p><?php if(Session::get('user') != null)
      {
      	echo 'Bonjour '.Session::get('user')['user_firstname'].", ";
      }
?>Ceci est la page d'accueil</p>