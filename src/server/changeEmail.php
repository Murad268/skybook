<?php
   session_start();
   include('connect.php');
   $searchUser = $dbh->prepare("SELECT * FROM users WHERE user_email = ? AND activation_code = ? AND status = ?");
   $searchUser->execute([$_GET["email"], $_GET['code'], 0]);
   $count = $searchUser->rowCount();
   if($count>0) {
      $activateUser = $dbh->prepare("UPDATE users SET status=? WHERE user_email=?");
      $activated = $activateUser->execute([1, $_GET["email"]]);
      if($activated) {
         $_SESSION["user_reg"] = "Hesabınız təstiqləndi";
         header("Location: ../../autofication.php");
         exit();
      }
   }
?>