<?php $title='Reservierung';
include 'inc/head.php';  
include 'inc/functions.php';
checkIfLoggedIn();?>

<body>
    <?php include 'inc/headerNav.php';?>

    <?php
        $startDate=$_SESSION['selectedStart'];
        $endDate=$_SESSION['selectedEnd'];
        // Abfrage um Zimmer zu bekommen für spezifisches Datum + Zimmertyp
        require_once('inc/dbaccess.php');
    
        $db_obj=new mysqli($host, $dbuser, $dbpassword, $database);

        $sqlGetRoom="   SELECT room_nr from room
                        WHERE room_nr NOT IN(
                            SELECT room_nr from room                        
                            JOIN room_type on(room.type=room_type.rt_id)
                            LEFT JOIN reservation using(room_nr)
                            WHERE (reservation.date_from<?)AND(reservation.date_to>?)
                        )AND type=?";
        $stmt = $db_obj->prepare($sqlGetRoom);

        $stmt->bind_param('sss',$endDate, $startDate,$_POST['zimmer']);
        $stmt->execute();
        $result=$stmt->bind_result($roomNr);
        $stmt->fetch();
        $stmt->close();

        $sumPrice=0;

        if(isset($_POST['checkBreakfast'])&&$_POST['checkBreakfast']=='on'){
            $breakfast=1;
            $sumPrice+=$_SESSION['prices']['breakfast'];
        }
        else
            $breakfast=0;
        if(isset($_POST['checkParking'])&&$_POST['checkParking']=='on'){
            $sumPrice+=$_SESSION['prices']['parking'];
            $parking=1;
        }
        else
            $parking=0;
        if(isset($_POST['checkPets'])&&$_POST['checkPets']=='on'){
            $sumPrice+=$_SESSION['prices']['pets'];
            $pets=1;
        }
        else
            $pets=0;


        $sumPrice+=$_SESSION['prices'][$_POST['zimmer']];                   //Berechnung des Gesamtpreises
        $amountDays=date_create($endDate)->diff(date_create($startDate));
        $sumPrice=$amountDays->days*$sumPrice;


        $sqlInsert="   INSERT INTO reservation(date_from, date_to, breakfast, parking, pets, other, pers_id, room_nr, state_id, price)VALUES(?,?,?,?,?,?,?,?,'n', ?);"; //Einfügen der Reservierung in Datenbank
        $stmt2=$db_obj->prepare($sqlInsert);
        $stmt2->bind_param('ssiiisiid', $startDate, $endDate,$breakfast,$parking,$pets, $_POST['txtOther'],$_SESSION['user']['pers_id'],$roomNr, $sumPrice);
        $stmt2->execute();

        if($stmt2->errno!=0){
            $success=false;
        } else {
            $success=true;
        }
        
    ?>
    <section>
        <div class="contentBackground">
            <?php if(!$success){echo "Fehler beim Speichern der Reservierung - Melden Sie sich beim Support";}
            else{?>
            <h1>Erfolgreich reserviert</h1>
            <h2>Ihre Anfrage:</h2>
            <?php
                echo '<p>Gast: ' . $_SESSION['user']['salutation'] . ' ' .  $_SESSION['user']['firstname'] .' ' .  $_SESSION['user']['lastname'] . '</p>';  // Anzeigen aller Informationen der Reservierung
                echo '<p>Zimmer: ';
                if($_POST['zimmer']=='ez')echo 'Einzelzimmer';
                if($_POST['zimmer']=='dz')echo 'Doppelzimmer';
                if($_POST['zimmer']=='ds')echo 'Deluxe Suite';

                echo '</p><p>von ' .  date('d.m.y',strtotime($startDate)) . ' bis ' .  date('d.m.y',strtotime($endDate)) . '</p>';

                echo '<p>Preis für ' . $amountDays->d . ' Nächte: </p>';
                echo '<p>' . number_format($sumPrice, 2, ',', '') . '€</p>';
            }?>
            <br><br>
            <a href="index.php"><img style="height: 50px;" src="images/homeButton.png" alt="Startseite"></a>
        </div>
    </section>
    <?php include 'inc/footer.php'; ?>
</body>

</html>