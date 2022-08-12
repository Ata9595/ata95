<!-- importing The starting part of HTML -->
<?php 
include 'components/startingHtml.php';
?> 

<!-- importing Navbar from Components  -->
<?php 
include 'components/navbar.php'
?>

    <div class="main">
        <div class="login">
            <div class="form">
                <h1 style="margin: 10px 0px;" >SingUp as User</h1>
                <?php
            if (isset($_GET['error'])){
                $messge_text = $_GET['error'];
                echo '
                <h3 style="color: red; text-decoration: underline;">'. $messge_text .'</h3>
                ';
            } 
            
            ?>
                <form action="singup.php" method="get">

                    <div class="form-items">
                        <label for="userName">Enter User Name</label>
                        <input type="text" name="userName" id="singup-userName">
                        <h3>Enter Password</h3>
                        <input type="text" name="password"  id="singup-userName">

                        <button type="submit" style="padding: 5px;"><h2>Singup</h2></button>
                    </div>

                </form>
            </div>
        </div>
    </div>



<!-- Importing Ending part of Html -->
<?php 
include 'components/endingHtml.php';
?>