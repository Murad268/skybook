<?php
  include('./src/components/Header/header.php');
  include("./src/components/AsideLeft/AsideLeft.php");
  $fethMessages = $dbh->prepare("SELECT * FROM messaggess WHERE (to_id=? AND from_id=?) OR (from_id=? AND to_id=?)");
  $fethMessages->execute([$user_id, $_GET["message"], $user_id, $_GET["message"]]);
  $messages = $fethMessages->fetchAll(PDO::FETCH_ASSOC);
  $getNemeFetch = $dbh->prepare("SELECT * FROM users WHERE id = ?");
  $getNemeFetch->execute([$_GET['message']]);
  $getName = $getNemeFetch->fetch(PDO::FETCH_ASSOC);
?>
  <div class="messsagesPage__main">
   <div></div>
   <div class="messsagesPage__main__list">
   <h2>
      <a href="index.php?page=userpage&user=<?php echo $getName["id"]?>">
         <?php
            echo donusumleriGeriDondur($getName["user_login"]);
         ?>
      </a>
   </h2>
      <?php
         foreach($messages as $message) {
            if($message["from_id"] == $user_id) {?>
             <div class="bg-success messsagesPage__main__list__to">
                  <?php
                     echo donusumleriGeriDondur($message["mess"])
                  ?>
            </div>
            <?php
           
            } else {?>
               <div class="bg-info messsagesPage__main__list__from">
                  <?php
                     echo donusumleriGeriDondur($message["mess"])
                  ?>
               </div>
            <?php
            }
         }
      ?>
      
     
   </div>
<?php
   include("./src/components/AsideRight/AsideRight.php");
?>
</div>

