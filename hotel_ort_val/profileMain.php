<?php
    $title = "Profil";
    include 'inc/head.php'; 
    include 'inc/functions.php';
    checkIfLoggedIn();

    /*Anzeige des Profils für Standarduser -> Admins haben die Userverwaltungsübersicht aller User in der Datenbank 
    (über welches sie auch ihre eigenen Daten ändern können)*/
?>

<body>
    <?php include 'inc/headerNav.php';?>

    <section>
        <div class = "contentBackground">
            <h2>Mein Profil</h2>
        
            <div>
                <h3>Allgemeine Informationen</h3>
                <table>
                    <tr>
                        <td>Name: </td>
                        <td><?php echo $_SESSION['user']['firstname'] . ' ' . $_SESSION['user']['lastname']?></td>
                    </tr>
                    <tr> 
                        <td>Anrede: </td>
                        <td><?php echo $_SESSION['user']['salutation']?></td>
                    </tr>
                    <tr>
                        <td>Username: </td>
                        <td><?php echo $_SESSION['user']['username']?></td>
                    </tr>
                </table>
            </div>

            <div>
                <h3>Kontaktdaten</h3>
                <table>
                    <tr>
                        <td>E-Mail: </td>
                        <td><?php echo $_SESSION['user']['email']?></td>
                    </tr>
                    <tr>
                        <td>Telefon: </td>
                        <td><?php echo $_SESSION['user']['tel']?></td>
                    </tr>
                </table>
            </div>

            <div>
                <h3>Weitere Optionen</h3>
                <table>
                    <tr>
                        <td>Passwort: </td>
                        <td><a href="profileChangePw.php">Passwort ändern</a></td>
                    </tr>
                    <tr>
                        <td>Daten: </td>
                        <td><a href="profileEdit.php?pers_id=<?php echo $_SESSION['user']['pers_id']?>">Daten ändern</a></td>
                    </tr>
                    <tr>
                        <td>Reservierungen: </td>
                        <td><a href="profileMyReservations.php">Meine Reservierungen</a></td>
                    </tr>
                    <tr>
                        <td><br></td>
                    </tr>
                    <tr>
                        <td><a href="profileChangePw.php">Ausloggen</a>
                    </tr>
                </table>
            </div>
        </div>
    </section>


    <?php include 'inc/footer.php';?>
</body>
</html>
    