<?php if(Session::get_flash('errors', null, false) != null)
      {
        $errors = Session::get_flash('errors', null, true);
      }
?>
<br>
<form action="<?php echo Router::get("rental/add");?>" method="post" class="form-horizontal">
  <div class="form-group">
    <label class="col-sm-1 control-label">Nom</label>
    <div class="col-sm-10">
      <p class="form-control-static"><?php echo $propriete['nom']; ?></p>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-1 control-label">Adresse</label>
    <div class="col-sm-10">
      <p class="form-control-static"><?php echo $propriete['adresse']; ?></p>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-1 control-label">Pays</label>
    <div class="col-sm-10">
      <p class="form-control-static"><?php echo $propriete['pays']; ?></p>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-1 control-label">Ville</label>
    <div class="col-sm-10">
      <p class="form-control-static"><?php echo $propriete['ville']; ?></p>
    </div>
  </div>
  <div class="form-group">
        <label class="col-sm-1 control-label">Propriétaire</label>
        <div class="col-sm-10">
            <p class="form-control-static"><a href="<?php echo Router::get('view_user', array($proprietaire['id']));?>"><?php echo $proprietaire['prenom']." ".$proprietaire['nom']; ?></a></p>
        </div>
  </div>
<br>
  <div class="form-group<?php if(isset($errors))
                                 {
                                    if(array_key_exists("date_sejour", $errors))
                                    { echo " has-error"; }
                                 }
    ?>">
        <label for="date_sejour">Date du séjour</label>
        <input name="date_sejour" type="date" class="form-control" <?php echo 'value="'.date("Y-m-d").'"';?>>
        <?php if(isset($errors))
              {
                if(array_key_exists("date_sejour", $errors))
                { echo '<span class="help-block">'.$errors["date_sejour"].'</span>'; }
              }
        ?>
  </div>
  <div class="form-group<?php if(isset($errors))
                                 {
                                    if(array_key_exists("duree_sejour", $errors))
                                    { echo " has-error"; }
                                 }
    ?>">
        <label for="duree_sejour">Durée du séjour (nuits)</label>
        <input name="duree_sejour" type="number" min="1" max="30" class="form-control" value="1">
        <?php if(isset($errors))
              {
                if(array_key_exists("duree_sejour", $errors))
                { echo '<span class="help-block">'.$errors["duree_sejour"].'</span>'; }
              }
        ?>
  </div>
  <input name="id_propriete" type="hidden" value="<?php echo $propriete['id'];?>">
  <button type="submit" class="btn btn-primary">Envoyer</button>
  <?php if(Session::get_flash('not-available', null, false) != null) 
        {
            echo "<br><br><p class='text-danger'>Cette propriété est déjà occupée pendant la période souhaitée, veuillez choisir une autre date.</p>";
        }
  ?>
</form>