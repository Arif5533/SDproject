<?php

session_start();


//if user id is in session, then user is logged in
if(isset($_SESSION['id'])){
    header("location: index.php");
    exit;

}



?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>



    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    <link rel="stylesheet" href="assets/css/style.css"/>



</head>
<body>


    <div class="container">
        <div class="main-container">

            <div class="main-content">
                <div class="slide-container" style="background-image: url('assets/imgs/frame.png');">
                    <div class="slide-content" id="slide-content">
                       <img src="assets/imgs/screen1.jpeg" class="active" alt="screen1">
                       <img src="assets/imgs/screen2.jpeg" alt="screen2">
                       <img src="assets/imgs/screen3.jpeg" alt="screen3">
                       <img src="assets/imgs/screen4.jpeg" alt="screen4">
                    </div>
                  </div>
                  <div class="form-container">
                      <div class="form-content box">
                          <div class="logo">
                              <img src="assets/imgs/logo.png" class="logo-img" alt="">
                          </div>
                          <form class="login-form" id="login-form" method="POST" action="process_login.php">


                          <?php if(isset($_GET['error_message'])){  ?>
                              <p id="error_message" class="text-center alert-danger"> <?php echo $_GET['error_message']; ?> </p>
                          <?php } ?>

                         


                              <div class="form-group">
                                  <div class="login-input">
                                      <input type="text" name="email" placeholder="Type your email address..." required>
                                  </div>
                              </div>
                              <div class="form-group">
                                <div class="login-input">
                                    <input type="password" name="password" id="password" placeholder="Type your password..." requird>
                                </div>
                             </div>
                             <div class="btn-group">
                                 <button class="login-btn" id="login_btn" name="login_btn" type="submit">Log In</button>
                             </div>
                          </form>
                          <div class="or">
                              <hr/>
                               <span>OR</span>
                              <hr/>
                          </div>
                          <div class="goto">
                              <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
                          </div>
                          <div class="app-download">
                              <p>Get the app.</p>
                              <div class="store-link">
                                  <a href="#">
                                      <img src="assets/imgs/store.png" alt="">
                                  </a>
                                  <a href="#">
                                      <img src="assets/imgs/gbs.png" alt="">
                                  </a>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
            </div>
        


        <div class="footer">
            <div class="links" id="links">
                <a href="#">About</a>
                <a href="#">Blog</a>
                <a href="#">Jobs</a>
                <a href="#">Help</a>
                <a href="#">Privacy</a>
                <a href="#">API</a>
                <a href="#">Terms</a>
                <a href="#">Top Accounts</a>
                <a href="#">Hashtags</a>
                <a href="#" id="dark-btn">Dark</a>
            </div>
            <div class="copyright">
                @ Snapweb from Aust
            </div>
        </div>
    </div>



    <script>



    setInterval(()=>{changeImage();}, 1000);




            function changeImage(){
                var images =  document.getElementById('slide-content').getElementsByTagName('img');

                    var i = 0;


                    for(i=0; i<images.length; i++){
                        var image = images[i];

                        if(image.classList.contains('active')){
                            //remove active class from this image
                            image.classList.remove('active');

                            //if we are at the last iteration, then go back to first image
                            if( i == images.length - 1){
                                var nextImage = images[0];
                                nextImage.classList.add('active');
                                break;

                            }

                                var nextImage = images[i+1];
                                nextImage.classList.add('active');
                                break;
                        }
                    }

            }

                
            function changeMode(){
                var body = document.getElementsByTagName('body')[0]; 
                var footerLinks = document.getElementById('links').getElementsByTagName('a');//[]

                //if we are currently using dark mode
                if(body.classList.contains('dark')){
                    body.classList.remove('dark');

                    for(let i=0; i<footerLinks.length; i++){
                        footerLinks[i].classList.remove('dark-mode-link');
                    }

                }else{
                    //we're currently using the light
                    body.classList.add('dark');

                    for(let i=0; i<footerLinks.length; i++){
                        footerLinks[i].classList.add('dark-mode-link');
                    }
                }
            }
            


            function verifyForm(){

                var password = document.getElementById('password').value;
                var error_message = document.getElementById('error_message');


                if(password.length < 6){
                    error_message.innerHTML = "Password is too short";
                    return false;
                }

                

                return true;

            }

            

         document.getElementById('dark-btn').addEventListener('click',(e)=>{
                e.preventDefault();

                changeMode();

         })   

        //  document.getElementById('login-form').addEventListener('submit',(e)=>{
        //      e.preventDefault();

        //      verifyForm();
        //  })


    </script>


    
</body>
</html>