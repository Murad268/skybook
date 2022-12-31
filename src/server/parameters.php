<?php
   include('connect.php');
function minseo ($variable) {
   return htmlspecialchars(trim($variable));
} 

function createActivationCode() {
   $rand = sha1(mt_rand(10000,99999).time());
   return $rand;
}
   if(isset($_SESSION["email"])) {
      $searchUser = $dbh->prepare("SELECT * FROM users WHERE user_email = ?");
      $searchUser->execute([$_SESSION["email"]]);
      $users = $searchUser->fetch(PDO::FETCH_ASSOC);
      $user_email = $users["user_email"];
      $user_login = $users["user_login"];
      $user_id = $users["id"];
   }
?>