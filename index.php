

<?php  include('header.php'); ?>


   <section class="main">
       <div class="wrapper">
        <div class="left-col">

        
              
          <?php if(isset($_GET['success_message'])){ ?>
                <p class="text-center alert-success"><?php echo $_GET['success_message'];?></p>
            <?php } ?>   

            <?php if(isset($_GET['error_message'])){ ?>
                <p class="text-center alert-danger"><?php echo $_GET['error_message'];?></p>
            <?php } ?>  

            <!--Status wrapper-->
            <?php include('get_status_wrapper.php'); ?>

           <?php include('get_latest_posts.php'); ?> 
           
           <?php foreach($posts as $post){ ?>

                    <!--Post-->
                    <div class="post">
                        <div class="info">
                            <div class="user">
                                <div class="profile-pic"><img src="<?php echo "assets/imgs/". $post['profile_image'];?>"/></div>
                                <p class="username"><?php echo $post['username']; ?></p>
                            </div>
                             <a style="color:#000" href="single_post.php?post_id=<?php echo $post['id']; ?>"><i class="fas fa-ellipsis-h options"></i></a>
                        </div>
                        <!--POST-->
                        <img src="<?php echo "assets/imgs/". $post['image']; ?>" class="post-image"/>
                        <div class="post-content">
                            <div class="reaction-wrapper">

                            
                            <?php include('check_if_user_liked_this_post.php'); ?>

                          

                                <i class="icon fas fa-comment"></i>
                            </div>

                            <p class="likes"><?php echo $post['likes']; ?> likes</p>
                            <p class="description"><span><?php echo $post['caption']; ?></span>  <?php echo $post['hashtags'];?></p>
                            <p class="post-time"><?php echo date("M, Y", strtotime($post['date']));  ?></p>

                            <div>
                            <a class="comment-btn" href="single_post.php?post_id=<?php echo $post['id'];?>">comments</a>
                        </div>

                        </div>

           
                        <!-- <div class="comment-wrapper">
                            <img src="assets/imgs/1.jpeg" class="icon"/>
                            <input type="text" class="comment-box" placeholder="Add a comment"/>
                            <button class="comment-btn">comment</button>
                        </div> -->
                    </div> 
                    
                 <?php } ?>  
                 
                 
              
           


        </div>

        <div class="right-col">

            <!--Profile card-->
            <?php include('profile_card.php'); ?>

            <!-- Suggestions -->
            <?php include('suggestion_side_area.php'); ?>
            

        </div>
        
       </div>
   </section>







</body>
</html>




<?php

?>