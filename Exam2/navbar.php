<nav class="navbar navbar-expand-sm navbar-light bg-light fixed-top">
        <a class="navbar-brand" href="index.php"><img src="./res/img/recipeslogo.png" height="28px"/></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse" id="mainNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item navcenter"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item navcenter"><a class="nav-link" href="add.php">Add</a></li>

                <!-- 4a) add a Logout Button here which only appears, when a valid User is logged in -->
                <?php
                    if(isset($_SESSION['userID'])){
                        echo '<li class="nav-item navcenter"><a class="nav-link" href="logout.php">Logout</a></li>';
                    }
                ?>
                
            </ul>
        </div>
    </nav>