<?php
   $randomMess = $dbh->prepare("SELECT * FROM users ORDER BY RAND() LIMIT 4");
   $randomMess->execute();
   $randomFriends = $randomMess->fetchAll(PDO::FETCH_ASSOC);
?>
<aside class="asideLeft">
   <div class="asideLeft__user">
      <div class="asideLeft__user__icon">
         <img src="assets/users/image.png" alt="">
      </div>
      <div class="asideLeft__user__name">
         <?=$user_login?>
      </div>
   </div>
   <div class="asideLeft__user__messaggess">
      <div class="asideLeft__user__messaggess__top">
         <div class="asideLeft__user__messaggess__top__left">Random dostluqlar</div>
         <div class="asideLeft__user__messaggess__top__right">
            <a onclick="return confirm('çıxmaq istədiyinizdən əminsinizmi?')" href="./exit.php">Çıx</a>
         </div>
      </div>
     <?php
         foreach($randomFriends as $friend) {
            if($friend["id"] != $user_id){?>
             <div class="asideLeft__user__messaggess__body">
               <div class="asideLeft__user__messaggess__body__messagge">
                  <div style="background-color: <?php echo $friend["active"] == 1 ? 'green':'silver'?>;" class="asideLeft__user__messaggess__body__messagge__icon">
                     <?php
                        if($friend["avatar"] == null) {?>
                           <img src="assets/users/image.png" alt="">
                        <?php
                        } else {?>
                           <img src="assets/users/<?php echo $friend["avatar"]?>" alt="">
                        <?php
                        }
                     ?>
                  </div>
                  <div class="asideLeft__user__messaggess__body__messagge__name">
                     <a href="index.php?page=userpage&user=<?php echo $friend["id"]?>"> <?php
                        echo donusumleriGeriDondur($friend["user_login"])
                     ?></a>
                    
                  </div>
               </div>
            </div>
         <?php
         }
      }
     ?>
   </div>
</aside>