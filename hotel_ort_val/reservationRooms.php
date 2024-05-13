<?php $title='Zimmer';
include 'inc/head.php'; ?>

<body>
    <?php 
        include 'inc/headerNav.php';
        $loggedIn=isset($_SESSION['loggedRole']);

        
        if(!empty($_GET['dateFrom'])&&!empty($_GET['dateTo']))
        {
            $datesAreValid=false;

            $dateFrom=$_GET['dateFrom'];
            $dateTo=$_GET['dateTo'];

            if($dateFrom<$dateTo)
            {
                $datesAreValid=true;
            }
        }

        $checkedIfAvailable=false;
        $availableRooms=array();

        if(isset($datesAreValid)&&$datesAreValid)
        {
            $_SESSION['selectedStart']=$_GET['dateFrom'];
            $_SESSION['selectedEnd']=$_GET['dateTo'];

            require_once('inc/dbaccess.php');
    
            $db_obj=new mysqli($host, $dbuser, $dbpassword, $database);
            // Abfrage, welche Zimmertypen in diesem Zeitbereich verfügbar sind
            $sql="  SELECT type from room
                    WHERE room_nr NOT IN(
                        SELECT room_nr from room                        
                        JOIN room_type on(room.type=room_type.rt_id)
                        LEFT JOIN reservation using(room_nr)
                    WHERE (reservation.date_from<?)AND(reservation.date_to>?)
            )
            GROUP BY(type)
            ";
            $stmt = $db_obj->prepare($sql);

            $stmt->bind_param('ss',$_GET['dateTo'], $_GET['dateFrom']);
            $stmt->execute();
            $result = $stmt->bind_result($room);
            while($stmt->fetch())                   // IDs aller verfügbaren Zimmerarten werden in ein Array geladen
            {
                $availableRooms[]=$room;
            }
            $checkedIfAvailable=true;
        }

        $_SESSION['availableRooms']=$availableRooms;
    ?>
    <section>
    <div class="contentBackground">
            <?php 
                echo '<h2>Zeitraum wählen: </h2>'; 
                ?>
            
             <form action="reservationRooms.php" method="GET">          <!-- Form um um Start- und Enddatum einzugeben -->
                <label for="dateFrom">Von &nbsp;</label>
                <input type="date" name="dateFrom" id="dateFrom" value='<?php if($datesAreValid) echo $_SESSION['selectedStart']?>' style="width:200px"/>
                <label for="dateTo">&nbsp; bis &nbsp;</label>
                <input type="date" name="dateTo" id="dateTo" value='<?php if($datesAreValid) echo $_SESSION['selectedEnd']?>' style="width:200px"/><br><br>
                <button type="submit">Suchen</button>
            </form>
            <?php 
                if(!($loggedIn)){echo '<p class="errorMessage">Sie müssen sich einloggen um ein Zimmer zu reservieren</p>';} 
                if(isset($datesAreValid)&&!($datesAreValid)){echo '<p class="errorMessage">Der Anreisetag muss vorm Abreisetag liegen';}
            ?>
        </div>
        <?php if(in_array('ez',$availableRooms)){               // wenn Zimmerart im Array ist, wird der Link zum Zimmer reservieren angezeigt
        ?>
            <a href="<?php if($loggedIn){echo 'reservation.php?zimmer=ez';} ?>">
                <div class="zimmerCont">
                    <img src="images/einzelzimmer.jpg" alt="Einzelzimmer" class="zimmerImg">
                    <div class="zimmerFont">Einzelzimmer</div>
                </div>
            </a>
        <?php }
        if(in_array('dz',$availableRooms)) {
        ?>
            <a href="<?php if($loggedIn){echo 'reservation.php?zimmer=dz';} ?>">
                <div class="zimmerCont">
                    <img src="images/doppelzimmer.jpg" alt="Doppelzimmer" class="zimmerImg">
                    <div class="zimmerFont">Doppelzimmer</div>
                </div>
            </a>
            <?php }
        if(in_array('ds',$availableRooms)) {
        ?>
            <a href="<?php if($loggedIn){echo 'reservation.php?zimmer=ds';} ?>">
                <div class="zimmerCont">
                    <img src="images/deluxe.jpg" alt="Deluxe Suite" class="zimmerImg">
                    <div class="zimmerFont">Deluxe Suite</div>
                </div>
            </a>
        <?php }
        ?>
    </section>
    <?php include 'inc/footer.php'; ?>
</body>

</html>