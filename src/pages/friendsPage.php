<?php
  include('./src/components/Header/header.php');
  include("./src/components/AsideLeft/AsideLeft.php");
  $friendsSorgu = $dbh->prepare("SELECT * FROM friends WHERE friend_first = ? OR friend_second = ?");
  $friendsSorgu->execute([$user_id, $user_id]);
  $friends = $friendsSorgu->fetchAll(PDO::FETCH_ASSOC);
  
?>
  <div class="friends__main">
   <div></div>
   
   <?php
      if($friendsSorgu->rowCount() > 0) {
         ?>
            <div class="friends__main__list">
            <h5 class="friends__main__header">
               Dostlarınız
            </h5>
               <?php
                  foreach($friends as $friend) {
                     if($friend['friend_first'] == $user_id){
                        $id = $friend['friend_second'];
                     } else {
                        $id = $friend['friend_first'];
                     }
                     $fetchFriend = $dbh->prepare("SELECT user_login, avatar, id FROM users WHERE id = ?");
                     $fetchFriend->execute([$id]);
                     $friend = $fetchFriend->fetch(PDO::FETCH_ASSOC);
                     ?>
                  <?php
                  }
               ?>
            <div class="friends__main__friend">
               <div class="friends__main__friend__img">
                  <?php
                     if( $friend["avatar"] == null) {?>
                        <img src="assets/users/image.png" alt="">
                     <?php
                     } else {?>
                        <img src="assets/users/<?php echo $friend["avatar"] ?>" alt="">
                     <?php
                     }
                  ?>
               </div>
               <div class="friends__main__friend__name">
                  <a href="index.php?page=userpage&user=<?php echo $friend["id"]?>"><?php echo donusumleriGeriDondur($friend["user_login"])?></a>
               </div>
            </div>
         </div>
            <?php
         } else {?>
            <div class="no__friend">
            <h5 class="friends__main__header">
               Dostlarınız
            </h5>
               Hazırda heç bir dostunuz yoxdur
            </div>
         <?php

         }
   ?>
   <div> </div>
<?php
   include("./src/components/AsideRight/AsideRight.php");
?>
</div>

