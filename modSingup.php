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
                <h1 style="margin: 10px 0px;" >SingUp as Admin</h1>
                <form action="adminSingUpFun.php" method="get">

                    <div class="form-items">
                        <label for="userName">Enter User Name</label>
                        <input type="text" name="userName" id="admin-userName">
                        <label for="password">Enter Password</label>
                        <input type="password" name="password" id="admin-password">
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