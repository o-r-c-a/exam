<? session_start(); ?>
<div id="wrapper">
    <div id="topDiv">
        <header>
                <h1>Hotel Tschempern</h1>
        </header>
        <nav>
            <ul>
                <li><a href="index.php">Startseite</a></li>
                <li><a href="newsMain.php">News</a></li>
                <li><a href="reservationRooms.php">Zimmer </a></li>
                <?php
                if(!(isset($_SESSION["loggedRole"]))) {
                    //Nicht eingeloggter User: Registrieren & Einloggen
                    echo'
                    <li><a href="register.php">Registrieren</a></li>
                    <li><a href="login.php">Login</a></li>';
                }
                else if(isset($_SESSION["loggedRole"]) and $_SESSION["loggedRole"] === 'a'){
                    //Admins können User und Registrierungen verwalten
                    echo'
                    <li><a href="adminShowUser.php">Userverwaltung</a></li>
                    <li><a href="adminShowRes.php">Reservierungsverwaltung</a></li>';
                }
                else if(isset($_SESSION["loggedRole"])){
                    //Eingeloggte Standarduser haben Zugriff auf Profilübersicht
                    echo '
                    <li><a href="profileMain.php">Profil</a></li>';
                }
                ?>    
            </ul>
        </nav>
    </div>