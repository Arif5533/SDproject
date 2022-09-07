<?php


session_start();

// if user id is not in session, then they are not logged in
if(!isset($_SESSION['id'])){
    header("location: login.php");
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


    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>


</head>
<body>
    

    
   <nav class="navbar">
       <div class="nav-wrapper">
           <img src="assets/imgs/logo.png" class="brand-img"/>
           <form class="search-form" action="search_posts.php" method="POST">
            <input type="text" class="search-box" placeholder="search" name="search_input"/>
           </form>
           <div class="nav-items">
            <a href="index.php" style="color: #000;"><i class="icon fas fa-home"></i></a>
            <a href="discover.php" style="color: #000;"><i class="icon fas fa-plus"></i></a>
            <a href="liked_posts.php" style="color: #000;"><i class="icon fas fa-heart"></i></a>
            <div class="icon user-profile">
               <a href="profile.php" style="color: #000;"><i class="fas fa-user"></i></a> 
            </div>
           </div> 
       </div>
   </nav>



   