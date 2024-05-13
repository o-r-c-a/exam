<!DOCTYPE html>
<html lang="de">

<?php
    include 'head.php';
?>

<body>
    <?php       
    include 'navbar.php';

    // 3a) Check if valid user is logged in. If not, forward user to login page
    if(!isset($_SESSION['userID'])){
        header('Location: login.php');
    }
    ?>

    <header>
        <div class="container jumbotron">
            <br>
            <h1 class="display-5">Add new recipe</h1>
        </div>
    </header>
    <main>
        <!-- 3b) Add bootstrap form and 3c) add PHP functionalities to add the form data to the database -->

        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
        <form action="add.php" method="post">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" placeholder="Enter a title" id="title" name="title" autofocus require>
            </div>
            <div class="form-group">
                <label for="ing">Ingredients</label>
                <input type="text" class="form-control" placeholder="Enter the ingredients" id="ing" name="ing" require>
            </div>
            <div class="form-group">
                <label for="desc">Description</label>
                <textarea class="form-control" type="textarea" rows="10" id="desc" name="desc" placeholder="Describe the disch" require></textarea>
            </div>
            <div class="form-group">
                <label for="url">Image-URL</label>
                <input class="form-control" type="text" placeholder="Enter a URL" id="url" name="url" require>
            </div>
            <button type="submit" class="btn btn-dark" name="submit">Submit</button>
            
            <?php
                    
                    if(isset($_POST['submit']) && isset($_POST['title']) && isset($_POST['desc']) && isset($_POST['url'])){
                        require_once('dbaccess.php');
                        $db_obj = new mysqli($host, $dbuser, $dbpassword, $database);

                        if ($db_obj->connect_error) {
                            echo "Connection Error: " . $db_obj->connect_error;
                            exit();
                        }
                    
                        $sql2="INSERT INTO `recipes`(`title`, `ingredients`, `description`, `picture`) VALUES (?, ?, ?, ?);";
                        $stmt2 = $db_obj->prepare($sql2);
                        
                        $stmt2->bind_param('ssss', $_POST['title'], $_POST['ing'], $_POST['desc'], $_POST['url']);  //s -> string, i -> integer, d -> double, b -> blob

                        if ($stmt2->execute()) {
                            echo "<div class='green mb-2 '>New recipe created.</div>";
                        }
                        $stmt2->close(); 
                        $db_obj->close();
                    }
                ?>
        </form> 
            </div>
            <div class="col-md-4"></div>
        </div>
    </main>

    

<?php

    include 'footer.php';
?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

</body>

</html>