<?php $title='Registrierung';
include 'inc/head.php'; 
require_once('inc/functions.php');

/*Formular zur Registrierung für neue User*/
?>

<?php
    
    $error = false;

    if(isset($_GET['register'])) {
        $blankFieldErrors=array();
        $otherErrors=array();
        
        $fname=$_POST['fname'];
        $lname=$_POST['lname'];
        $phoneNumber=$_POST['phoneNumber'];
        $email = $_POST['email'];
        $username=$_POST['username'];
        $password = $_POST['password'];
        $repeatedPassword = $_POST['repeatedPassword'];
        
        // Überprüfen ob alle Felder ausgefüllt wurden + Email in richtigem Format + Passwort gleich wie Passwort wiederholen
        if(empty($_POST['salutation']))
        {
            $blankFieldErrors[]='Anrede';
            $error=true;
        }
        else
            $salutation = $_POST['salutation'];

        if(empty($fname))
        {
            $blankFieldErrors[]='Vorname';
            $error=true;
        }
        if(empty($lname))
        {
            $blankFieldErrors[]='Nachname';
            $error=true;
        }
        if(empty($phoneNumber))
        {
            $blankFieldErrors[]='Telefon';
            $error=true;
        }
        if(empty($email))
        {
            $blankFieldErrors[]='Email';
            $error=true;
        }
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $otherErrors[] = 'Bitte eine gültige E-Mail-Adresse eingeben';
            $error = true;
        }
        if(empty($username))
        {
            $blankFieldErrors[]='Username';
            $error=true;
        }     
        if(empty($password))
        {
            $blankFieldErrors[]='Passwort';
            $error=true;
        }
        else if($password!==$repeatedPassword)
        {
            $otherErrors[]='Die Passwörter müssen übereinstimmen';
        }

        // Überprüfen ob Email schon verwendet wird
        if(!$error)
        {
            require_once('inc/dbaccess.php');
        
            $db_obj=new mysqli($host, $dbuser, $dbpassword, $database);
            $sql="SELECT * FROM person JOIN user_roles using(ur_id) WHERE email=?;";
            $stmt = $db_obj->prepare($sql);
    
            $stmt->bind_param('s',$email);
            $stmt->execute();
            $result = $stmt->get_result();
            $user=$result->fetch_array(MYSQLI_ASSOC);

            if(!empty($user))
            {
                $otherErrors[]='Diese E-Mail wird bereits verwendet';
                $error=true;
            }
        }

        //User in DB anlegen (falls es keine Fehler gab)
        if(!$error)
        {
            $hashedPw=password_hash($password, PASSWORD_DEFAULT);
            
            $sql="INSERT INTO person (salutation, firstname, lastname, tel, email, username, password, active, ur_id) VALUES (?, ?, ?, ?, ?, ?, ?, 1, 'u')";
            $stmt = $db_obj->prepare($sql);
            $stmt->bind_param("sssssss", $salutation, $fname, $lname, $phoneNumber, $email, $username, $hashedPw);
            $stmt->execute();

            if($stmt->errno!=0){
                $otherErrors= "Fehler beim Erstellen des Users";
            } else {
                $success=true;
            }
        }
    }
?>    

<body>
    <!-- Registrierungsformular -->
    <?php include 'inc/headerNav.php';?>
    <section>
        <form action="?register=1" method="POST">
            <fieldset class="contentBackground regLogFieldset">
                <legend>Registrieren</legend>
                <div class="regLeft">
                    <input type="radio" name="salutation" id="herr" value="Herr" <?php if(isset($salutation)&&$salutation==='Herr') echo 'checked' ?> style="width:auto">
                    <label for="herr">Herr</label>
                    <input type="radio" name="salutation" id="frau" value="Frau" <?php if(isset($salutation)&&$salutation==='Frau') echo 'checked' ?> style="width:auto">
                    <label for="frau">Frau</label><br>
                    <label for="fname">Vorname</label><br>
                    <input type="text" name="fname" id="fname" value = "<?php echo (isset($fname))?$fname:'';?>" placeholder="Bitte Ihren Vornamen eintragen"><br>
                    <label for="lname">Nachname</label><br>
                    <input type="text" name="lname" id="lname" value = "<?php echo (isset($lname))?$lname:'';?>" placeholder="Bitte Ihren Nachnamen eintragen"><br>
                    <label for="phoneNumber">Telefon</label><br>
                    <input type="text" name="phoneNumber" id="phoneNumber" value = "<?php echo (isset($phoneNumber))?$phoneNumber:'';?>" placeholder="+43-XXX-XXXXXXX"><br> 
                    <label for="email">E-Mail</label><br>
                    <input type="text" name="email" id="email" value = "<?php echo (isset($email))?$email:'';?>" placeholder="E-Mail" ;><br> 
                    <label for="username">Username</label><br>
                    <input type="text" name="username" id="username" value = "<?php echo (isset($username))?$username:'';?>" placeholder="Bitte Ihren Benutzernamen wählen"><br>
                    <label for="password">Passwort erstellen</label><br>
                    <input type="password" name="password" id="password"><br>
                    <label for="repeatedPassword">Passwort wiederholen</label><br>
                    <input type="password" name="repeatedPassword" id="repeatedPassword"><br> 
                    <br>
                    <button type="submit">Registrieren</button><br>

                    <?php
                        //Falls es Fehler gab:
                        if($error!== false)
                        {
                            echo '<div><p></p><p class="errorMessage">';
                            if(isset($blankFieldErrors)&&!empty($blankFieldErrors))
                            {
                                echo "Bitte folgende Felder ausfüllen:";
                                foreach($blankFieldErrors as $blankField){
                                    echo "<br>-$blankField";
                                };
                            }
                            if(!empty($otherErrors))
                            {
                                foreach($otherErrors as $error_){
                                    echo "<br>$error_";
                                };
                            }

                            echo "</p></div>";
                        }
                        //Falls das Formular erfolgreich ausgeführt und die Registrierdaten hochgeladen wurden:
                        else if(isset($success))
                        {
                            echo '<div><p></p><p class="successMessage">Erfolgreich registriert</p></div>';
                            $refreshTime = 1.5;
                            echo '<meta http-equiv="refresh" content="' . $refreshTime . ';url=login.php">';
                        }
                    ?>
                
            </div>
            <div class="regRight">
                <img src="images/fisherSmall.jpg" alt="Fischer">
                </div>
                
            </fieldset>
        </form>
    </section>
    <?php include 'inc/footer.php'; ?>
</body>

</html>