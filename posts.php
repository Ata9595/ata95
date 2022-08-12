<!-- importing The starting part of HTML -->
<?php 
include 'components/startingHtml.php';
?> 

<!-- importing Navbar from Components  -->
<?php 
include 'components/navbar.php'
?>


<div style=" padding: 10px; margin: 20px;" >

<div class="headline" style="display: flex; align-items: center; justify-content: center; ">
    <h1>Posts</h1>

</div>

<div class="comment-content" style="margin: 5px 0px;">
    <h2>Create your post</h2>
</div>
<hr>
<div class="form-div">
    <?php 
    $topic_id = $_GET['topic'];
        echo '
            <form action="posts.php?topic='.$topic_id.'" method="post">
        '
    ?>
    
        <div style="margin: 5px;">
            <h4>Enter you Post</h4>
        <textarea name="content" id="content" cols="30" rows="3"></textarea>
        </div>
        
        <div style="margin: 5px;">
            <h4>Enter User Name</h4>
        <input type="text" name="userName"  style="padding: 5px;">
        </div>
        
        <div style="margin: 5px;">
            <h4>Enter User Password</h4>
        <input type="password" name="password"  style="padding: 5px;">
        </div>
        
        <button  type="submit" style="padding: 5px; margin: 5px;">Send</button>
    </form>
</div>

<!-- Inserting Data Into DataBase  -->

<?php 
        if(isset($_POST['content']) ){
            $comment = $_POST['content'];
            $userName = $_POST['userName'];
            $passowrd = $_POST['password'];
            

            if( $userName != "" && $passowrd != "" ){
                include 'components/dbconnection.php';
                
                $sql = "SELECT * FROM `users` WHERE `user_name` = '$userName'";
                
                $result = mysqli_query($conn , $sql);

                // Inserting Post 
                while($row = mysqli_fetch_assoc($result)) {
                    echo "DataBase: " . $row['password'];
                    if($passowrd == $row['password']){
                        // Query for Inserting Data in Posts Table 
                        $sql = "INSERT INTO `posts` (`topic_id`, `user_id`,`time`, `content`) VALUES ('$topic_id', '".$row['user_id']."' , current_timestamp() , '$comment' )";

                        $result = mysqli_query($conn , $sql);
                        $location = "location: posts.php?topic=". $topic_id;
                        header($location);
                    }

                }
            }
        }
    ?>


<!-- check if get request is set on not  -->

<?php 

if(isset($_GET['topic'])){
    

    include 'components/dbconnection.php';
    // query to fetch all the data from posts table
    $sql = "SELECT * FROM `posts` WHERE `topic_id` = $topic_id ORDER BY post_id DESC";
    $result = mysqli_query($conn , $sql);

    while($row = mysqli_fetch_assoc($result)){

        // Authenticating user 
        $sql = "SELECT * FROM `users` WHERE `user_id` =  " . $row['user_id'] . " ";
        $userResult = mysqli_query($conn , $sql);
        $userRow = mysqli_fetch_assoc($userResult);
        // Counting Number of Comments from Data base
        $sql = "SELECT COUNT(`post_id`) as comments_num FROM `comments`GROUP BY `post_id` HAVING `post_id` = " . $row['post_id'] ;

        $numOfComments = mysqli_query($conn , $sql);
        
        $totalComments = mysqli_fetch_assoc($numOfComments);
        
        if ($totalComments == null){
            $total = 0;
        }else{
            $total = $totalComments['comments_num'];
        }

        

        echo '
            <div class="topics-div" style="border: 2px solid black; margin: 10px 0px; padding: 5px;">
                <div class="topic">
                    <div class="topic-title" style="padding: 5px; display: flex; ">
                        <h3>'. $row['content'].'</h3>
                    </div>
                    <hr>
                    <div class="topic-footer" style="display: flex; justify-content: space-between; padding: 10px; ">
                        <button style="padding: 5px;"><a href="comments.php?id='. $row['post_id'] .'">Comment</a></button>
                        <div style="display: flex;">
                            <p>Total Comments: </p>
                            <h4>'. $total .'</h4>
                        </div>
                        <div style="display: flex;">
                            <p>Created By: </p>
                            <h4>'. $userRow['user_name'] .'</h4>
                        </div>

                    </div>
                </div>
            </div>
        ';
    }
}

?>



</div>
    

<!-- Importing Ending part of Html -->
<?php 
include 'components/endingHtml.php';
?>