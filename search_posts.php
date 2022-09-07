
    
<?php include('header.php'); ?>

<?php


            include('connection.php');


         if(isset($_POST['search_input'])){

            $search_input = strval("%".$_POST['search_input']."%");



            $stmt = $conn->prepare("SELECT * FROM posts WHERE caption like ? OR hashtags like ?  limit 12");
            $stmt->bind_param("ss",$search_input,$search_input);
            $stmt->execute();
            $posts = $stmt->get_result();


         }else{

            //default keywor
            $search_input = strval("%"."car"."%");

            $stmt = $conn->prepare("SELECT * FROM posts WHERE caption like ? OR hashtags like ? limit 12");
            $stmt->bind_param("ss",$search_input,$search_input);
            $stmt->execute();
            $posts = $stmt->get_result();


         }

         
    if(isset($_POST['search_input'])){

            $search_input = strval("%".$_POST['search_input']."%");

            $stmt = $conn->prepare("SELECT * FROM users WHERE username like ? LIMIT 20");
            $stmt->bind_param("s",$search_input);
            $stmt->execute();
            $users = $stmt->get_result();


    }else{

            //default keyword
       
            $search_input = strval("%"."john"."%");

            $stmt = $conn->prepare("SELECT * FROM users WHERE username like ? LIMIT 20");
            $stmt->bind_param("s",$search_input);
            $stmt->execute();
            $users = $stmt->get_result();


    }


           


?>
 

   <main>
    <div class="discover-container">
        <div class="gallery">


        <?php foreach($posts as $post){ ?>


            <div class="gallery-item">
                <img src="<?php echo "assets/imgs/".$post['image'];?>" class="gallery-image" alt="">
                <div class="gallery-item-info">
                    <ul>
                        <li class="gallery-item-likes"><span class="hide-gallery-element"><?php echo $post['likes']; ?></span>
                            <i class="fas fa-heart"></i>
                        </li>
                        <li class="gallery-item-comments"><span class="hide-gallery-element"></span>
                            <a href="single_post.php?post_id=<?php echo $post['id'];?>" style="color: #fff;"><i class="fas fa-comment"></i></a>
                        </li>
                    </ul>
                </div>
            </div>

         <?php } ?>   


    </div>
<div class="mt-5 mx-5">
       
        <ul class="list-group">


        <?php foreach($users as $user){ ?>

            <?php if($user['id'] != $_SESSION['id']){ ?>

            <li class="list-group-item search-result-item">
                <img src="<?php echo "assets/imgs/".$user['image']; ?>" />
                <div style="width: 100%;">
                    <p><?php echo $user['username'];?></p>
                    <span><?php echo substr($user['bio'],0,20); ?></span>
                </div>
                <div class="search-result-item-btn">
                    <form action="other_user_profile.php" method="POST">
                        <input type="hidden" name="other_user_id" value="<?php echo $user['id']; ?>">
                        <button type="submit">Visit Profile</button>
                    </form>
                </div>
            </li>

            <?php } ?>

         <?php } ?> 


        </ul>
    </div>


   </main> 

  


</body>
</html>