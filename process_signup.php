<?php


session_start();

include('connection.php');


if(isset($_POST['signup_btn'])){


    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];


    //make sure passwords match
    if($password != $password_confirm){
        header('location: signup.php?error_message=passwords dont match');
        exit;
    }

    //check whether user already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss",$username,$email);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows() > 0){
        header("location: signup.php?error_message=User already exists");
        exit;
    }else{
        $stmt = $conn->prepare("INSERT INTO users (username,email,password) VALUES (?,?,?)");
        $stmt->bind_param("sss",$username,$email,md5($password));

        //if user created successfully then return user info
        if($stmt->execute()){
        $stmt = $conn->prepare("SELECT id, username,email,image,following,followers,posts, bio FROM users WHERE username = ?");
        $stmt->bind_param("s",$username);
        $stmt->execute();
        $stmt->bind_result($id,$username,$email,$image,$following,$followers,$posts,$bio);
        $stmt->fetch();

        $_SESSION['id']=$id;
        $_SESSION['username']=$username;
        $_SESSION['email']=$email;
        $_SESSION['image']=$image;
        $_SESSION['following']=$following;
        $_SESSION['followers']=$followers;
        $_SESSION['posts']=$posts;
        $_SESSION['bio']=$bio;

        header("location: index.php");

        }else{
            header('location: signup.php?error_message=error occured');
            exit;
        }
    }




       


}else{

  header("location: signup.php?error_message=error occured");

}




?>