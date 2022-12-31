<?php
function minseo ($variable) {
   return htmlspecialchars(trim($variable));
} 

function createActivationCode() {
   $rand = sha1(mt_rand(10000,99999).time());
   return $rand;
}
   if(isset($_SESSION["email"])) {
      $user_email = $_SESSION["email"];
   }
?>