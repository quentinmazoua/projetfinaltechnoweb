<br>
<form <?php echo 'enctype="multipart/form-data" '; ?> action="<?php echo Router::get("account/edit");?>" method="post">
<div class="row">
    <div class="col-md-2">
<?php
if(Session::get('user')['user_image'] != "")
{
    echo Asset::img(Session::get('user')['user_image'], array('class' => 'img-circle', 'alt', 'profile_image', 'height' => '64px', 'width' => '64px'));
}
else
{
    echo Asset::img('default_user_image.png', array('class' => 'img-circle', 'alt', 'profile_image', 'height' => '64px', 'width' => '64px'));
}
?>
</div>
<div class="col-md-4">
<input name="image_profile" type="file" style="position:absolute;right:230px;top:40px;">
</div>
</div>
<br><br>
    <div class="form-group<?php if(isset($errors))
                                {
                                    if(array_key_exists("prenom", $errors))
                                    { echo " has-error"; }
                                }
    ?>">
        <label for="prenom">Prénom</label>
        <input name="prenom" type="text" class="form-control" placeholder="Prénom" value="<?php echo Session::get('user')['user_firstname'];?>">
        <?php if(isset($errors))
              {
                if(array_key_exists("prenom", $errors))
                { echo '<span class="help-block">'.$errors["prenom"].'</span>'; }
              }
        ?>
    </div>
    <div class="form-group<?php if(isset($errors))
                                {
                                    if(array_key_exists("nom", $errors))
                                    { echo " has-error"; }
                                }
    ?>">
        <label for="nom">Nom</label>
        <input name="nom" type="text" class="form-control" placeholder="Nom" value="<?php echo Session::get('user')['user_lastname'];?>">
        <?php if(isset($errors))
              {
                if(array_key_exists("nom", $errors))
                { echo '<span class="help-block">'.$errors["nom"].'</span>'; }
              }
        ?>
    </div>
    <div class="form-group<?php if(isset($errors))
                                {
                                    if(array_key_exists("email", $errors))
                                    { echo " has-error"; }
                                }
    ?>">
        <label for="email">Adresse mail</label>
        <input name="email" type="email" class="form-control" placeholder="Email" value="<?php echo Session::get('user')['user_email'];?>">
        <?php if(isset($errors))
              {
                if(array_key_exists("email", $errors))
                { echo '<span class="help-block">'.$errors["email"].'</span>'; }
              }
        ?>
    </div>
    <button type="submit" class="btn btn-primary">Enregistrer</button>
    <?php if(isset($email_taken))
          {
              echo "<br><br><p class='text-danger'>Cette adresse mail est déjà utilisée</p>";
          }
          if(isset($upload_error))
          {
              echo "<br><br><p class='text-danger'>Une erreur est survenue lors de l'envoi de l'image.</p>";
          }
    ?>
    </form>