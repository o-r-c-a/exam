<main>
    <div class="container jumbotron">
        <p>You are logged in. &#9989;</p>

        <!-- 5a -->
        <?php
            if($_SESSION['userRole'] == 'lecturer') {
                echo '<p>Please use the <i><a href="assignments.php">Assignments-Tool</a></i></p>';
            }
            else if($_SESSION['userRole'] == 'student'){
                echo '<p>Please use the <i><a href="upload.php">Upload-Tool </a></i></p>';
                
            }
        ?>
    </div>
</main>