<?php

session_start();

include('connection.php');

if(isset($_POST['unfollow_btn'])){

    $user_id = $_SESSION['id'];
    $other_user_id = $_POST['other_user_id'];


    $stmt = $conn->prepare("DELETE FROM followings WHERE user_id = ? AND other_user_id = ?");
    $stmt->bind_param("ii",$user_id,$other_user_id);
    
    //decrease number of people I'm following
    $stmt1 = $conn->prepare("UPDATE users SET following=following-1 WHERE id = ?");
    $stmt1->bind_param("i",$user_id);

    //decrease number of followers of that person
    $stmt2 = $conn->prepare("UPDATE users SET followers=followers-1 WHERE id = ?");
    $stmt2->bind_param("i",$other_user_id);


    $stmt->execute();
    $stmt1->execute();
    $stmt2->execute();

    $_SESSION['following'] = $_SESSION['following']-1;

    header("location: profile.php?success_message=You've unfollowed them");




}else{
    header("location: index.php");
    exit;
}

?>