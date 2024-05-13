<?php $title='Login';  
include 'inc/head.php'; 
require 'inc/functions.php';

/*Formular zum Einloggen für registrierte User*/
?>

<body>
    <?php 
        include 'inc/headerNav.php';

        if(isset($_GET['login'])) {
            $password=$_POST["password"];
            $email = $_POST["email"];

            //$errors=array();
            if(isset($password)&&isset($email))
            {
                require_once('inc/dbaccess.php');
    
                $db_obj=new mysqli($host, $dbuser, $dbpassword, $database);
                $sql="SELECT * FROM person JOIN user_roles using(ur_id) WHERE email=?;";
                $stmt = $db_obj->prepare($sql);
    
                $stmt->bind_param('s',$email);  //s -> string, i -> integer, d -> double, b -> blob
                $stmt->execute();
                $result = $stmt->get_result();
                $user=$result->fetch_array(MYSQLI_ASSOC); //fetch_array gibt null zurück, wenn kein Datensatz gefunden wurde
                            //fetch_array(MYSQLI_ASSOC) is the same as fetch_assoc()
                if (isset($user)) {
                    if($user['active']==false)
                    {
                        $errors="Ihr Account ist leider deaktiviert - bitte wenden Sie sich an den Support.";
                    }
                    else if(password_verify($password, $user["password"])) // verifies given pw with hashed pw from db
                    {
                        $_SESSION['user'] = $user;
                        $_SESSION['loggedRole']=$user['ur_id'];
                        header('location: index.php');
                    }
                    else
                    {
                        $errors="Email oder Passwort sind ungültig.";
                    }
                }
                else
                {
                    $errors="Email oder Passwort sind ungültig.";
                }
            }
            else
            {
                $errors = "Bitte geben Sie Email und Passwort ein.";
            }
        }
    ?>
    <section>
        <form action="?login=1" method="POST"> 
            <fieldset class="contentBackground regLogFieldset">
                <legend>Login</legend>
                <label for="email">E-Mail</label><br>
                <input type="email" name="email" id="input_email" placeholder="E-Mail"><br>
                <label for="password">Passwort</label><br>
                <input type="password" name="password" id="input_password" placeholder="Password"><br>
                <br>
                <button type="submit">Einloggen</button>
            
            <?php
                    if(!empty($errors))
                    {
                        echo '<p class="errorMessage">'. $errors .'</p>';
                    }
                ?>
            </fieldset>
        </form>
    </section>
    <?php include 'inc/footer.php'; ?>
</body>

</html>