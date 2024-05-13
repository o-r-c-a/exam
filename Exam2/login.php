<!DOCTYPE html>
<html lang="de">

<?php
    include 'head.php';
?>

<body>
    <?php
    include 'navbar.php';
    ?>

    <header>
        <div class="container jumbotron">
            <br>
            <h1 class="display-5">Login</h1>
        </div>
    </header>
    <main>
        <div class="container form-signin login">

            <?php
            // Prepare empty message variable
            $msg = '';

            // Check if username and password are set
            if (
                isset($_POST['login']) && !empty($_POST['username'])
                && !empty($_POST['password'])
            ) {

                require_once('dbaccess.php');
                $db_obj = new mysqli($host, $dbuser, $dbpassword, $database);

                if ($db_obj->connect_error) {
                    echo "Connection Error: " . $db_obj->connect_error;
                    exit();
                }
            
                $sql="SELECT * FROM admins WHERE uname = ?;";
                
                $stmt = $db_obj->prepare($sql);
                
                $stmt->bind_param('s', $_POST['username']);  //s -> string, i -> integer, d -> double, b -> blob
                //  couldve first bind_param() then defined the $variables
                $stmt->execute();
                $result = $stmt->get_result();
                $user = $result->fetch_assoc();
            
                if($user){
            
                    if($_POST['password'] == $user['passwd']){
                        $_SESSION['userID'] = $user['id'];
                        $_SESSION['login_time'] = time();
                        $msg = 'Login successful!';
                        header('Location: add.php');
                    }
                }
                $stmt2->close(); 
            $db_obj->close();

                // Check username and password combination, set message and forward the user to add-page if they match
                // if (
                //     $_POST['username'] == 'christina' &&
                //     $_POST['password'] == 'chrissy95'
                // ) {
                //     $_SESSION['userID'] = '17';
                //     $_SESSION['login_time'] = time();
                //     $msg = 'Login successful!';
                //     header('Location: add.php');
                // }
                
                // else if (
                //     $_POST['username'] == 'joseph' &&
                //     $_POST['password'] == 'joey93'
                // ) {
                //     $_SESSION['userID'] = '21';
                //     $_SESSION['login_time'] = time();
                //     $msg = 'Login successful!';
                //     header('Location: add.php');
                // } else {
                //     $msg = 'Wrong username or password!';
                // }
            }
            
            // Check if "Stay logged in!" has been ticked
            if (@$_POST['safeit'] == '1') {
                $logincookieduration = 31536000; //valid for 1 year
                setcookie("userID", $_SESSION['userID'], time() + $logincookieduration);
                setcookie("username", $_POST['username'], time() + $logincookieduration);
                setcookie("password", $_POST['password'], time() + $logincookieduration);
                setcookie("logincookie", $logincookieduration, time() + $logincookieduration);
            }

            ?>

        </div>

        <!--Login form-->
        <div class="form-signin">

            <form role="form" action="" method="post">
                <!--echo message-->
                <h5 class="text-center"><?php echo $msg; ?></h5>
                <input type="text" class="form-control" name="username" placeholder="username" required autofocus></br>
                <input type="password" class="form-control" name="password" placeholder="passwort" required><br>
                <input type="hidden" name="safeit" value="0" />
                <input type="checkbox" name="safeit" value="1">
                <label for="safeit">Stay logged in!</label>
                <button class="btn btn-lg btn-success btn-block" type="submit" name="login">Login</button>
            </form>

        </div>
    </main>

<?php
    include 'footer.php';
?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

</body>

</html>