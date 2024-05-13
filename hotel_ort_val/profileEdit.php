<?php
    $title = "Profil";
    include 'inc/head.php'; 
    include 'inc/functions.php';
    checkIfLoggedIn();

    /*Profil bearbeiten für Standarduser und Admins (mit unterschiedlichen Rechten und Änderungsmöglichkeiten)*/
?>


<?php
    $showForm=true;
    $error=false;

    //Wenn das "Update"-Formular ausgeführt worden ist
    if(isset($_GET['update']))        
    {
        $blankFieldErrors=array();
        
        //Variablen werden durch POST-Variablen gesetzt
        $email=$_POST['email'];
        $fname=$_POST['fname'];
        $lname=$_POST['lname'];
        $phoneNumber=$_POST['tel'];
        $username=$_POST['username'];
        $salutation = $_POST['salutation'];

        if($_SESSION['loggedRole']=='a')
        {
            $password = $_POST['password'];
            $active=$_POST['isActive'];                         //role und Userstatus muss gesetzt sein, da man die Radiobuttonlist nicht wegklicken kann
            $role=$_POST['role'];
        }
        
        //Überprüfen ob alle Felder ausgefüllt wurden + Email in richtigem Format + Passwort gleich wie Passwort wiederholen

        if(empty($fname))
        {
            $blankFieldErrors[]='Vorname';
            $error=true;
        }
        if(empty($lname))
        {
            $blankFieldErrors[]='Nachname';             //wenn Vorname, Nachname, Telefonnummer oder Username leer ist, kann der User nicht geupdatet werden
            $error=true;
        }
        if(empty($phoneNumber))
        {
            $blankFieldErrors[]='Telefon';
            $error=true;
        }
        if(empty($username))
        {
            $blankFieldErrors[]='Username';
            $error=true;
        }
        
        if($_SESSION['loggedRole']=='a')
        {
            if(empty($password))                            //wenn Passwort leer bleibt, wird es nicht geupdatet, sonst schon.
            {
                $updatePw=false;
            }
            else
                $updatePw=true;
        }


        // User in DB aktualisieren
        if(!$error)
        {
            require_once('inc/dbaccess.php');
        
            $db_obj=new mysqli($host, $dbuser, $dbpassword, $database);
            
            //Unterscheidung des SQL-Statements: ob aktueller User Admin ist oder nicht -> ein Admin kann auch ein Passwort ändern, ein Standarduser nicht

            //Falls Standarduser
            if($_SESSION['loggedRole']=='u')
            {
                $sql='UPDATE person SET salutation=?, firstname=?, lastname=?, tel=?, username=? WHERE email=?';
                $stmt = $db_obj->prepare($sql);
                $stmt->bind_param("ssssss", $salutation, $fname, $lname, $phoneNumber, $username, $email);
            }
            //Sonst Admin
            else
            {
                //Admin-Login -> Passwort wird geändert
                if($updatePw)
                {
                    $hashedPw=password_hash($password, PASSWORD_DEFAULT);
                    $sql='UPDATE person SET salutation=?, firstname=?, lastname=?, tel=?, username=?, password=?, active=?, ur_id=?  WHERE email=?';    
                    $stmt = $db_obj->prepare($sql);
                    $stmt->bind_param("ssssssiss", $salutation, $fname, $lname, $phoneNumber, $username, $hashedPw, $active, $role, $email);
                }
                //Admin-Login -> andere Stammdaten werden geändert
                else
                {
                    $sql='UPDATE person SET salutation=?, firstname=?, lastname=?, tel=?, username=?, active=?, ur_id=?  WHERE email=?';    
                    $stmt = $db_obj->prepare($sql);
                    $stmt->bind_param("sssssiss", $salutation, $fname, $lname, $phoneNumber, $username, $active, $role, $email);
                }
            }
            
            //Ausführung des SQL-Statements
            $stmt->execute();
            if($stmt->affected_rows==1)
            {
                $successMessage='Erfolgreich aktualisiert';
                //Session-Variablen werden geupdatet abhängig von den neuen Variablenwerten:
                if($_SESSION['user']['email']==$email)
                {
                    if($_SESSION['loggedRole']=='a')
                    {
                        $_SESSION['user']['ur_id']=$role;
                        $_SESSION['loggedRole']=$role;
                        $_SESSION['active']=$active;
                        if($active==0)
                            header('Location: inc/logout.php');
                    }
                    $_SESSION['user']['salutation']=$salutation;
                    $_SESSION['user']['firstname']=$fname;
                    $_SESSION['user']['lastname']=$lname;
                    $_SESSION['user']['tel']=$phoneNumber;
                    $_SESSION['user']['username']=$username;
                }
                $showForm=false;
            }
            else if($stmt->affected_rows==0)
                $errorMessage='Es wurde nichts aktualisiert';
            else
                $errorMessage='Fehler beim Aktualisieren: ' . $stmt->affected_rows . ' rows affectted';
        }
        else
            $errorMessage='Bitte alle Felder ausfüllen';
    }

    //Daten werden in das Formular aus der Datenbank geladen (!falls man als User oder Admin eingeloggt ist!)
    else if(isset($_SESSION['loggedRole']) && $_SESSION['loggedRole'] ==='a'
        || isset($_SESSION['user']['pers_id']) && $_SESSION['user']['pers_id'] == $_GET['pers_id'])     
    {
        $user=$_GET['pers_id'];

        require_once('inc/dbaccess.php');
        
        $db_obj=new mysqli($host, $dbuser, $dbpassword, $database);
    
        $sqlGetRoom="   SELECT salutation, firstname, lastname, tel, email, username, active, ur_id from person
                        WHERE pers_id=?";
    
        $stmt = $db_obj->prepare($sqlGetRoom);
    
        $stmt->bind_param('i',$user);
        $stmt->execute();
        $result=$stmt->bind_result($salutation, $fname, $lname, $phoneNumber, $email, $username, $active, $role);
        $stmt->fetch();
        $stmt->close();
    }
    else
    {
        $showForm=false;
        $errorMessage='Ihnen fehlen die nötigen Administrator-Rechte für diese Aktion.';
    }

