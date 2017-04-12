<form action=/page/contact method="post">
  <div class="form-group">
    <label for="email">Adresse mail</label>
    <input name="email" type="email" class="form-control" placeholder="Email" <?php if(Session::get('user') != null)
                                                                                    {
                                                                                        echo ' value="'.Session::get('user')['user_email'].'"';
                                                                                    } 
    ?>>
  </div>
  <div class="form-group">
    <label for="message">Message</label>
    <textarea name="message" class="form-control" rows="4"></textarea>
  </div>
  <button type="submit" class="btn btn-primary">Envoyer</button>
</form>