<?php

echo "<p>".Session::get('user')['user_firstname']."</p>";
echo "<p>".Session::get('user')['user_lastname']."</p>";
echo "<p>".Session::get('user')['user_email']."</p>";