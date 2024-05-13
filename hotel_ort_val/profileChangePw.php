<?php
    $title = "Passwort ändern";
    include 'inc/head.php'; 
    include 'inc/functions.php';
    checkIfLoggedIn();

    /*Formular zum Ändern des Passwortes  */
?>

<?php 
    $showForm=true;

    //Falls das Formular ausgeführt worden ist:
    if(isset($_GET['change']))
    {
        $error;
        $oldPw=$_POST['oldPassword'];
        $newPw=$_POST['newPassword'];
        $newPwRepeat=$_POST['newPasswordRepeat'];

        if(isset($oldPw)&&isset($newPw))
        {
            require_once('inc/dbaccess.php');
    
            $db_obj=new mysqli($host, $dbuser, $dbpassword, $database);
            $getPw=$db_obj->query('SELECT password FROM person WHERE pers_id='  . $_SESSION['user']['pers_id'] .';')->fetch_column();

            //Falls das eingegebene alte Passwort (-Hashwert) dem Datenbank-Passwort-Hash entspricht kann ein neues Passwort gesetzt werden
            if(password_verify($oldPw, $getPw))
            {
                if($newPw===$newPwRepeat)
                {
                    //Hashwert wird von neuem Passwort kalkuliert und gesetzt
                    $hashedPw=password_hash($newPw, PASSWORD_DEFAULT);
                    
                    //Ergebnis wird in Datenbank gespeichert
                    $sql='UPDATE person SET password=? WHERE pers_id=?';
                    $stmt = $db_obj->prepare($sql);
                    $stmt->bind_param('si',$hashedPw, $_SESSION['user']['pers_id']);
                    $stmt->execute();

                    if($stmt->affected_rows==1)
                    {
                        $successMessage='Passwort wurde erfolgreich geändert';
                        $showForm=false;
                    }
                    else
                        $error='Fehler beim Ändern des Passworts';
                }
                else
                    $error='"Neues Passwort" und "Neues Passwort wiederholen" stimmt nicht überein';
            }
            else
                $error='Altes Passwort ist falsch';

            $stmt->free_result();
            $db_obj->close();
        }
    }

?>

<body>
    <?php include 'inc/headerNav.php';?>

    <!-- Formular zur Passwort-Änderung-->
    <section>
        <div class = "contentBackground">
            <?php 
            if($showForm)
            { ?>
                <h2>Passwort ändern</h2>
                <form action="?change=1" method="POST">
                    <label for="oldPassword">Altes Passwort: </label><br>
                    <input type="password" name="oldPassword" id="oldPassword"><br><br>
                    <label for="newPassword">Neues Passwort</label><br>
                    <input type="password" name="newPassword" id="newPassword"><br><br>
                    <label for="newPasswordRepeat">Neues Passwort widerholen</label><br>
                    <input type="password" name="newPasswordRepeat" id="newPasswordRepeat"><br><br>
                    <button type="submit">Passwort ändern</button><br>
                </form>
            <?php 
                if(isset($error))
                {
                        echo '<p class="errorMessage">' . $error . '</p>';
                }
            }
            if(isset($successMessage))
            {
                echo '<p class="successMessage">' . $successMessage . '</p>';
                //Rückleitung zur Startseite nach 1,5s
                echo '<script type="text/javascript">setTimeout(function(){ window.location.href = "index.php"; }, 1500);</script>';
            }
            ?>
        </div>
    </section>


    <?php include 'inc/footer.php';?>
</body>
</html>
    