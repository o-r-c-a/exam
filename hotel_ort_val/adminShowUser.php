<?php
    $title = "Userverwaltung";
    include 'inc/head.php'; 
    include 'inc/functions.php';
    checkIfAdmin();

    /*Userübersicht für Admins
    Ausgabe ALLER Nutzer und ihrer Stammdaten + Form zum bearbeiten dieser
    Auch ändern des Passworts falls diese es vergessen haben. 
    Auch inaktive User werden in der Liste angezeigt*/
?>

<body>
    <?php include 'inc/headerNav.php';?>

    <section>
    <div class = "contentBackground">
    <h2>User-Übersicht</h2>

    <table class = "userManagerTable"> <!--User Tabelle-->
        <thead> <!--Reiter-->
            <tr>
                <th>Pers_ID</th>
                <th>Rolle</th>
                <th>Titel</th>
                <th>Vorname</th>
                <th>Nachname</th>
                <th>Email</th>
                <th>Username</th>
                <th>Telefonnummer</th>
                <th>Reservierungen</th>
                <th>Aktiviert</th>
                <th>Operation</th>
            </tr>
        </thead>
        <tbody> <!--Datensätze-->
            <?php
                require 'inc/dbaccess.php';
                $db_obj=new mysqli($host, $dbuser, $dbpassword, $database);
                //SQL Query, geordnet nach neuestem Artikel
                $sql = "SELECT p.pers_id, p.salutation, p.firstname, p.lastname, p.email, p.username, p.tel, count(r.res_id) as reservations, p.active, p.ur_id
                            FROM person p
                                LEFT JOIN reservation r USING (pers_id)
                                    GROUP BY p.pers_id, p.salutation, p.firstname, p.lastname, p.email, p.username, p.tel, p.active, p.ur_id
                                        ORDER BY p.pers_id ASC";

                $result = $db_obj->query($sql); //Ergebnis aller Artikel

                while($row = mysqli_fetch_array($result)) {
                    $id = $row["pers_id"];
                    $role = $row["ur_id"] == 'a' ? "Admin" : "User";
                    $salutation = $row["salutation"];
                    $f_name = $row["firstname"];
                    $l_name = $row["lastname"];
                    $email = $row["email"];
                    $username = $row["username"];
                    $telephone = $row["tel"] == "" ? "-" : $row["tel"];
                    $reservations = $row["reservations"] < 1 ? "-" : $row["reservations"];
                    $active = ($row["active"]) == 1 ? "Aktiviert" : "Deaktiviert";
                    
                    ?>
                        <tr>
                            <td><?=$id?></td>
                            <td><?=$role?></td>
                            <td><?=$salutation?></td>
                            <td><?=$f_name?></td>
                            <td><?=$l_name?></td>
                            <td><?=$email?></td>
                            <td><?=$username?></td>
                            <td><?=$telephone?></td>
                            <td><?=$reservations?></td>
                            <td><?=$active?></td>
                            <td><a href = "profileEdit.php?pers_id=<?php echo $id; ?>">Bearbeiten</td>
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
    