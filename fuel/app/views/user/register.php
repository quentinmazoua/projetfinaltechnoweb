<form action="register" method="post">
    <div class="form-group<?php if(isset($errors))
                                {
                                    if(array_key_exists("prenom", $errors))
                                    { echo " has-error"; }
                                }
    ?>">
        <label for="prenom">Prénom</label>
        <input name="prenom" type="text" class="form-control" placeholder="Prénom">
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
        <input name="nom" type="text" class="form-control" placeholder="Nom">
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
        <label for="password">Password</label>
        <input name="password" type="password" class="form-control" placeholder="Mot de passe">
        <?php if(isset($errors))
              {
                if(array_key_exists("password", $errors))
                { echo '<span class="help-block">'.$errors["password"].'</span>'; }
              }
        ?>
    </div>
    <button type="submit" class="btn btn-primary">Inscription</button>
    <?php if(isset($email_taken))
          {
              echo "<br><br><p class='text-danger'>Cette adresse mail est déjà utilisée</p>";
          }
    ?>
</form>