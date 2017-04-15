<?php
echo "<br>";
if($user['image_profil'] != "")
{
    echo Asset::img($user['image_profil'], array('class' => 'img-circle', 'alt', 'profile_image', 'height' => '64px', 'width' => '64px'));
}
else
{
    echo Asset::img('default_user_image.png', array('class' => 'img-circle', 'alt', 'profile_image', 'height' => '64px', 'width' => '64px'));
}
echo '<hr>';
echo "<p>".$user['prenom']."</p>";
echo "<p>".$user['nom']."</p>";
echo "<p>".$user['email']."</p>";
$date = Date::create_from_string($user['date_inscription'], "%Y-%m-%d %H:%M:%S")->format("%d/%m/%Y à %H:%M:%S UTC");
echo "<p>Inscrit le ".$date."</p>";