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
        <h1>Comments</h1>

    </div>

    <div class="comment-content" style="margin: 5px 0px;">
        <h2>Post your Comment</h2>
    </div>

    <div class="form-div">
        <?php 
        $post_id = $_GET['id'];
        echo '
            <form action="comments.php?id='.$post_id.'" method="post">
        ';
        ?>
        
            <div style="margin: 5px;">
                <h4>Enter you Comment</h4>
            <textarea name="comment" id="comment" cols="30" rows="3"></textarea>
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
        if(isset($_POST['comment']) ){
            $comment = $_POST['comment'];
            $userName = $_POST['userName'];
            $passowrd = $_POST['password'];
            

            if( $userName != "" && $passowrd != "" ){
                include 'components/dbconnection.php';
                // Inserting Post 
                $sql = "SELECT * FROM `users` WHERE `user_name` = '$userName'";
                
                $result = mysqli_query($conn , $sql);

                
                while($row = mysqli_fetch_assoc($result)) {
                    echo "DataBase: " . $row['password'];
                    if($passowrd == $row['password']){
                        $sql = "INSERT INTO `comments` (`post_id`, `user_id`,`time`, `content`) VALUES ('$post_id', '".$row['user_id']."' , current_timestamp() , '$comment' )";

                        $result = mysqli_query($conn , $sql);
                        $location = "location: comments.php?id=". $post_id;
                        header($location);
                    }

                }
            }
        }
    ?>

    <!-- fetching all the comments realted to the specific post  -->
    <?php 
    if(isset($_GET['id'])){

        include 'components/dbconnection.php';
    // query to fetch all the data from posts table
    $sql = "SELECT * FROM `comments` WHERE `post_id` = $post_id ORDER BY comment_id DESC";
    $result = mysqli_query($conn , $sql);

    while($row = mysqli_fetch_assoc($result)){

        $sql = "SELECT * FROM `users` WHERE `user_id` =  " . $row['user_id'] . " ";
        $userResult = mysqli_query($conn , $sql);
        $userRow = mysqli_fetch_assoc($userResult);

        echo '
        <div class="topics-div" style="border: 2px solid black; margin: 10px 0px; padding: 5px;">
        <div class="topic">
            <div class="topic-title" style="padding: 5px; display: flex; ">
                <h3>Comment: '. $row['content'] . '</h3>
            </div>
            <hr>
            <div class="topic-footer" style="display: flex; justify-content: space-between; padding: 10px; ">
                
                <div style="display: flex;">
                    <p>Post By: </p>
                    <h4>'. $userRow['user_name'].'</h4>
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