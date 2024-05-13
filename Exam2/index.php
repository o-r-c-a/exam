<!DOCTYPE html>
<html lang="de">

<?php
    include 'head.php';
?>

<body>
    <?php
    include 'navbar.php';
    ?>

    <header>
        <div class="container jumbotron">
            <br>
            <h1 class="display-5">Recipes</h1>
        </div>
    </header>

    <main>
        <!-- 2a Connect to the database and create the table using bootstrap -->
                <?php
                require_once('dbaccess.php');
                $db_obj = new mysqli($host, $dbuser, $dbpassword, $database);

                if ($db_obj->connect_error) {
                    echo "Connection Error: " . $db_obj->connect_error;
                    exit();
                }

                $sql="SELECT * FROM recipes;";
                
                $result = $db_obj->query($sql);

                ?>
                            <div class="container jumbotron">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">Meal</th>
                                            <th scope="col">Ingredients</th>
                                            <th scope="col">Recipe</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            while($row = $result->fetch_array()){
                                            
                                            echo '<tr>';
                                            echo '<td>'. $row['title'] . '<img src="'.$row['picture'] .'" class="img-fluid"></td>';
                                            echo '<td>' . $row['ingredients'] . '</td>';
                                            echo '<td>' . $row['description'] . '</td>';
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