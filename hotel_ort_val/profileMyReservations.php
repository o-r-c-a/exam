<?php
    $title = "Meine Reservierungen";
    include 'inc/head.php'; 
    include 'inc/functions.php';
    checkIfLoggedIn();

    /*Anzeige der eigenen Reservierungen für Standarduser -> Admins haben die Reservierungsverwaltungs-Übersicht aller Reservierungen in der DB
    (über welches sie auch Reservierungen ändern können)*/
?>

<body>
    <?php include 'inc/headerNav.php';?>

    <section>
    <div class = "contentBackground">
    <h2>Meine Reservierungen</h2>

    <table class = "userManagerTable">
        <thead>
            <tr>
                <th>Anreisedatum</th>
                <th>Abreisedatum</th>
                <th>Zimmerart</th>
                <th>Frühstück</th>
                <th>Parkplatz</th>
                <th>Haustier</th>
                <th>Status</th>
                <th>Preis</th>
            </tr>
        </thead>
        <tbody> <!--Datensätze-->
            <?php
                require 'inc/dbaccess.php';
                $db_obj=new mysqli($host, $dbuser, $dbpassword, $database);
                //SQL Query, geordnet nach neuestem Artikel
                $sql = "SELECT date_from, date_to, breakfast, parking, pets, res.price, rt.description as room, rs.description as state
                            FROM reservation res
                                JOIN room USING (room_nr)
                                JOIN room_type rt ON(type=rt_id)
                                JOIN reservation_state rs USING(state_id)
                            WHERE pers_id=" . $_SESSION['user']['pers_id'];

                $result = $db_obj->query($sql); //Ergebnis aller Reservierungen

                while($row = mysqli_fetch_array($result)) {
                    $date_from = $row["date_from"];
                    $date_to = $row["date_to"];
                    $breakfast = ($row["breakfast"]) == 1 ? "Ja" : "Nein";
                    $parking = ($row["parking"]) == 1 ? "Ja" : "Nein";
                    $pets = ($row["pets"]) == 1 ? "Ja" : "Nein";
                    $room = $row["room"];
                    $state = $row["state"];                    
                    $price = $row["price"];                    

                    ?>
                        <tr>
                            <td><?=date('d.m.y',strtotime($date_from))?></td>
                            <td><?=date('d.m.y',strtotime($date_to))?></td>
                            <td><?=$room?></td>
                            <td><?=$breakfast?></td>
                            <td><?=$parking?></td>
                            <td><?=$pets?></td>
                            <td><?=$state?></td>
                            <td>€<?=$price?></td>
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
    