?>
<body>
    <?php include 'inc/headerNav.php';?>

    <section>
        <div class = "contentBackground">
            <!-- Formular wird angezeigt wenn man berechtigt ist bis eine erfolgreiche Änderung vorgenommen wurde-->
            <?php if($showForm)
            {
            ?>
            
                <h2>Daten ändern</h2>

                <form action="?update=1" method="POST">

                    <label for="email">Email</label><br>
                    <input type="text" name="email" id="email" readonly="readonly" value = "<?php echo $email ?>"> [kann nicht verändert werden]<br><br><br>
                    <input type="radio" name="salutation" id="herr" value="Herr" <?php if($salutation==='Herr') echo 'checked' ?> style="width:auto">
                    <label for="herr">Herr</label>
                    <input type="radio" name="salutation" id="frau" value="Frau" <?php if($salutation==='Frau') echo 'checked' ?> style="width:auto">
                    <label for="frau">Frau</label><br>
                    <label for="fname">Vorname</label><br>
                    <input type="text" name="fname" id="fname" value = "<?php echo $fname ?>"><br>
                    <label for="lname">Nachname</label><br>
                    <input type="text" name="lname" id="lname" value = "<?php echo $lname ?>"><br>
                    <label for="tel">Telefon</label><br>
                    <input type="text" name="tel" id="tel" value = "<?php echo $phoneNumber ?>"><br>
                    <label for="username">Username</label><br>
                    <input type="text" name="username" id="username" value = "<?php echo $username ?>">
                    <br>
                    <?php
                    if($_SESSION['loggedRole']==='a'){?>
                        <label for="password">Passwort</label><br>
                        <input type="password" name="password" id="password"><br><br>
                        Userstatus: 
                        <input type="radio" name="isActive" id="active" value=1 <?php if($active) echo 'checked' ?> style="width:auto">
                        <label for="active">Aktiv</label>
                        <input type="radio" name="isActive" id="inactive" value=0 <?php if(!$active) echo 'checked' ?> style="width:auto">
                        <label for="inactive">Inaktiv</label><br><br>
                        Rolle: 
                        <input type="radio" name="role" id="admin" value='a' <?php if($role=='a') echo 'checked' ?> style="width:auto">
                        <label for="admin">Admin</label>
                        <input type="radio" name="role" id="user" value='u' <?php if($role=='u') echo 'checked' ?> style="width:auto">
                        <label for="user">User</label><br>
                    <?php 
                        }
                    ?>
                    <br><button type="submit">Aktualisieren</button><br>
                </form>

            <?php }

            //Falls es zu Fehlermeldung kommt / oder es richtig ausgeführt wurde, entsprechende Meldung
            if(isset($errorMessage))
            {
                echo '<p class="errorMessage">' . $errorMessage . '</p>' ;
            }

            if(isset($successMessage))
            {
                echo '<p class="successMessage">' . $successMessage . '</p>';
                echo '<a href="index.php">Startseite</a>';
            }
            ?>
            
        </div>
    </section>


    <?php include 'inc/footer.php';?>
</body>
</html>
    