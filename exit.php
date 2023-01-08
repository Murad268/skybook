<?php
   session_start();
   include ("./src/server/connect.php");
   include ('./src/server/parameters.php');
   $activateUserActive = $dbh->prepare("UPDATE users SET active=? WHERE id=? AND status = ?");
   $activateUserActive->execute([0, $user_id, 1]);
   if($activateUserActive->rowCount() > 0) {
      unset ($_SESSION['email']);
      header("Location: ./index.php");
   }

?>