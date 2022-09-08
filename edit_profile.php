

<?php include("header.php"); ?>


   <section class="main" style="margin-top: 0;">
       <div class="wrapper">
        <div class="left-col">

            <h3 class="text-center">Update profile</h3>

            <?php if(isset($_GET['error_message'])){ ?>
                <p class="text-center alert-danger"><?php echo $_GET['error_message'];?></p>
            <?php } ?>    

            <form action="update_profile.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <img src="<?php echo "assets/imgs/".$_SESSION['image']; ?>" class="edit-profile-image" alt="">
                    <input type="file" name="image" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <p class="form-control">Email</p>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" id="username" placeholder="username" required 
                          value="<?php echo $_SESSION['username'] ?>"/> 
                </div>
                <div class="mb-3">
                    <label for="bio" class="form-label">Bio</label>
                    <textarea name="bio" id="bio" class="form-control" cols="30" rows="3"><?php echo $_SESSION['bio']; ?>
                    </textarea>
                </div>
                <div class="mb-3">
                    <input name="update_profile_btn" id="update_profile_btn" type="submit" class="update-profile-btn" value="Update">
                </div>
            </form>
            
        </div>

       
        <div class="right-col">

            <!--Profile card-->
            <?php include("profile_card.php");?>
          


            <!--Suggestions-->
            <?php include("suggestion_side_area.php");?>
          
           

          </div>


        
       </div>
   </section>







</body>
</html>