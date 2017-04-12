<!DOCTYPE html>
<html>

    <head>
        <title>Property Manager - <?php echo $title ?></title>
        
        <?php 
        echo Asset::css('bootstrap.min.css');
        echo Asset::css('style.css'); 
        ?>

    </head>

    <body>
        <nav>
            <a href="#" class="menu-trigger">Menu</a>
            <ul>
                <li><a href="/">Accueil</a></li>
                <?php if(Session::get('user') != null)
                {
                    echo '<li><a href='.Router::get("mon-compte").'>Mon compte</a></li>';
                    echo '<li><a href='.Router::get("mes-proprietes").'>Mes propriétés</a></li>';
                    echo '<li><a href='.Router::get("mes-locations").'>Mes locations</a></li>';
                    echo '<li><a href='.Router::get("deconnexion").'>Déconnexion</a></li>';
                }
                else
                {
                    echo '<li><a href='.Router::get("login").'>Connexion</a></li>';
                    echo '<li><a href='.Router::get("register").'>Inscription</a></li>';
                }
                echo '<li><a href='.Router::get('page_any', array('contact')).'>Contact</a></li>';// Route vers page/contact (page_any est le nom de la route, contact est le parametre $1)
                echo '<li><form action="search" method="get"><input name="q" type="text" placeholder="Recherche">&nbsp;<button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button></form></li>';
                ?>
            </ul>
        </nav>
        <div class="container">
            <?php echo $content; ?>
        </div>
    </body>
</html>