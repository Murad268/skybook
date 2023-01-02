<?php
  include('./src/components/Header/header.php');
  include("./src/components/AsideLeft/AsideLeft.php");
   if(isset($_REQUEST["sayfalama"])) {
      $sayfalama = $_REQUEST["sayfalama"];
   } else {
      $sayfalama = 1;
   }
   if(isset($_REQUEST["post"]) and isset($_REQUEST["page"])) {
      $postR = $_REQUEST["post"];
      $page = $_REQUEST["page"];
      $sayfalamaKosulu = "&page=$page"."&post=".$postR;
   } else {
      $sayfalamaKosulu = "";
   }
   $sayfalamaIcinButonSayisi = 2;
   $sayfaBasinaGosterilecek = 10;
   $toplamKayitSayisiSorgusu = $dbh->prepare("SELECT * FROM comments");
   $toplamKayitSayisiSorgusu->execute();
   $toplamKayitSayisi = $toplamKayitSayisiSorgusu->rowCount();
   $sayfalamayBaslayacaqKayotSayisi = ($sayfalama*$sayfaBasinaGosterilecek) - $sayfaBasinaGosterilecek;
   $bulunanSafyaSayisi = ceil($toplamKayitSayisi/$sayfaBasinaGosterilecek);
  ?>

  <div class="comments__main">
   <div></div>
   <div class="comments__main__content">
      <?php
         $findPost = $dbh->prepare("SELECT * FROM posts WHERE id = ?");
         $findPost->execute([$post_id]);  
         $post = $findPost->fetch(PDO::FETCH_ASSOC);
         $fetchComments = $dbh->prepare("SELECT * FROM comments WHERE post_id = ? LIMIT $sayfalamayBaslayacaqKayotSayisi, $sayfaBasinaGosterilecek");
         $fetchComments->execute([$post["id"]]);
      ?>
       <div id="post__wrapper">
               <?php
                  $getNemeFetch = $dbh->prepare("SELECT * FROM users WHERE id = ?");
                  $getNemeFetch->execute([$post["user_id"]]);
                  $getName = $getNemeFetch->fetch(PDO::FETCH_ASSOC);
               ?>
               <header class="cf">
                  <img src="http://2016.igem.org/wiki/images/e/e0/Uclascrolldown.png" class="arrow" />
                   <?php
                     if($getName["avatar"] == null) {?>
                        <a href=#><img class='profile-pic' src="<?php echo 'assets/users/image.png'?>"></a>
                     <?
                     }
                   ?>
                   <h1 class="name">
                     <a href="#"><?php echo donusumleriGeriDondur($getName["user_login"])?></a>
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
                     $searchLike = $dbh->prepare("SELECT * FROM likes WHERE  post_id = ?");
                     $searchLike->execute([$post["id"]]);
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
            
               </div>
             
             </div>  
             <div class="add__comment">
               <form method="post" action="./src/server/process.php">
                  <input value="<?php echo $post["id"]?>" type="hidden" name="post_id">
                  <input name="comment" placeholder="şərhi daxil eləyin" type="text">
                  <button name="add_comment" class="btn btn-success">əlavə et</button>
               </form>
             </div>
            <?php
               if($fetchComments->rowCount() > 0) {?>
                 <div class="comment__aside">
                     <?php
                        $comments = $fetchComments->fetchAll(PDO::FETCH_ASSOC);
                        foreach($comments as $comment) {
                           $getNemeFetch = $dbh->prepare("SELECT * FROM users WHERE id = ?");
                           $getNemeFetch->execute([$comment["user_id"]]);
                           $getName = $getNemeFetch->fetch(PDO::FETCH_ASSOC);?>
                           <div class="comment__aside__c">
                              <div class="comment__aside__c__top">
                                 <div class="comment__aside__c__img">
                                 <?php
                                    if($getName["avatar"] == null) {?>
                                       <a href=#><img class='profile-pic' src="<?php echo 'assets/users/image.png'?>"></a>
                                    <?
                                    }
                                 ?>
                                 </div>
                                 <div class="comment__aside__c__name">
                                    <a href=""><?php echo donusumleriGeriDondur($getName["user_login"]) ?></a>
                                 </div>
                              </div>
                              <div class="comment__aside__c__comment">
                                 <?php
                                    echo donusumleriGeriDondur($comment["comment"]);
                                 ?>
                              </div>
                           </div>
                        <?php
                        }
                     ?>
               
             </div> 
               <?php
               }
            ?>
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
      </div>
     

   <?php
      include("./src/components/AsideRight/AsideRight.php");
   ?>
  </div>

  <?php
  
?>