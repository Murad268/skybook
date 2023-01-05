<?php
  include('./src/components/Header/header.php');
  $userFetch = $dbh->prepare("SELECT * FROM users WHERE id = ?");
  $userFetch->execute([$_GET["user"]]);
  $user = $userFetch->fetch(PDO::FETCH_ASSOC); 


   if(isset($_REQUEST["sayfalama"])) {
      $sayfalama = $_REQUEST["sayfalama"];
   } else {
      $sayfalama = 1;
   }
   if(isset($_REQUEST["page"])) {
      $page = $_REQUEST["page"];
      $users = $_GET["user"];
      $sayfalamaKosulu = "&page=$page&user=$users";
   } else {
      $sayfalamaKosulu = "";
   }
   $sayfalamaIcinButonSayisi = 2;
   $sayfaBasinaGosterilecek = 10;
   $toplamKayitSayisiSorgusu = $dbh->prepare("SELECT * FROM posts WHERE user_id = ?");
   $toplamKayitSayisiSorgusu->execute([$_GET["user"]]);
   $toplamKayitSayisi = $toplamKayitSayisiSorgusu->rowCount();
   $sayfalamayBaslayacaqKayotSayisi = ($sayfalama*$sayfaBasinaGosterilecek) - $sayfaBasinaGosterilecek;
   $bulunanSafyaSayisi = ceil($toplamKayitSayisi/$sayfaBasinaGosterilecek);
   $fetchPosts = $dbh->prepare("SELECT * FROM posts WHERE user_id = ? LIMIT $sayfalamayBaslayacaqKayotSayisi, $sayfaBasinaGosterilecek");
   $fetchPosts->execute([$_GET["user"]]);
   $posts = $fetchPosts->fetchAll(PDO::FETCH_ASSOC);
   $fethElanlar = $dbh->prepare("SELECT * FROM elanlar WHERE user_id = ? ORDER BY create_time ");
   $fethElanlar->execute([$_GET["user"]]);
