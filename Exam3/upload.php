<!DOCTYPE html>
<html lang="de">

<?php
    include 'head.php';
?>

<body>
    <?php
    include 'navbar.php';
    ?>
        
    <!-- 2a Prüfen Sie über die Session-Variablen,
            ob ein gültiger User eingeloggt ist und
            reagieren Sie entsprechend der Angabe darauf.
            Falls kein User eingeloggt ist, soll
            dieser zur loginpage.php-Seite
            weitergeleitet werden.
    -->
    <?php
        if(!isset($_SESSION['userID'])){
            header('Location: loginpage.php');
        }
    ?>

    <header>
        <div class="container jumbotron">
            <br>
            <h1 class="display-5">Upload</h1>
        </div>
    </header>

    <!-- 2b Aufgaben zum Upload Formular -->
    <!-- https://www.w3schools.com/bootstrap4/bootstrap_forms.asp -->
    <!-- https://www.w3schools.com/bootstrap4/bootstrap_forms_custom.asp -->

    <form action="upload.php" class="form-inline" method="post" enctype="multipart/form-data">
        <div class="container jumbotron">
            <div class="row mx-5">
                <div class="custom-file col-md-8">
                    <label for="fileToUpload" class="custom-file-label">Select PDF to upload</label>
                    <input type="file" class="custom-file-input" name="fileToUpload" id="fileToUpload" accept=".pdf" required> 
                </div>
                <div class="col-md-4">
                    <input type="submit" class="btn btn-primary mb-2" value="Upload PDF" name="submit">
                </div>    
            </div>
        </div>
    </form>
    
    <!-- 2c Aufgaben zu den Upload-Funktionalitäten -->
    
    <?php
        if(isset($_POST['submit'])){
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            $error = false;
            $KB = 1024;
            $MB = $KB * $KB;

            // Check if file already exists
            if (file_exists($target_file)) {
                echo "<p class=\"text-center mb-2\">Sorry, file already exists.</p>";
                $error = true;
            }


            // Check file size
            if ($_FILES["fileToUpload"]["size"] > 12*$MB) {
                echo "<p class='red text-center mb-5'>Sorry, file is too big!</p>";
                $error = true;
            }

            // Allow certain file formats
            if($fileType != "pdf"/* && $fileType != "doc" && $fileType != "docx"*/) {
                echo "Sorry, only PDF files are allowed.";
                $error = true;
            }

            // if everything is ok, try to upload file || without file extension
            if (!$error) {
                move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
                echo "<p class='green text-center mb-5'>The file ". htmlspecialchars(pathinfo( $target_file, PATHINFO_FILENAME)). " has been uploaded.</p>";
            }
        }

    ?>





<?php
    include 'footer.php';
?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

</body>

</html>