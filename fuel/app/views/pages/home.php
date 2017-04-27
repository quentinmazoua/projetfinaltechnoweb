<br>
<p><?php if(Session::get('user') != null)
      {
      	echo 'Bonjour '.Session::get('user')['user_firstname'].", ";
      }
?>Ceci est la page d'accueil</p><br>
<?php
echo '<div class="fotorama" data-width="600" data-height="400">';
      Asset::add_path('files', 'img');
      
      if(isset($photos))
      {
            foreach($photos as $photo)
            {
                  echo Asset::img($photo["path"]);
            }
      }
      
      echo '</div>';
      echo '<br><br>';

echo Asset::css('fotorama.css');
echo Asset::js('jquery-3.1.1.min.js');
echo Asset::js('fotorama.js');

?>