?>

  <main class="userPage__main">
      <div class="userPage__main__top">
         <div class="userPage__main__top__image">
            <?php
               if($user["avatar"] != null) {?>
                  <img src="assets/users/<?php echo $user["avatar"]?>" alt="">
               <?php
               } else {?>
                  <img src="assets/users/image.png" alt="">
               <?php
               }
            ?>
            <div class="user__btns">
               <a class="btn btn-primary sendMess sendmessbtn">Mesaj yaz</a>
               <?php
                   $friendReqSearch = $dbh->prepare("SELECT * FROM frequests WHERE to_id = ? AND from_id = ?");
                   $friendReqSearch->execute([$_GET["user"], $user_id]);
                   $req = $friendReqSearch->fetch(PDO::FETCH_ASSOC);

                   $friendSearch = $dbh->prepare("SELECT * FROM friends WHERE (friend_first = ? AND friend_second = ?) OR (friend_second = ? AND  friend_first = ?)");
                   $friendSearch->execute([$user_id, $_GET["user"], $user_id, $_GET["user"]]);
                   $friendreq = $friendSearch->fetch(PDO::FETCH_ASSOC);

                   $confirmReq = $dbh->prepare("SELECT * FROM frequests WHERE to_id = ? AND from_id = ?");
                   $confirmReq->execute([$user_id, $_GET["user"]]);
                   $confirm = $confirmReq->fetch(PDO::FETCH_ASSOC);


                   $user_id = $_GET["user"];
                   if($friendReqSearch->rowCount()>0) {
                     ?>
                        <a href="./src/server/process.php?frrequest=cancelfriend&req_id=<?php echo $req["id"]?>" class="btn btn-warning sendMess">Dostluq istəyini geri çək</a>
                     <?php
                 
                   } elseif($friendSearch->rowCount()>0) {?>
                        <a onclick="return confirm('bu istifadəçini dostluqdan silmək istədiyinizdən əminsinizmi?')" href="./src/server/process.php?frrequest=deletefriend&req_id=<?php echo $friendreq["id"]?>" class="btn btn-danger">dostluqdan sil</a>
                   <?php
                   }elseif($confirmReq->rowCount()) {?>
                     <a onclick="return confirm('dostluq istəyini qəbul etmək istədiyinizdən əminsiniz?')" href="./src/server/process.php?frrequest=confirmfriend&req_id=<?php echo $confirm["id"]?>" class="btn btn-info sendMess">Dostluq istəyini qəbul et</a>
                   <?php
                   } else {?>
                     <a onclick="return confirm('bu istifadəçiyə dostluq istəyi göndərmək istədiyinizdən əminsiniz?')" href="./src/server/process.php?frrequest=addfriend&user_id=<?php echo $user_id?>" class="btn btn-success sendMess">Dostluq istəyini göndər</a>
                   <?php
                   }
               ?>
            </div>
            <div class="user__elanlar__top">
                  İstifadəçinin elanları
            </div>
            <div class="user__elanlar <?php echo $fethElanlar->rowCount()>3?'user__elanlar__scroll':''?>">
     
            <?php
   
               $elanlar = $fethElanlar->fetchAll(PDO::FETCH_ASSOC);
               $elanSayi = $fethElanlar->rowCount();
               if($elanSayi==0) {
                  echo "Hazırda heç bir elan yoxdur";
               }
               foreach($elanlar as $elan) {?>
                  <div class="elan">
                     <div class="elan__top">
                        <div class="elan__image">
                           <img src="assets/images/elanlar/<?php echo $elan["elan_img"]?>" alt="">
                        </div>
                        <div class="elan__title">
                        <?php
                           echo donusumleriGeriDondur($elan["elan_title"])
                        ?>
                        </div>
                     </div>
                     <div class="elan__src">
                        <?php
                           echo mb_substr(donusumleriGeriDondur($elan["elan_desc"]), 0, 20);
                        ?>
                     <a href="index.php?page=elan&<?php echo "elan_id=".$elan["id"]?>">...</a>
                     </div>
                     <?php
                        if($elan["user_id"] == $user_id) {?>
                           <div class="elan_sil">
                              <a onclick="return confirm('elanı silmək istədiyinizdən əminsinizmi?')" href="./src/server/process.php?deleteelan=true&id=<?php echo $elan["id"]?>"><i class="fa fa-window-close" aria-hidden="true"></i></a>
                           </div>
                        <?
                        }
                     ?>
                     
                  </div>
               <?php
               }
            ?>
            </div>
         </div>
         <div class="userPage__main__top__name"><?php echo $user["user_login"]?></div>
      </div>
      <div class="userPage__main__posts ">
         <div class="userPage__main__posts__main <?php echo $fetchPosts->rowCount() > 3? 'postScroll':'' ?>">
         <?php
            foreach($posts as $post) {?>
               <div id="post__wrapper">
                  <?php
                     $getNemeFetch = $dbh->prepare("SELECT * FROM users WHERE id = ?");
                     $getNemeFetch->execute([$post["user_id"]]);
                     $getName = $getNemeFetch->fetch(PDO::FETCH_ASSOC);
                  ?>
                  <header class="cf">
                  <div class="dropdown">
                     <div class="drowpBtn btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="http://2016.igem.org/wiki/images/e/e0/Uclascrolldown.png" class="arrow" />
                     </div>
                     <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <?php
                           if($post["user_id"] == $user_id) {?>
                              <li><a onclick="return confirm('postu silmək istədiyinizdən əminsinizmi?')" class="dropdown-item" href="./src/server/process.php?commentprocess=delete&id=<?php echo $post["id"]?>">Sil</a></li>
                           <?php
                           }
                        ?>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                     </ul>
                  </div>
                     <?php
                        if($getName["avatar"] == null) {?>
                           <a href=#><img class='profile-pic' src="<?php echo 'assets/users/image.png'?>"></a>
                        <?
                        } else {?>
                           <a href=#><img class='profile-pic' src="<?php echo 'assets/users/'.$getName["avatar"]?>"></a>
                        <?php
                        }
                     ?>
                     <h1 class="name">
                        <a href="index.php?page=userpage&user=<?php echo $post["user_id"] ?>"><?php echo donusumleriGeriDondur($getName["user_login"])?></a>
                     </h1>
                     <p class="date"><?php echo time_elapsed_string($post["create_time"])?></p>
                  </header>
                  <p class="status"><?php echo donusumleriGeriDondur($post["post"])?></p>
                  <?php
                     if($post["img"] != null) {?>
                        <img class="img-content" src="<?php echo 'assets/images/posts/'.$post["img"]?>" />
                     <?php
                     }
                  ?>
                  <div class="action">
                     <?php
                        $searchLike = $dbh->prepare("SELECT * FROM likes WHERE user_id = ? AND post_id = ?");
                        $searchLike->execute([$user_id, $post["id"]]);
                        $likedCount = $searchLike->rowCount();
                        $searchPostInLikes= $dbh->prepare("SELECT * FROM likes WHERE post_id = ?");
                        $searchPostInLikes->execute([$post["id"]]);
                        $postLikes = $searchPostInLikes->rowCount();
                        if($likedCount>0) {?>
                           <div class="like">
                              <a href="./src/server/process.php?post_id=<?php echo $post["id"] ?>&likeprocess=unlike">
                              <i style="color: blue" class="fa fa-thumbs-up" aria-hidden="true"></i>
                                 <p><?php echo $postLikes?></p>
                              </a>
                           </div>
                        <?php
                        } else {?>        
                        <div class="like">
                              <a href="./src/server/process.php?post_id=<?php echo $post["id"] ?>&likeprocess=like">
                              <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                 <p><?php echo $postLikes?></p>
                              </a>
                           </div>
                        <?php
                        }
                     ?>
                  
                     <div class="comment">
                        <?php
                           $countCommentsFetch = $dbh->prepare("SELECT * FROM comments WHERE post_id = ?");
                           $countCommentsFetch->execute([$post["id"]]);
                        ?>
                        <a href="?page=comments&post=<?php echo $post["id"]?>">
                           <i class="fa fa-comment" aria-hidden="true"></i>
                           <p><?php echo  $countCommentsFetch->rowCount()?></p>
                        </a>
                     </div>
                  </div>
               </div>   
            <?php
            }
         ?>
         </div>
         <div>
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
         </div>
      </div>
 
  </main>


   <div class="writeMess__modal">  
      <div class="writeMess__modal__block">
            <i class="fa fa-window-close" aria-hidden="true"></i>
            <form method="post" action="./src/server/process.php">
               <div class="form-floating">
                  <input type="hidden" value="<?php echo $_GET["user"]?>" name="id">
                  <textarea name="mess" class="form-control" placeholder="Leave a comment here" id="floatingTextarea"></textarea>
                  <label for="floatingTextarea">Mesaj</label>
                  <button name="sendmess" class="mt-3 btn btn-success">Göndər</button>
               </div>
            </form>
      </div>
   </div>

   <script>
      document.querySelector(".sendmessbtn").addEventListener("click", () => {
         document.querySelector(".writeMess__modal").classList.add("writeMess__modal__active");
      })
      document.querySelector(".writeMess__modal__block i").addEventListener("click", () => {
         document.querySelector(".writeMess__modal").classList.remove("writeMess__modal__active");
      })
   </script>