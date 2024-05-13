<?php
    $title = "Reservierung ändern";
    include 'inc/head.php'; 
    include 'inc/functions.php';

    checkIfAdmin();
    
    /*Reservierung bearbeiten für Admins*/
    function getDetails(){
        require 'inc/dbaccess.php';
        $db_obj=new mysqli($host, $dbuser, $dbpassword, $database);
        //SQL Query, geordnet nach neuestem Artikel
        $sql = "SELECT r.res_id, p.username, r.date_from, r.date_to, r.room_nr, r.breakfast, r.parking, r.pets, r.other, r.state_id 
                    FROM reservation r
                        JOIN person p USING (pers_id)
                            WHERE r.res_id = ?";

        if($stmt = $db_obj->prepare($sql)){
            $stmt->bind_param('s', $_GET['res_id']);
            $stmt->execute();
            $stmt->bind_result($res_id, $username, $date_from, $date_to, $apartment, $breakfast, $parking, $pets, $other, $state);
            $stmt->fetch();

            $stmt->free_result();
            $db_obj->close();
            
            $breakfast = ($breakfast == 1) ? "Ja" : "Nein";
            $parking = ($parking == 1) ? "Ja" : "Nein";
            $pets = ($pets == 1) ? "Ja" : "Nein";
            $other = ($other == "") ? "-" : $other;

            return [
                'res_id' => $res_id,
                'username' => $username,
                'date_from' => $date_from,
                'date_to' => $date_to,
                'apartment' => $apartment,
                'breakfast' => $breakfast,
                'parking' => $parking,
                'pets' => $pets,
                'other' => $other,
                'state' => $state,
            ];
        }
        return NULL;
    }
    function updateState($state){
        require_once('inc/dbaccess.php');

        $db_obj=new mysqli($host, $dbuser, $dbpassword, $database);

        $sql='UPDATE reservation SET state_id=? WHERE res_id=?';
        $stmt = $db_obj->prepare($sql);
        $stmt->bind_param("ss", $state, $_GET['res_id']);

        $stmt->execute();

        if($stmt->affected_rows==1){
            return 1;
        }
        return 0;
    }

    
    $showForm = true;
    $error = false;

    if(isset($_GET['update'])){
        //Status aktualisieren fall dieser nicht dem alten entspricht

        $state = $_POST["state"];

        if($state === $_POST["old_state"]){
            $errorMessage = "Zum Aktualisieren müssen Sie einen neuen Status auswählen!";
            $error = true;
        }

        if(!$error){
            if(updateState($state)){
                $successMessage = "Status erfolgreich aktualisiert";
            }
            else{
                $errorMessage = "Leider konnte der Status nicht aktualisiert werden";
            }
        }
    }

    if(isset($_SESSION['loggedRole']) && $_SESSION['loggedRole'] ==='a'
        || isset($_SESSION['user']['pers_id']) && $_SESSION['user']['pers_id'] == $_GET['pers_id'])
    {
        $reservation = getDetails();
    }
    else{
        $showForm = false;
    }
?>

<body>
    <?php include 'inc/headerNav.php';?>

    <section>
    <div class = "contentBackground">
    
    <?php
        if($showForm){
            ?>
            <h2>Reservierung #<?php echo $reservation['res_id'];?> von <i><?php echo $reservation['username'];?></i></h2>
            <form action = "?update=1&res_id=<?php echo $reservation['res_id'];?>" method = "POST">
                <label for = "date_from">Von</label><br>
                <input type = "text" value = "<?php echo convertTimeStamp($reservation['date_from']);?>" disabled><br>
                <label for = "date_to">Bis</label><br>
                <input type = "text" value = "<?php echo convertTimeStamp($reservation['date_to']);?>" disabled><br>
                <label for = "room_id">Apartment Nr.</label><br>
                <input type = "text" value = "<?php echo $reservation['apartment'];?>" disabled><br>
                <label for = "breakfast">Frühstück</label><br>
                <input type = "text" value = "<?php echo $reservation['breakfast'];?>" disabled><br>
                <label for = "parking">Parkplatz</label><br>
                <input type = "text" value = "<?php echo $reservation['parking'];?>" disabled><br>
                <label for = "pets">Tiere</label><br>
                <input type = "text" value = "<?php echo $reservation['pets'];?>" disabled><br>
                <label for = "other">Sonstiges</label><br>
                <textarea type = "text" placeholder = "<?php echo $reservation['other'];?>" disabled></textarea><br>

                <input type = "hidden" name = "old_state" id = "old_state" value ="<?php echo $reservation['state'];?>"> <!--Speichern des vorherigen Status-Wertes (unsichtbar)-->

                <label for="state">Status</label>
                <select id="state" name="state">
                    <!--Ternary-Operator überprüft ob ausgewählte Reservierung einem der Statusmöglichkeiten entspricht, falls ja wählt er diesen aus durch echo-Ausgabe von 'selected'-->
                    <option value="n" <?php echo ($reservation['state'] == 'n') ? 'selected' : ''; ?>>Neu <i>(Ausstehend)</i></option>
                    <option value="b" <?php echo ($reservation['state'] == 'b') ? 'selected' : ''; ?>>Bestätigt</option>
                    <option value="s" <?php echo ($reservation['state'] == 's') ? 'selected' : ''; ?>>Storniert</option>
                </select><br>

                <button type="submit">Aktualisieren</button><br>
            </form>
        <?php
            if(isset($successMessage)){
                echo '<p class = "successMessage">' . $successMessage .'</p>';
            }
            else if(isset($errorMessage)){
                echo '<p class = "errorMessage">' . $errorMessage . '</p>';
            }
        }
        else{
            echo '<p class = "errorMessage">Ihnen fehlen die nötigen Administrator-Rechte, um eine Reservierungsänderung vorzunehmen.</p>';
        }
    ?>

    </div>
    </section>

    <?php include 'inc/footer.php';?>
</body>
</html>
    