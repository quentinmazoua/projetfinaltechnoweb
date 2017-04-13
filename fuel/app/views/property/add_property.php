<form action=<?php echo Router::get("property/add")." "?> method="post">
    <div class="form-group<?php if(isset($errors))
                                {
                                    if(array_key_exists("adresse", $errors))
                                    { echo " has-error"; }
                                }
    ?>">
        <label for="adresse">Adresse</label>
        <input name="adresse" type="text" class="form-control" placeholder="Adresse">
        <?php if(isset($errors))
              {
                if(array_key_exists("adresse", $errors))
                { echo '<span class="help-block">'.$errors["adresse"].'</span>'; }
              }
        ?>
    </div>
    <?php echo $selectCountry ?>
    <div class="form-group<?php if(isset($errors))
                                 {
                                    if(array_key_exists("ville", $errors))
                                    { echo " has-error"; }
                                 }
    ?>">
        <label for="ville">Ville</label>
        <input name="ville" type="text" class="form-control" placeholder="Ville">
        <?php if(isset($errors))
              {
                if(array_key_exists("ville", $errors))
                { echo '<span class="help-block">'.$errors["ville"].'</span>'; }
              }
        ?>
    </div>
    <button type="submit" class="btn btn-primary">Publier</button>
</form>