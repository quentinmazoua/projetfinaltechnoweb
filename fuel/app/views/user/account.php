<?php
echo '<br><a href="'.Router::get('account/edit').'"><button class="btn btn-primary">Editer</button></a><br><br><br>';

Asset::add_path('files', 'img');

if(Session::get('user')['user_image'] != "")
{
    echo Asset::img(Session::get('user')['user_image'], array('class' => 'img-circle', 'alt', 'profile_image', 'height' => '64px', 'width' => '64px'));
}
else
{
    echo Asset::img('default_user_image.png', array('class' => 'img-circle', 'alt', 'profile_image', 'height' => '64px', 'width' => '64px'));
}
echo '<hr>';
echo "<p>".Session::get('user')['user_firstname']."</p>";
echo "<p>".Session::get('user')['user_lastname']."</p>";
echo "<p>".Session::get('user')['user_email']."</p>";
$date = Date::create_from_string(Session::get('user')['user_date_inscription'], "%Y-%m-%d %H:%M:%S")->format("%d/%m/%Y à %H:%M:%S UTC");
echo "<p>Inscrit le ".$date;