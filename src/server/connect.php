<?php
  try {
   $dbh = new PDO('mysql:host=localhost;dbname=skybook', "root", "");
  } catch ( PDOException $e) {
      echo $e->getMessage();
  }
?>