<br>
<form action="login" method="post">
    <div class="form-group<?php if(isset($errors))
                                {
                                    if(array_key_exists("email", $errors))
                                    { echo " has-error"; }
                                }
    ?>">
        <label for="email">Adresse mail</label>
        <input name="email" type="email" class="form-control" placeholder="Email">
        <?php if(isset($errors))
              {
                if(array_key_exists("email", $errors))
                { echo '<span class="help-block">'.$errors["email"].'</span>'; }
              }
        ?>
    </div>
    <div class="form-group<?php if(isset($errors))
                                 {
                                    if(array_key_exists("password", $errors))
                                    { echo " has-error"; }
                                 }
    ?>">
        <label for="password">Mot de passe</label>
        <input name="password" type="password" class="form-control" placeholder="Mot de passe">
        <?php if(isset($errors))
              {
                if(array_key_exists("password", $errors))
                { echo '<span class="help-block">'.$errors["password"].'</span>'; }
              }
        ?>
    </div>
    <div class="checkbox">
        <label>
        <input name="rememberMe" type="checkbox"> Se rappeler de moi
        </label>
    </div>
    <button type="submit" class="btn btn-primary">Connexion</button>
    <?php if(isset($authentication_failed)){ echo "<br><br><p class='text-danger'>L'adresse mail ou le mot de passe est incorrect</p>"; }
          if(Session::get_flash('new_user', null, false) != null) { echo "<br><br><p class='text-success'>Bienvenue ".Session::get_flash('new_user', null, true).", vous pouvez vous connecter dès maintenant.</p>"; }
    ?>
</form>