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