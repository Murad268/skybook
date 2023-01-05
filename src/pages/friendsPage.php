<?php
  include('./src/components/Header/header.php');
  include("./src/components/AsideLeft/AsideLeft.php");
   if(isset($_REQUEST["sayfalama"])) {
      $sayfalama = $_REQUEST["sayfalama"];
   } else {
      $sayfalama = 1;
   }
   if(isset($_REQUEST["page"])) {
      $page = $_REQUEST["page"];
      $sayfalamaKosulu = "&page=$page";
   } else {
      $sayfalamaKosulu = "";
   }

  $sayfalamaIcinButonSayisi = 2;
  $sayfaBasinaGosterilecek = 10;
  $toplamKayitSayisiSorgusu = $dbh->prepare("SELECT * FROM friends WHERE friend_first = ? OR friend_second = ?");
  $toplamKayitSayisiSorgusu->execute([$user_id, $user_id]);
  $toplamKayitSayisi = $toplamKayitSayisiSorgusu->rowCount();
  $sayfalamayBaslayacaqKayotSayisi = ($sayfalama*$sayfaBasinaGosterilecek) - $sayfaBasinaGosterilecek;
  $bulunanSafyaSayisi = ceil($toplamKayitSayisi/$sayfaBasinaGosterilecek);


  $friendsSorgu = $dbh->prepare("SELECT * FROM friends WHERE friend_first = ? OR friend_second = ? LIMIT $sayfalamayBaslayacaqKayotSayisi, $sayfaBasinaGosterilecek");
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
         <nav aria-label="Page navigation example">
         <?php
               if($bulunanSafyaSayisi>1) {?>
                  <div class="paginationWrapper">
                     <nav aria-label="Page navigation example ">
                        <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="?sayfalama=1<? echo $sayfalamaKosulu?>">&laquo;</a></li>
                        <?php
                           for($i = $sayfalama-$sayfalamaIcinButonSayisi; $i <= $sayfalama+$sayfalamaIcinButonSayisi; $i++) {
                              if(($i > 0) and ($i <= $bulunanSafyaSayisi)) {
                                 $curr = $i;
                              if($sayfalama == $i) {
                                 echo "<li style=\"cursor: pointer\" class=\"page-item\"><div style=\"background: red; color: white\" class=\"page-link\">$curr</div></li>";
                              } else {
                                 echo "<li class=\"page-item\"><a class=\"page-link\" href=\"?sayfalama=$curr$sayfalamaKosulu\">$curr</a></li>";
                              }
                           }
                        }
                        ?>
                           
                           <li class="page-item"><a class="page-link"  href="?sayfalama=<?=$bulunanSafyaSayisi.$sayfalamaKosulu?>">&raquo;</a></li>
                        </ul>
                     </nav>
                  </div>
               <?php
               }
            ?>
      </nav>
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

