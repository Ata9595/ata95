<!-- importing The starting part of HTML -->
<?php 
include 'components/startingHtml.php';
?>

<!-- importing Navbar from Components  -->
<?php 
include 'components/navbar.php'
?>

<div style=" padding: 10px; margin: 20px;">

<div style="margin: 5px 0px;">
        <h1>Show all the contents of topics along the number of posts in each topic. Only show those topics which has at least one post</h1>
        <p>Getting Data from View and using INNER JOIN</p>
<!-- 
I use this query to Creating View in Data Base 
 Creating a Virtual view in database 

    CREATE VIEW VW_posts_intopic as 
    SELECT `topic_id`, COUNT(*) as total_posts FROM `posts` GROUP BY `topic_id`; -->

        <table style="border: 2px solid black;">
            <thead>
                <tr>
                    <th>Topic</th>
                    <th>Total Posts</th>
                </tr>
            </thead>
            <tbody>

                <?php
                include 'components/dbconnection.php';
                // This is getting data from view and show the content of topic with respect to topics_id and showing the totatl count of posts.  
                $sql = "SELECT `topics`.`content` , `vw_posts_intopic`.`total_posts` FROM `topics` INNER JOIN `vw_posts_intopic` ON `topics`.`topic_id` = `vw_posts_intopic`.`topic_id`";
                
                $result = mysqli_query($conn , $sql);

                while($row = mysqli_fetch_assoc($result)) {
                    echo '
                        <tr >
                            <td  style="border: 1px solid black; padding: 5px;">'.$row['content'].'</td>
                            <td  style="border: 1px solid black; padding: 5px;">'.$row['total_posts'].'</td>
                        </tr>
                    ';
                }
            ?>
            </tbody>
        </table>
    </div>


    <div style="margin: 5px 0px;">
        <h1>Table of all the active users who create at least one post in any topic</h1>
        <p>Geting data from multitables at store it in a View and then displaying data from view</p>

<!-- I use These quries to create View in DataBase

    
    Creating a view, to display all the names of the users who create atleast one posts. This is collecting Data from multi tables.

    CREATE VIEW VW_active_user as SELECT `user_name` as active_users FROM `users` WHERE `user_id` IN (SELECT DISTINCT(`user_id`) FROM `posts`); -->

        <table style="border: 2px solid black;">
            <thead>
                <tr>
                    <th>Name</th>
                </tr>
            </thead>
            <tbody>

                <?php
                include 'components/dbconnection.php';
                // This query is getting all the data from Virtual view vw_active_user 
                $sql = "SELECT * FROM vw_active_user";
                
                $result = mysqli_query($conn , $sql);

                while($row = mysqli_fetch_assoc($result)) {
                    echo '
                        <tr >
                            <td  style="border: 1px solid black; padding: 5px;">'.$row['active_users'].'</td>
                        </tr>
                    ';
                }
            ?>
            </tbody>
        </table>
    </div>
<hr>


    <div style="margin: 5px 0px;">
        <h1>Display all the post's contents which have more then 2 comments.</h1>
        <p>Geting data from multitables.Use Group By query with aggregation functions</p>
        <table style="border: 2px solid black;">
            <thead>
                <tr>
                    <th>Contents</th>
                </tr>
            </thead>
            <tbody>

                <?php
                include 'components/dbconnection.php';
                // Getting Data from posts and comments table with respect to post_id and count the comments by using post_id. If the count is greater then 2 then is will return the content of the post.
                $sql = "SELECT `content` FROM `posts` WHERE `post_id` IN (SELECT `post_id` FROM `comments` GROUP BY `post_id` HAVING COUNT(*) > 2)";
                
                $result = mysqli_query($conn , $sql);

                while($row = mysqli_fetch_assoc($result)) {
                    echo '
                        <tr >
                            <td  style="border: 1px solid black; padding: 5px;">'.$row['content'].'</td>
                        </tr>
                    ';
                }
            ?>
            </tbody>
        </table>
    </div>

    <hr>
    <div style="margin: 5px 0px;">
        <h1>Display the name of mod who post the last newest topic is database..</h1>
        <p>Geting data from multitables.Useing aggregation function</p>
        <table style="border: 2px solid black;">
            <thead>
                <tr>
                    <th>Name</th>
                </tr>
            </thead>
            <tbody>

                <?php
                include 'components/dbconnection.php';
                // Getting the maximum topic_id from topics and check the mod_id of that topic and then get the user_name from mods table 
                $sql = "SELECT `user_name` FROM `mods` WHERE `mod_id` = (SELECT `mod_id` FROM `topics` WHERE `topic_id` = (SELECT MAX(`topic_id`) FROM `topics`))";
                
                $result = mysqli_query($conn , $sql);

                while($row = mysqli_fetch_assoc($result)) {
                    echo '
                        <tr >
                            <td  style="border: 1px solid black; padding: 5px;">'.$row['user_name'].'</td>
                        </tr>
                    ';
                }
            ?>
            </tbody>
        </table>
    </div>


</div>



<!-- Importing Ending part of Html -->
<?php 
include 'components/endingHtml.php';
?>