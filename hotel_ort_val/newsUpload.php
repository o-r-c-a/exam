<?php
$title = "Upload";
include 'inc/head.php'; 
include 'inc/functions.php';

include 'inc/headerNav.php';
include 'inc/functions.php';
checkIfAdmin();
?>
<body>
    <section class="contentBackground" style="text-align: center">
        <?php
            //Artikel uploaden falls checkIfAdmin erfolgreich war
            uploadArticle();
        ?>
    </section>
    <?php
    include 'inc/footer.php';
    //Verlassen der Seite
    echo '<script type="text/javascript">setTimeout(function(){ window.location.href = "newsMain.php"; }, 1500);</script>';
    ?>
</body>

<?php

function uploadArticle(){
    
    //Deklaration von Verzeichnis und Dateipfad $file
    $dir = "uploads/news/";
    $file = $dir . basename($_FILES["fileToUpload"]["name"]);

    if(!uploadImage($file)){
        echo'<p class = "errorMessage">Sorry, das Bild konnte nicht hochgeladen werden.</p>';
    }
    else{
        //SQL Upload
        echo'<p class = "successMessage">Bilddatei erfolgreich in Upload-Ordner hochgeladen.</p>';
        require_once('inc/dbaccess.php');
        
        $db_obj=new mysqli($host, $dbuser, $dbpassword, $database);
        $sql = "INSERT INTO news (text, title, picPath, writer) VALUES (?,?,?,?)";
        $stmt = $db_obj->prepare($sql);

        //Reinladen der Daten Titel und Artikeltext aus dem Formular
        $text = $_POST['text'];
        $title = $_POST['title'];

        $writer = $_SESSION["user"]["pers_id"];
        
        //Zuweisung der Parameter (zur Absicherung vor SQL Injections)
        $stmt->bind_param("ssss", $text, $title, $file, $writer);

        $stmt->execute();

        //Falls es einen Fehler bei der Ausführung gab
        if ($stmt->error) {
            echo '<p class = "errorMessage">Error beim Versuch, den Artikel auf die Datenbank hochzuladen (Bild wurde jedoch in Verzeichnis hinterlegt). Error-Nummer: ' . $stmt->error . '</p>';
        } else {
            echo '<p class = "successMessage">Artikel erfolgreich in Datenbank hochgeladen.</p>';
        }

        $stmt->free_result();
        $db_obj->close();
    }  
}
function uploadImage($file){
    //Überprüfen ob Datei durch Formular gespeichert worden ist
    if (!$_FILES["fileToUpload"]["error"] == UPLOAD_ERR_OK){
        echo '<p class = "errorMessage">Es wurde keine Datei ausgewählt. Bitte versuchen Sie es erneut.</p>';
        return false;
    }

    $imgFileType = strtolower(pathinfo($file, PATHINFO_EXTENSION));

    //Falls ein Parameter (Größe,Format etc) nicht korrekt ist wird der Upload abgebrochen
    if(!checkImageParameters($file, $imgFileType, $_FILES["fileToUpload"]["size"], $_FILES["fileToUpload"]["tmp_name"])){
        return false;
    }

    //Nach erfolgreichem Upload werden Bilder mittels resizeImage auf konstante Thumbnail Größe heruntergesetzt vorausgesetzt GD ist installiert
    if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $file)){
        if(extension_loaded("gd")){
            //Ursprüngliches Bild überschreiben mit neuer Höhe und Breite (konstant)
            $_CONST_THUMBNAIL_SIZE = 320;
            resizeImage($file, $file, $_CONST_THUMBNAIL_SIZE, $_CONST_THUMBNAIL_SIZE, $imgFileType);
            return true;
        }
        else{
            echo '<p class = "errorMessage">Das Bild kann nicht verkleinert werden da die GD-Extension nicht erkannt wird.</p>';
        }
    }
    return false;
}
function checkImageParameters($file, $imgFileType, $fileSize, $fileTemp){
    //Falls die Datei kein Bild ist:
    if(!getimagesize($fileTemp)){
        echo '<p class = "errorMessage">Sorry, die Datei ist kein Bild.</p>';
        return false;
    }
    //Überprüfen ob das Bild im Ordner schon vorhanden ist
    if (file_exists($file)) {
        echo '<p class ="errorMessage">Sorry, die Datei existiert bereits.</p>';
        return false;
    }
    //Check ob es zu groß ist (größer als 3 MB)
    else if ($fileSize > 3000000){
        echo '<p class = "errorMessage">Tut uns leid, aber die Datei ist zu groß.</p>';
        return false;
    }
    //Check auf korrektes File-Format
    else if ($imgFileType != "jpg" && $imgFileType != "png" && $imgFileType != "jpeg"&& $imgFileType != "gif") {
        echo '<p class = "errorMessage">Tut uns leid, aber es werden nur JPG, JPEG, PNG & GIF files unterstützt.</p>';
        return false;
    }

    return true;

}
function resizeImage($oldImgPath, $resizedImgPath, $thumbnailWidth, $thumbnailHeight, $fileExtension){
    //Konvertiert Pfad in "Bild-Identifier" mittels fileExtension (siehe GD-Library imagecreatefromjpeg) abhängig vom Format
    switch ($fileExtension) {
        case 'jpeg':
        case 'jpg':
            $originalImage = imagecreatefromjpeg($oldImgPath);
            break;
        case 'png':
            $originalImage = imagecreatefrompng($oldImgPath);
            break;
        case 'gif':
            $originalImage = imagecreatefromgif($oldImgPath);
            break;
        default:
            return false;
    }

    //Berechnung der originalen Dimensionen
    $originalWidth = imagesx($originalImage);
    $originalHeight = imagesy($originalImage);

    //Erstellt Bild"rahmen" für die verkleinerte Version mit der gewünschten Höhe und Breite
    $resizedImage = imagecreatetruecolor($thumbnailWidth, $thumbnailHeight);
    
    //Konvertiert altes Bild in verkleinertes Bild und speichert dieses in $resizedImage
    imagecopyresampled(
        $resizedImage,
        $originalImage,
        0, 0, 0, 0,
        $thumbnailWidth,
        $thumbnailHeight,
        $originalWidth,
        $originalHeight
    );

    //Abhängig vom Dateiformat wird das verkleinerte Bild im gewünschten Ordner gespeichert
    switch ($fileExtension) {
        case 'jpeg':
        case 'jpg':
            imagejpeg($resizedImage, $resizedImgPath);
            break;
        case 'png':
            imagepng($resizedImage, $resizedImgPath);
            break;
        case 'gif':
            imagegif($resizedImage, $resizedImgPath);
            break;
    }
    
    //Speicher freigeben
    imagedestroy($originalImage);
    imagedestroy($resizedImage);
}

?>

</html>
