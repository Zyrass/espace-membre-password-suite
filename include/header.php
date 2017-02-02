        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#myMenu" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php">Espace-membre.dev</a>
                    <p class="navbar-text text-primary">[section : home]</p>
                </div>

                <div class="collapse navbar-collapse" id="myMenu">
                    <ul class="nav navbar-nav navbar-right">
                    <?php if (isset($_SESSION['id'])) : // Si il existe une $_SESSION['id'], on affiche les 2 premiers menu ?>
                        <li class="nav-item">
                            <a class="nav-link" href="compte.php"><span class="glyphicon glyphicon-user"></span> Compte</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="deconnexion.php"><span class="glyphicon glyphicon-log-out"></span> Déconnexion</a>
                        </li>
                    <?php else : // Sinon si il n'existe pas de $_SESSION['id'] on affiche les 2 autres menu ?>
                        <li class="nav-item">
                            <a class="nav-link" href="inscription.php"><span class="glyphicon glyphicon-pencil"></span> Inscription</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="connexion.php"><span class="glyphicon glyphicon-log-in"></span> Connexion</a>
                        </li>
                    <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>