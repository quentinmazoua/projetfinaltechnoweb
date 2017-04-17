<br>
<p>Votre précédent commentaire, s'il existe, sera remplacé.</p>
<form action="<?php echo Uri::current();?>" method="post">
    <div class="form-group">
        <label for="note">Note</label>
        <div id="note" data-score="0"></div>
    </div>
    <div class="form-group<?php if(isset($errors))
                                 {
                                    if(array_key_exists("texte", $errors))
                                    { echo " has-error"; }
                                 }
    ?>">
        <label for="texte">Commentaire</label>
        <textarea name="texte" class="form-control" placeholder="Votre commentaire"></textarea>
        <?php if(isset($errors))
              {
                if(array_key_exists("texte", $errors))
                { echo '<span class="help-block">'.$errors["texte"].'</span>'; }
              }
        ?>
    </div>
    <button type="submit" class="btn btn-primary">Publier</button>
</form>

<?php
    echo Asset::js('jquery-3.1.1.min.js');
    echo Asset::css('jquery.raty.css');
    echo Asset::js('jquery.raty.js');
?>

<script>
    $(document).ready(function() 
    {
        $("#note").raty({ 
            readOnly  : false,
            starOff   : 'http://projetfinal/assets/img/star-off.png',
            starOn    : 'http://projetfinal/assets/img/star-on.png' ,
            score     : function() {
            return $(this).attr('data-score');
            }
        });
    });
</script>