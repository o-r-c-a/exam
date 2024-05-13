<?php
$title=$_GET['article'];
include 'inc/head.php'; 
include 'inc/functions.php';
?>

<body>
    <?php 
        include 'inc/headerNav.php';
        showTotalArticle();
    ?>
    <?php include 'inc/footer.php'; ?>
</body>

<?php
//Funktion zur Anzeige eines Artikels abhängig von der news_id (= $_GET['article'])
function showTotalArticle(){
    require_once 'inc/dbaccess.php';
    $db_obj=new mysqli($host, $dbuser, $dbpassword, $database);

    //SQL Query
    $sql = "SELECT n.title, n.text, n.picPath, n.release_date, p.username 
                FROM news n
                    JOIN person p 
                        ON n.writer = p.pers_id
                            WHERE news_id = ?";
    
    if($stmt = $db_obj->prepare($sql)){
        $stmt->bind_param('s', $_GET['article']);
        $stmt->execute();
        $stmt->bind_result($title, $text, $picPath, $release_date, $writer);
    
        while($stmt->fetch()){
            ?>
            <!-- Ausgabe des Artikels -->
                <div class = "contentBackground" style = "margin-left:5%; margin-right:5%; margin-top: 2%;">
                    <div class = "newsRowPres">
                        <div class = "newsColumnPresText">
                            <div class = "newsTextWrapper">
                                <h2><?=$title?></h2>
                                <p><?=nl2br($text)?></p> <!-- nl2br()-Funktion um \n und andere special chars anzeigen zu lassen -->
                            </div>
                        </div>
                        <div class = "newsColumnPresImage">
                            <img src = "<?php echo $picPath;?>" alt ="Bild <?php echo $title;?>">
                            <p><i>Artikel von <?php echo $writer; ?>, erstellt am <?php echo convertTimeStamp($release_date); ?></i></p>
                        </div>
                    </div>
                </div>
            <?php
        }
    
        $stmt->free_result();
        $stmt->close();
    }else die("Der gewünschte Artikel kann leider nicht angezeigt werden.");
}
?>

</html>