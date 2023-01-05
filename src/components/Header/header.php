<nav class="navbar">
   <div class="navbar__logo">
      <img src="assets/icons/logo.png" alt="">
   </div>
   <ul class="navbar__links">
      <li class="navbar__link">
         <a href="index.php"><i class="fa fa-home" aria-hidden="true"></i></a>
      </li>
      <li class="navbar__link">
         <?php
            $fetchrrequest = $dbh->prepare("SELECT * FROM frequests WHERE to_id = ?");
            $fetchrrequest->execute([$user_id]);
            if($fetchrrequest->rowCount() > 0) {?>
               <div class="frequestCount">
                  <?php
                     echo $fetchrrequest->rowCount();
                  ?>
               </div>
            <?php
            }
         ?>
         <a href="index.php?page=friendsrequests"><i class="fa fa-user-friends"></i></a>
      </li>
      <li class="navbar__link">
         <a href="index.php?page=elanlar"><i class="fa-solid fa-shop"></i></a>
      </li>
   </ul>
   <div class="navbar__search">
      <form method="post" action="./src/server/process.php">
         <input placeholder="daxil et" type="search" name="search">
         <button name="tosearch">axtar</button>
      </form>
   </div>
   <ul class="navbar__user">
      <li>
         <a href="">
            <i class="fa-solid fa-bell"></i>
         </a>
      </li>
      <li>
            <?php
               $fetchSeen = $dbh->prepare("SELECT * FROM messaggess WHERE to_id = ? AND seen=0");
               $fetchSeen->execute([$user_id]);
               if($fetchSeen->rowCount()>0) {?>
                <div  div class="frequestCount">
                  <?php
                     echo $fetchSeen->rowCount();
                  ?>
               </div>
               <?php
               }
            ?>
           
         <a href="index.php?page=mess">
            <i class="fab fa-facebook-messenger"></i>
         </a>
      </li>
      <li>
         <a href="index.php?page=friendspage">
            <i class="fa-solid fa-user-group"></i>
         </a>
      </li>
      <li class="user__icon">
         <a href="index.php?page=mypage">
            <?php
               if($user_avatar != null) {?>
                  <img src="assets/users/<?php echo $user_avatar?>" alt="">
               <?php
               } else {?>
                  <img src="assets/users/image.png" alt="">
               <?php
               }
            ?>
         </a>
      </li>
   </ul>
</nav>