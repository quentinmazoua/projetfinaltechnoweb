<br>
<form <?php echo 'enctype="multipart/form-data" ';?> action=<?php echo Router::get("property/add")." "?> method="post">
    <div class="form-group<?php if(isset($errors))
                                {
                                    if(array_key_exists("nom", $errors))
                                    { echo " has-error"; }
                                }
    ?>">
        <label for="nom">Nom</label>
        <input name="nom" type="text" class="form-control" placeholder="Nom (Ex.: Maison)">
        <?php if(isset($errors))
              {
                if(array_key_exists("nom", $errors))
                { echo '<span class="help-block">'.$errors["nom"].'</span>'; }
              }
        ?>
    </div>
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
    <div class="row">
        <div class="col-md-3">
            <div class="checkbox">
                <label>
                <input name="preference_animaux" type="checkbox"> Animaux domestiques autorisés
                </label>
            </div>
        </div>
        <div class="col-md-2">
            <div class="checkbox">
                <label>
                <input name="preference_cigarettes" type="checkbox">  Autorisation de fumer
                </label>
            </div>
        </div>
    </div>
    <br>
    <div class="form-group">
        <label for="file_photo">Joindre des photos (max. 20)
        <input type="hidden" name="MAX_FILE_SIZE" value="10000000"/>
        <input name ="file_photo" id="file_photo" type="file" class="form-control" accept="image/*" multiple>
    </div>
    <br>
    <button type="submit" class="btn btn-primary">Enregistrer</button>
</form>