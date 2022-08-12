 <!-- Inserting User into DataBase  -->
 <?php
$name = $_GET['userName'];
$passwordof = $_GET['password'];

// connection with  Database 
require 'components/dbconnection.php';
$sql = "SELECT * FROM `users` WHERE `user_name` = ' $name '";
$result = mysqli_query($conn , $sql);
// Total Number of rows with Same Email 
$numOfRows = mysqli_num_rows($result);
// if Number of row is equal to one then go back 
if ($numOfRows == 1 || $numOfRows > 1){
    // if User with same Email Addres exit then it Redirext to Error page and Exits the Script 
    header("location: singupPage.php?error=Email is All Ready Exits");
    exit();
}else{ 
    $notexist = true; // This flag is represent the existens
}  

// if user is not exist then add this user in database 
if ($notexist == true){
    
    $sql = "INSERT INTO `users` ( `user_name`, `password`) VALUES ( '$name', '$passwordof'); ";
    $result = mysqli_query($conn , $sql);
    header("location: index.php");
    
}else{
    

}
header( 'location: index.php' );


?>
