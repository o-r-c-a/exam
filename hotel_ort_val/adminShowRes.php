<?php
    $title = "Reservierungsverwaltung";
    include 'inc/head.php'; 
    include 'inc/functions.php';
    checkIfAdmin();

    /*Reservierungsübersicht für Admins
    Filtern nach Status, Möglichkeit der Änderung einer Reservierung auf adminEditRes.php
    */
?>

<body>
    <?php include 'inc/headerNav.php';?>

    <section>
    <div class = "contentBackground">
    <h2>Übersicht aller Reservierungen</h2>

    <form action="adminShowRes.php" method="get">
        <label for="state">Status:</label>
        <select name="state" id="cars">
            <option value=""></option>
            <option value="n" <?php echo (isset($_GET['state'])&&$_GET['state']=='n')?'selected':'' ?>>Neu</option>
            <option value="b" <?php echo (isset($_GET['state'])&&$_GET['state']=='b')?'selected':'' ?>>Bestätigt</option>
            <option value="s" <?php echo (isset($_GET['state'])&&$_GET['state']=='s')?'selected':'' ?>>Storniert</option>
        </select>
        <input type="submit" value="Filtern">
    </form>
    <br>

    <table class = "userManagerTable"> <!--User Tabelle-->
        <thead> <!--Reiter-->
            <tr>
                <th>Res_ID</th>
                <th>Username</th>
                <th>Von</th>
                <th>Bis</th>
                <th>Apartment Nr.</th>
                <th>Status</th>
                <th>Operation</th>
            </tr>
        </thead>
        <tbody> <!--Datensätze-->
            <?php
                $filter=false;
                $filterString='';
                if(!empty($_GET['state']))
                {
                    $filterState=$_GET['state'];
                    $filter=true;
                    $filterString=" WHERE state_id=? ";
                }

                require 'inc/dbaccess.php';
                $db_obj=new mysqli($host, $dbuser, $dbpassword, $database);
                //SQL Query, geordnet nach neuestem Artikel
                $sql = "SELECT r.res_id, p.username, r.date_from, r.date_to, r.room_nr, r.state_id 
                            FROM reservation r
                                JOIN person p USING (pers_id)" . $filterString .
                                    "ORDER BY r.res_id ASC";

                if($filter)
                {
                    $stmt=$db_obj->prepare($sql);
                    $stmt->bind_param('s',$filterState);
                    $stmt->execute();
                    $result=$stmt->get_result();
                }
                else{
                    $result = $db_obj->query($sql); //Ergebnis aller Artikel
                }

                while($row = mysqli_fetch_array($result)) {             
                    //Alle Ergebnisse werden gespeichert                                                                                                                                                                                                                                                                                                                
                    $res_id = $row["res_id"];
                    $username = $row["username"];
                    $date_from = convertTimeStamp($row["date_from"]);
                    $date_to = convertTimeStamp($row["date_to"]);
                    $apartment = $row["room_nr"];
                    $state = convertReservationState($row["state_id"]);
                    
                    ?>
                        <!-- Ausgabe mittels Tabelle -->
                        <tr>
                            <td><?=$res_id?></td>
                            <td><?=$username?></td>
                            <td><?=$date_from?></td>
                            <td><?=$date_to?></td>
                            <td><?=$apartment?></td>
                            <td><?=$state?></td>
                            <td><a href = "adminEditRes.php?res_id=<?php echo $res_id; ?>">Ändern</td>
                        </tr>
                    <?php
                }
            ?>
        </tbody>
    </table>

    
    <?php
    $result->free_result();
    $db_obj->close();
    ?>
    </div>
    </section>

    <?php include 'inc/footer.php';?>
</body>
</html>
    