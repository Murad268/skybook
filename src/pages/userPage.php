
<?php
   $reqFetch = $dbh->prepare("SELECT * FROM frequests WHERE to_id = ? AND from_id = ?");
   $reqFetch->execute([$_GET["user"], $user_id]);
   if($reqFetch->rowCount() > 0) {?>
      <a>dostluq at</a>
   <?php
   } else {?>
      <a href="./src/server/process.php?frrequest=addfriend&user_id=<?php echo $_GET["user"]?>">dostluq at</a>
   <?php
   }
   
?>
