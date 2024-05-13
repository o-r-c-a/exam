<?php $title='Reservierung';
include 'inc/head.php'; 
include 'inc/functions.php';
checkIfLoggedIn();

/*Seite zum Vornehmen neuer Reservierungen durch eingeloggte User*/
?>

<body>
    <?php include 'inc/headerNav.php';?>
    <section>
        <div class="contentBackground">
            <?php 
                $dateFrom=date('d.m.y',strtotime($_SESSION['selectedStart']));
                $dateTo=date('d.m.y',strtotime($_SESSION['selectedEnd']));
                $availableRooms=$_SESSION['availableRooms'];

                $prices = array();

                require_once('inc/dbaccess.php');
    
                $db_obj=new mysqli($host, $dbuser, $dbpassword, $database);
                // Abfrage der Preise von Extras und Zimmern
                $sql="  SELECT description, price from extras
                        UNION
                        SELECT rt_id, price from room_type;";
                $stmt = $db_obj->prepare($sql);

                $stmt->execute();
                $result = $stmt->bind_result($key, $value);
                while($stmt->fetch())                   //Alle Preise in Array in Form: prices["breakfast"]=9.00
                {
                    $prices[$key]=$value;
                }

                $_SESSION["prices"]=$prices;
                echo '<h2>Reservierung </h2>'; 
                echo '<h3>' . $dateFrom . ' - ' . $dateTo;
            ?>
            
            <form action="reservationSuccess.php" method="POST">
                <label for="zimmer">Zimmerart:</label>
                <select id="zimmer" name="zimmer">
                    <?php 
                        //Überprüfen ob Zimmeroption verfügbar ist - falls ja wird diese dem User als Option angezeigt
                        if(in_array('ez', $availableRooms)){
                            echo '<option value="ez"';
                            if($_GET["zimmer"]=='ez')echo 'selected';
                            echo '>Einzelzimmer - ' . $prices['ez'] . '€</option>';
                        }
                        if(in_array('dz', $availableRooms)){
                            echo '<option value="dz"';
                            if($_GET["zimmer"]=='dz')echo 'selected';
                            echo '>Doppelzimmer - ' . $prices['dz'] . '€</option>';
                        }
                        if(in_array('ds', $availableRooms)){
                            echo '<option value="ds"';
                            if($_GET["zimmer"]=='ds')echo 'selected';
                            echo '>Deluxe Suite - ' . $prices['ds'] . '€</option>';
                        }
                    ?>
                </select><br><br>
                <input type="checkbox" name="checkBreakfast" id="checkBreakfast">
                <label for="checkBreakfast">mit Frühstück - <?php echo $prices['breakfast']; ?>€</label><br><br>
                <input type="checkbox" name="checkParking" id="checkParking">
                <label for="checkParking">mit Parkplatz - <?php echo $prices['parking']; ?>€</label><br><br>
                <input type="checkbox" name="checkPets" id="checkPets">
                <label for="checkPets">Mitnahme von Haustieren - <?php echo $prices['pets']; ?>€</label><br><br>
                <label for="txtOther">Sonstige Anmerkungen</label><br>
                <textarea id="txtOther" name="txtOther" rows="4" cols="50"></textarea><br>
                <button type="submit">Reservieren</button>
            </form>
            <p>*Preise pro Nacht</p>
        </div>
    </section>
    <?php include 'inc/footer.php'; ?>
</body>

</html>