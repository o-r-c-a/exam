<?php 
$title='News';
include 'inc/head.php'; 
require_once 'inc/functions.php';

//Falls "Artikel löschen"-Form aufgerufen worden ist kann durch einen Session-Admin ein Artikel gelöscht werden
if(isset($_GET['delete_article']) && isset($_GET['news_id'])
    && isset($_SESSION["loggedRole"]) && $_SESSION["loggedRole"] === 'a')
{
    deleteArticle(intval($_GET['news_id']));
}
?>

<body>

    <?php include 'inc/headerNav.php';

        //Wenn ein Admin eingeloggt ist kann dieser neue Artikel mittesl Form hinzufügen:
        if(isset($_SESSION["loggedRole"]) and $_SESSION["loggedRole"] === 'a'){ 
            showEditArticleForm();
        }
        //Anzeigen der Übersicht aller Artikel
        showArticlePreview();
    ?>
    <?php include 'inc/footer.php'; ?>

</body>

<?php
//Funktion zur Anzeige einer Artikelvorschau (mit abgeschnittenem Fließtext)
function showArticlePreview(){
    //Artikelvorschau anzeigen in Übersicht

    echo '<section>
                <div class="contentBackground">
                    <h2 style="text-align: left; margin-left: 3%">News</h2>';

    //Wenn Bildordner leer ist gibt es keine Artikel
    $uploadedImgs = glob('uploads/news/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
    if(empty($uploadedImgs)){
        echo '<p class = "errorMessage">Es gibt aktuell noch keine News-Artikel.</p></div></section>';
        echo '<p class = "errorMessage">Es gibt aktuell noch keine News-Artikel.</p></div></section>';
        return;
    }
    
    require 'inc/dbaccess.php';
    $db_obj=new mysqli($host, $dbuser, $dbpassword, $database);

    //SQL Query, geordnet nach neuestem Artikel
    $sql = "SELECT n.news_id, n.title, n.text, n.picPath, n.release_date, p.username
                FROM news n
                    JOIN person p ON n.writer = p.pers_id
                        ORDER BY n.release_date DESC";
    $stmt = $db_obj->query($sql); //Ergebnis aller Artikel

    while($row = mysqli_fetch_array($stmt)) { //fetch_array: für eine Zeile der Datensätze
        $news_id = $row["news_id"];
        $title = $row["title"];
        $textPreview = truncate($row["text"], 110);
        $writer = $row["username"];
        $release_date = convertTimeStamp($row["release_date"]);
        ?>
        <!--Unten: Link zu korrespondierendem Artikel abhängig von "news_id"-Key -->
            <div class = "newsRowPrev">
                <div class = "newsColumnPrevText">
                    <div class = "newsTextWrapper">
                        <a href = "newsShowArticle.php?article=<?php echo $news_id; ?>">
                            <h2><?php echo $title;?></h2>
                            <p><?php echo $textPreview; ?></p>
                            <p><i>von <?php echo $writer; ?>, erstellt am <?php echo $release_date; ?></i></p>
                        </a>
                    </div>
                    <div class = "newsTextWrapper">
                        <br><br>
                        <!--"Artikel löschen"-button für Admins-->
                        <?php if(isset($_SESSION["loggedRole"]) and $_SESSION["loggedRole"] === 'a'){?>
                            <form action = "newsMain.php" method = "GET">
                                <input type="hidden" name="news_id" value="<?php echo $news_id; ?>"/>
                                <input type="submit" style = "margin-left: 0.5%; position: relative; bottom: 5%" name="delete_article" value="Artikel löschen"/>
                                <input type="submit" style = "margin-left: 0.5%; position: relative; bottom: 5%" name="delete_article" value="Artikel löschen"/>
                            </form>
                        <?php }
                        ?>
                    </div>
                </div>
                <div class = "newsColumnPrevImage">
                    <img class = "newsImageWrapper" src = "<?php echo $row["picPath"];?>" alt ="Bild <?php echo $news_id;?>">
                </div>
            </div>
    <?php 
    } 
    //Ende der Artikelvorschau
    ?>
    </div>
    </section>

    <?php
    //Speicher freigeben und SQL-Connection beenden
    $stmt->free_result();
    $db_obj->close();
    }
//Funktion, welche ausgeführt wird wenn ein Admin einen Artikel löschen möchte - abhängig von der news_id
function deleteArticle($news_id){
    //SQL Abfrage die Datensatz und Bild abhängig von news_id löscht 
    
    if(!removeImage($news_id)){
        echo '<p class = "errorMessage">Fehler beim Entfernen des Artikelbildes. Der Löschvorgang wurde abgebrochen.</p>';
        return;
    }

    require 'inc/dbaccess.php';
    $db_obj=new mysqli($host, $dbuser, $dbpassword, $database);

    //Löschen-Query
    $sql = "DELETE FROM news
                WHERE news_id = ?;";

    $stmt = $db_obj->prepare($sql);
    $stmt->bind_param("i",$news_id);

    //Falls die Abfrage nicht ausgeführt werden kann:
    if(!$stmt->execute()){
        echo '<p class = "errorMessage" style = "text-align: center">Fehler beim Entfernen des Artikels aus der Datenbank</p>';
        return;
    }
    //Sonst Erfolg
    //echo '<p class = "successMessage" style = "text-align: center">Artikel erfolgreich gelöscht</p>';

    //Speicher freigeben
    $stmt->free_result();
    $db_obj->close();
}
//Funktion zum Entfernen von Bildern im Zuge des Löschens eines Artikels
function removeImage($news_id){

    require 'inc/dbaccess.php';
    $db_obj=new mysqli($host, $dbuser, $dbpassword, $database);

    $sql = "SELECT picPath
                FROM news
                    WHERE news_id = ?;";
    
    $stmt = $db_obj->prepare($sql);
    $stmt->bind_param('i',$news_id);
    $stmt->execute();
    $stmt->bind_result($picPath);
    $stmt->fetch();

    if(empty($picPath)){
        echo '<p class = "errorMessage">Fehler beim Finden des Bildpfades in der Datenbank.</p>';
        return false;
    }

    //Falls Datei gefunden -> Löschen mittels unlink()
    if (file_exists($picPath)) {
        unlink($picPath);
        //echo '<p class = "successMessage" style = "text-align: center">Das Bild wurde entfernt.</p>';
    } else {
        echo '<p class = "errorMessage" style = "text-align: center">Die Bilddatei konnte nicht gefunden werden.</p>';
    }

    //Speicher freigeben
    $stmt->free_result(); 
    $db_obj->close();

    return true;
}
//Funktion zur Anzeige des "Neuer Artikel hochladen"-Formulars für Admins
function showEditArticleForm(){
    ?>
    <h1 style = "text-align: center">Bearbeitungs-Modus</h1>
    <!--BEMERKUNG: Form löst upload.php-Datei aus welche überprüft ob Datei hochgeladen werden kann oder nicht.-->
    <section>
        <div class="contentBackground">
            <form action="newsUpload.php" method="post" enctype="multipart/form-data">
                Bilddatei auswählen:
                <input type="file" name="fileToUpload" id="fileToUpload" required><br>
                <input type="text" style = "margin-bottom:3px" name = "title" id = "title" placeholder="Überschrift" required><br>
                <textarea id="text" name="text" rows="4" cols="50" placeholder = "Text hier schreiben" required></textarea>
                <input type="submit" style = "margin-top: 3px; padding:2px" value="Hochladen" name="submit">
            </form>
        </div>
    </section>
    <?php
}

?>

</html>