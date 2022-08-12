<!-- importing The starting part of HTML -->
<?php 
include 'components/startingHtml.php';
?>

<!-- importing Navbar from Components  -->
<?php 
include 'components/navbar.php'
?>



<div style=" padding: 10px; margin: 20px;">

    <div class="headline" style="display: flex; align-items: center; justify-content: center; ">
        <h1>Available Topics</h1>
    </div>

    <div class="form-div">
        <form action="index.php" method="post">
            <div style="margin: 5px;">
                <h4>Create Topic</h4>
                <input type="text" name="topic" style="padding: 5px;">
            </div>

            <div style="margin: 5px;">
                <h4>Enter admin User Name</h4>
                <input type="text" name="adminName" style="padding: 5px;">
            </div>

            <div style="margin: 5px;">
                <h4>Enter admin Password</h4>
                <input type="password" name="password" style="padding: 5px;">
            </div>

            <button type="submit" style="padding: 5px; margin: 5px;">Send</button>
        </form>
    </div>

    <!-- Inserting Data Into DataBase  -->

<?php 
        if(isset($_POST['topic'])){
            $topicContent = $_POST['topic'];
            $adminName = $_POST['adminName'];
            $adminPassowrd = $_POST['password'];
            

            if( $adminName != "" && $adminPassowrd != "" ){
                // Getting COnnection 
                include 'components/dbconnection.php';

                // Validation of User
                $sql = "SELECT * FROM `mods` WHERE `user_name` = '$adminName'";
                
                // Executing the Quey 
                $result = mysqli_query($conn , $sql);
                
                // Fetching rows from result and store the data into row one by one
                while($row = mysqli_fetch_assoc($result)) {
                    
                    // if password is match 
                    if($adminPassowrd == $row['password']){
                        // Insert the Topic into Data 
                        $sql = "INSERT INTO `topics` (`mod_id`, `content`) VALUES (' " . $row['mod_id'] ." ', ' ". $topicContent ."')";
                        // Executing the Query 
                        $result = mysqli_query($conn , $sql);
                        // To navigate the Page Index.php 
                        header( 'location: index.php' );
                    }

                }
            }
            header( 'location: index.php' );

        }
    ?>


    <!-- Getting all the Topics from the Data Base  -->
<div>
    <?php 
    include 'components/dbconnection.php';
    // query to fetch all the data from topics table
    $sql = 'SELECT * FROM `topics` ';

    $result = mysqli_query($conn , $sql);

    // fetch all the rows one by one and then store in a variable 
    while($row = mysqli_fetch_assoc($result)){

        // Getting the Data Of Mod 
        $sql = "SELECT * FROM `mods` WHERE `mod_id` =  " . $row['mod_id'] . " ";

        $modResult = mysqli_query($conn , $sql);
        // stoing Row 
        $modRow = mysqli_fetch_assoc($modResult);

        // Geting Number of Comments Using Grouping 
        $sql = "SELECT COUNT(`topic_id`) as posts_num FROM `posts`GROUP BY `topic_id` HAVING `topic_id` = " . $row['topic_id'] ;
        $numOfPosts = mysqli_query($conn , $sql);
        $totalPostsRow = mysqli_fetch_assoc($numOfPosts);

        if ($totalPostsRow == null){
            $total = 0;
        }else{
            $total = $totalPostsRow['posts_num'];
        }

        echo '
        <div style="border: 2px solid black; margin: 10px 0px; padding: 5px;">
            <div class="topic">
                <div class="topic-title" style="padding: 5px; display: flex; "><h3>Title: ' . $row['content'] .' </h3></div>
                <hr>
                <div class="topic-footer" style="display: flex; justify-content: space-between; padding: 10px; ">
                    <button style="padding: 5px;"><a href="posts.php?topic='. $row['topic_id'] .'">Create Post on this Topic</a></button>
                    <div style="display: flex;" ><p>Total Posts: '. $total.' </p><h4>3</h4></div>
                    <div style="display: flex;"><p>Created By: </p><h4>'. $modRow['user_name'] .'</h4></div>
                    
                </div>
            </div>
        </div>
        
        ';

    }
    ?>
</div>
    


<!-- Importing Ending part of Html -->
<?php 
include 'components/endingHtml.php';
?>