<?php
  include('./src/components/Header/header.php');
  include("./src/components/AsideLeft/AsideLeft.php");
  $fetchMess = $dbh->prepare("SELECT * FROM messlist WHERE from_id = ? OR to_id = ?");
  $fetchMess->execute([$user_id, $user_id]);
  $mess =  $fetchMess->fetchAll(PDO::FETCH_ASSOC);
?>
  <div class="mess__main">
   <div></div>
   <div class="mess__main__users">
     
      <?php
         foreach( $mess as $message) {
            if($message["to_id"] == $user_id) {
               $id = $message["from_id"];
            } else {
               $id = $message["to_id"];
            }
            $getNemeFetch = $dbh->prepare("SELECT * FROM users WHERE id = ?");
            $getNemeFetch->execute([$id]);
            $getName = $getNemeFetch->fetch(PDO::FETCH_ASSOC);
            $fetch = $dbh->prepare("SELECT * FROM messaggess WHERE (to_id = ? AND from_id = ?) OR (from_id=? AND to_id=?) ORDER BY id DESC LIMIT 1");
            $fetch->execute([$user_id, $id, $user_id, $id]);
            $fetchEd = $fetch->fetch(PDO::FETCH_ASSOC);
            if($fetchEd["from_id"] == $user_id) {
               $who = "məndən";
            } else {
               $who = "ondan";
            }
            ?>
          
            <div class="mess__main__user">
               <div class="mess__main__user__top">
                  <div class="mess__main__user__img">
                     <?php
                        if($getName["avatar"] == null) {?>
                           <a href=#><img class='profile-pic' src="<?php echo 'assets/users/image.png'?>"></a>
                        <?
                        } else {?>
                           <a href=#><img class='profile-pic' src="<?php echo 'assets/users/'.$getName["avatar"]?>"></a>
                        <?php
                        }
                     ?>
                  </div>
                  <div class="mess__main__user__name">
                     <a href="index.php?page=userpage&user=<?php echo $getName["id"]?>">
                        <?php echo donusumleriGeriDondur($getName["user_login"])?>
                     </a>
                  </div>
               </div>
               <div class="mess__main__user__text">
                  <a href="index.php?page=messagespage&message=<?php echo $id?>">
                     <?php
                        echo donusumleriGeriDondur($fetchEd["mess"])
                     ?>
                  </a>
               </div>
               <div class="sendTime">
                  <div>
                  <?php
                     echo time_elapsed_string($fetchEd["sendtime"])
                  ?>
                  </div>
                  <div>
                  <?php
                     echo $who
                  ?>
                  </div>
               </div>
            </div>
         <?php
         }
      ?>
   
   </div>
<?php
   include("./src/components/AsideRight/AsideRight.php");
?>
   </div>

