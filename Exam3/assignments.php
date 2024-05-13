<!DOCTYPE html>
<html lang="de">

<?php
    include 'head.php';
?>

<body>
    <?php
    include 'navbar.php';
    ?>
        
    <!-- 3a Prüfen Sie über die Session-Variablen,
            ob ein User mit der Rolle 'student' oder
            'lecturer' eingeloggt ist und reagieren
            Sie entsprechend der Angabe darauf.
            Falls kein User eingeloggt ist, soll
            dieser zur loginpage.php-Seite
            weitergeleitet werden.
    -->
    <?php
        if(!isset($_SESSION['userID'])){
            header('Location: loginpage.php');
        }
        else if($_SESSION['userRole'] == 'student'){
            header('Location: upload.php');
        }
    ?>
    <!-- dont LUKAS BOKOWY -->

    <header>
        <div class="container jumbotron">
            <br>
            <h1 class="display-5">Assignments</h1>
        </div>
    </header>

    <!-- 3.
        b) Directory auslesen, Dateien verlinken und
           als Tabelle ausgeben
        c) Dateigröße in KB in eigener Spalte anzeigen
        d) Upload-Datum in Spalte anzeigen (Bonus)
        e) Absteigende Sortierung: Zuletzt hochgeladene
           Datei soll an erster Stelle stehen (Bonus)
    -->
    <main>
        <div class="container jumbotron">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Filename</th>
                        <th scope="col">Filesize (KB)</th>
                        <th scope="col">Upload Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $dir = 'uploads/';
                        $files = scandir($dir);
                        $files = array_diff($files, array('.', '..'));
                        $fileInfo = [];

                        foreach($files as $file){
                            $fileInfo[$file] = filemtime($dir . $file);
                        }
                        arsort($fileInfo);

                        foreach($fileInfo as $file => $modifiedTime){
                                $fileSize = filesize($dir . $file) / 1024;
                                $uploadDate = date('d.m.Y H:i', $modifiedTime);
                                echo '<tr>';
                                echo '<td><a href="' . $dir . $file . '">' . $file . '</a></td>';
                                echo '<td>' . round($fileSize) . '</td>';
                                echo '<td>' . $uploadDate . '</td>';
                                echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
<?php
    include 'footer.php';
?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

</body>

</html>