<main>
    <div class="container form-signin login">

        <?php
        // Prepare empty message variable
        $msg = 'Please log in';

        // Check if username and password are set
        if (
            isset($_POST['login']) && !empty($_POST['username'])
            && !empty($_POST['password'])
        ) {
            // LUKAS BOKOWY
            require_once('dbaccess.php');
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Create connection
            $conn = new mysqli($host, $dbuser, $dbpassword, $database);
            $sql = "SELECT * FROM users WHERE usrname = ?;";
            $stmt = $conn->prepare($sql);
            
            $stmt->bind_param("s", $username);

            // Set parameters
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            // Check if user exists
            if($user){
                if($password == $user["passwd"]){
                $_SESSION['userID'] =  $user['id'];
                $_SESSION['userRole'] = $user['role'];
                $_SESSION['login_time'] = time();
                $msg = 'Login successful!';

                // Check if user is a student
                if($_SESSION['userRole'] == 'student'){
                    header('Location: upload.php');
                }
                else if($_SESSION['userRole'] == 'lecturer'){
                    header('Location: assignments.php');
                }
            }
            }
            else{
                $msg = 'Wrong username or password!';
            }
        }
            //  Code der alten Lösung
            // Check username and password combination, set message and forward the user to upload page if they match
        //     if (
        //         $_POST['username'] == 'alice' &&
        //         $_POST['password'] == 'a123'
        //     ) {
        //         $_SESSION['userID'] = 301;
        //         $_SESSION['userRole'] = 'student';
        //         $_SESSION['login_time'] = time();
        //         $msg = 'Login successful!';
        //         header('Location: upload.php');
        //     }
            
        //     else if (
        //         $_POST['username'] == 'bob' &&
        //         $_POST['password'] == 'b456'
        //     ) {
        //         $_SESSION['userID'] = 302;
        //         $_SESSION['userRole'] = 'student';
        //         $_SESSION['login_time'] = time();
        //         $msg = 'Login successful!';
        //         header('Location: upload.php');
        //     }
            
        //     else if (
        //         $_POST['username'] == 'charlie' &&
        //         $_POST['password'] == 'c789'
        //     ) {
        //         $_SESSION['userID'] = 303;
        //         $_SESSION['userRole'] = 'student';
        //         $_SESSION['login_time'] = time();
        //         $msg = 'Login successful!';
        //         header('Location: upload.php');
        //     }

        //     else if (
        //         $_POST['username'] == 'john' &&
        //         $_POST['password'] == 't90123'
        //     ) {
        //         $_SESSION['userID'] = 100;
        //         $_SESSION['userRole'] = 'lecturer';
        //         $_SESSION['login_time'] = time();
        //         $msg = 'Login successful!';
        //         header('Location: assignments.php');
        //     }
            
        //     else {
        //         $msg = 'Wrong username or password!';
        //     }
        // }
        
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