    <footer>
        <div class="footerLogo">
            Hotel Tschempern
        </div>
        <div class="footerCopyright">
            ©Tschempern 2023
        </div>
        <div class="footerLinks">
            <ul>
                <?php
                    if((isset($_SESSION['loggedRole']))){
                        echo '<li class="logoutLink"><a href = "inc/logout.php">Ausloggen (' . $_SESSION['user']['username'] . ')</a></li>';
                    }
                ?>
                <li class="otherLinks"><a href="help.php">Hilfe</a></li>
                <li class="otherLinks"><a href="impressum.php">Impressum</a></li>
                <li class="otherLinks"><a href="index.php"><img class="homeButton" src="images/homeButton.png" alt="Startseite"></a>
                
            </ul>
        </div>
    </footer>
</div>