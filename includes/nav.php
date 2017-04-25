<nav class="navbar navbar-inverse container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand">Twitter-Like-Application</a>
        </div>
        <div>
            <ul class="nav navbar-nav">

                <?php
                    echo '<li><a href="index.php"><span class="glyphicon glyphicon-home"></span> Main-page </a></li>';
                //logged user may see
                    if($userID!=null){
                       echo '<li><a href="user.php?id=' . $userID . '">Account Info</a></li>';
                       echo '<li><a href="messages.php?id=' . $userID . '">Messages</a></li>';
                }
                ?>

            </ul>
            <ul class="nav navbar-nav navbar-right">

            <?php
            // unlogged users can see
                if($userID == null){
                    echo '<li><a href="register.php"><span class="glyphicon glyphicon-user"></span> Register</a></li>';
                    echo '<li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>';
            // logged users can see
                }else{
                    echo '<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>';
                }
            ?>

            </ul>
        </div>
</nav>






