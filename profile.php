
<?php include("header.php"); ?>


    <header class="profile-header">
       
        <div class="profile-container">
           
             <?php if(isset($_GET['success_message'])){ ?>
                <p class="text-center alert-success"><?php echo $_GET['success_message'];?></p>
            <?php } ?>   

            <?php if(isset($_GET['error_message'])){ ?>
                <p class="text-center alert-danger"><?php echo $_GET['error_message'];?></p>
            <?php } ?>   

            <div class="profile">
                <div class="profile-image">
                    <img src="<?php echo "assets/imgs/".$_SESSION['image'];  ?>" alt="">
                </div>
                <div class="profile-user-settings">
                    <h1 class="profile-user-name"> <?php echo $_SESSION['username']; ?> </h1>

                    <form action="edit_profile.php" method="GET" style="display:inline-block">
                      <button class="profile-btn profile-edit-btn" type="submit">Edit Profile</button>
                    </form>
                    
                    <button class="profile-btn profile-settings-btn" id="options_btn" aria-label="profile settings">
                        <i class="fas fa-cog"></i>
                    </button>


                    <div class="popup" id="popup">
                        <div class="popup-window">
                            <span class="close-popup" id="close_popup">&times;</span>
                            <a href="edit_profile.php">Edit profile</a>
                            <a href="camera.php">Create post</a>
                            <a href="logout.php">Logout</a>
                        </div>
                    </div>




                </div>
                <div class="profile-stats">
                    <ul>
                        <li><span class="profile-stat-count"><?php echo $_SESSION['posts']; ?></span> posts</li>
                        <form style="display: inline-block;" action="my_followers.php" method="POST">
                          <li><span class="profile-stat-count"><?php echo  $_SESSION['followers']; ?></span> <input value="followers" type="submit" style="background: none; border:none"></li>
                        </form>
                     
                        <form style="display: inline-block;" action="my_followings.php" method="POST">
                           <li><span class="profile-stat-count"><?php echo $_SESSION['following']; ?></span> <input type="submit" value="following" style="background: none; border:none"></li>
                        </form>
                       
                    </ul>
                </div>
                <div class="profile-bio">
                    <p><span class="profile-real-name"><?php echo $_SESSION['username'] . ", "; ?> </span> <?php echo $_SESSION['bio']; ?></p>
                </div>
            </div>
        </div>
    </header>


   <main>
    <div class="profile-container">
        <div class="gallery">

        <?php include("get_user_posts.php"); ?>

         <?php foreach($posts as $post){ ?>

            <div class="gallery-item">
                <img src="<?php echo "assets/imgs/".$post['image']; ?>" class="gallery-image" alt="">
                <div class="gallery-item-info">
                    <ul>
                        <li class="gallery-item-likes"><span class="hide-gallery-element"><?php echo $post['likes'];?></span>
                            <i class="fas fa-heart"></i>
                        </li>
                        <li class="gallery-item-comments"><span class="hide-gallery-element"></span>
                            <a style="color:#fff" href="single_post.php?post_id=<?php echo $post['id'];?>" ><i class="fas fa-comment"></i></a>
                        </li>
                    </ul>
                </div>
            </div>

         <?php } ?>   
         
    </div>

   <!-- okay -->


      <nav aria-label="Page navigation example" style="display:flex; justify-content: center">
            <ul class="pagination">
                <li class="page-item <?php if($page_no<=1){echo 'disabled';}?>">
                        <a class="page-link" href="<?php if($page_no<=1){echo'#';}else{ echo '?page_no='. ($page_no-1); }?>">Previous</a>
                </li>
                <li class="page-item"><a class="page-link" href="?page_no=1">1</a></li>
                <li class="page-item"><a class="page-link" href="?page_no=2">2</a></li>
                <li class="page-item"><a class="page-link" href="?page_no=3">3</a></li>
                <?php if($page_no >= 3){?>
                    <li class="page-item"><a class="page-link" href="#">...</a></li>
                    <li class="page-item"><a class="page-link" href="<?php echo "?page_no=". $page_no;?>"></a></li>
                <?php } ?>
                <li class="page-item <?php if($page_no>= $total_no_of_pages){echo 'disabled';}?>">
                    <a class="page-link" href="<?php if($page_no>=$total_no_of_pages){echo "#";}else{ echo "?page_no=".($page_no+1);}?>">Next</a>
                </li>
            </ul>
        </nav>






   </main> 




   <script>


         var popupWindow = document.getElementById('popup');
         var optionsBtn = document.getElementById('options_btn');
         var closeWindow = document.getElementById('close_popup');


       optionsBtn.addEventListener("click",(e)=>{
            e.preventDefault();
            popupWindow.style.display = "block";
       })         

       closeWindow.addEventListener("click",(e)=>{
           e.preventDefault();
           popupWindow.style.display = "none";
       })

       window.addEventListener("click",(e)=>{
           if(e.target == popupWindow){
               popupWindow.style.display = "none";
           }
       })


   </script>

  


</body>
</html>




<?php

/* 

Images

https://www.tasteofhome.com/wp-content/uploads/2018/01/Strawberry-Cheesecake_EXPS_FT20_3270_F_0221_1-2.jpg

https://natashaskitchen.com/wp-content/uploads/2020/05/Pefect-Cheesecake-7.jpg

https://cdn.cnn.com/cnnnext/dam/assets/200402031651-shelter-in-place-california-0325-super-tease.jpg

https://cdn.vox-cdn.com/thumbor/h30aDynYighEYIwexdTijwP2NLM=/55x0:944x667/1200x900/filters:focal(55x0:944x667)/cdn.vox-cdn.com/uploads/chorus_image/image/48120265/CapitolPark-115.0.jpg

https://i.etsystatic.com/6772044/r/il/603758/1029288771/il_fullxfull.1029288771_8637.jpg
*/

?>