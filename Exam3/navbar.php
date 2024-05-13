<nav class="navbar navbar-expand-sm navbar-light navbg fixed-top">
    <a class="navbar-brand" href="index.php"><img src="./res/img/logo.png" height="28px"/></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-collapse collapse" id="mainNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item navcenter"><a class="nav-link" href="index.php">Home</a></li>
            <li class="nav-item navcenter"><a class="nav-link" href="upload.php">Upload</a></li>
            
            <!-- 4b Menüpunkt "Assignments" -->
            <?php
                if(isset($_SESSION['userID']) && $_SESSION['userRole'] == 'lecturer') {
                    echo '<li class="nav-item navcenter"><a class="nav-link" href="assignments.php">Assignments</a></li>';
                }
            ?>
            <!-- 4a Menüpunkt "Logout" -->
            <?php
            if(isset($_SESSION['userID'])) {
                echo '<li class="nav-item navcenter"><a class="nav-link" href="logout.php">Logout</a></li>';
            }
            ?>
        </ul>
    </div>
</nav>