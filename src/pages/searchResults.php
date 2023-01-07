<?php
  include('./src/components/Header/header.php');
  include("./src/components/AsideLeft/AsideLeft.php");
  $fetchSearch = $dbh->prepare("SELECT * FROM users WHERE user_login LIKE ?");
  $q = $_GET["query"];
  $fetchSearch->execute(["%".$q."%"]);
  $result =  $fetchSearch->fetch(PDO::FETCH_ASSOC);
  $fetchPost = $dbh->prepare("SELECT * FROM posts WHERE post LIKE ?");
  $fetchPost->execute(["%".$q."%"]);
  $resultsPosts =  $fetchPost->fetchAll(PDO::FETCH_ASSOC);
  $fethElanlar = $dbh->prepare("SELECT * FROM elanlar WHERE elan_title LIKE ? OR elan_desc LIKE ?");
  $fethElanlar->execute(["%".$q."%", "%".$q."%"]);
  $elanlar = $fethElanlar->fetchAll(PDO::FETCH_ASSOC);
  $elanSayi = $fethElanlar->rowCount();
?>
  <div class="search__main">
      <div></div>
      <div>
         <div class="search__main__users">
            <div class="div_user">Tapılan istafadəçilər</div>
            <?php
               if($fetchSearch->rowCount() > 0) {?>
                <div class="search__main__user">
                  <div class="search__main__user__img">
                     <img src="assets/users/image.png" alt="">
                  </div>
                  <div class="search__main__user__name"><a href="index.php?page=userpage&user=<?php echo $result["id"]?>"><?php echo $result["user_login"]?></a></div>
               </div>
               <?php
               } else {?>
                  <div class="npResult">
                     Heç bir istifadəçi tapılmadı
                  </div>   
               <?php
               }
            ?>
         </div>
         <div class="search__main__posts">
            <div class="div_user">Tapılan postlar</div>
            <?php
               if($fetchPost->rowCount() > 0) {?>
               <?php
                  foreach($resultsPosts as $result) {?>
                     <div id="post__wrapper">
                        <?php
                           $getNemeFetch = $dbh->prepare("SELECT * FROM users WHERE id = ?");
                           $getNemeFetch->execute([$result["user_id"]]);
                           $getName = $getNemeFetch->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <header class="cf">
                        <div class="dropdown">
                           <div class="drowpBtn btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                              <img src="http://2016.igem.org/wiki/images/e/e0/Uclascrolldown.png" class="arrow" />
                           </div>
                           <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                              <?php
                                 if($result["user_id"] == $user_id) {?>
                                    <li><a onclick="return confirm('postu silmək istədiyinizdən əminsinizmi?')" class="dropdown-item" href="./src/server/process.php?commentprocess=delete&id=<?php echo $result["id"]?>">Sil</a></li>
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
                              }
                           ?>
                           <h1 class="name">
                              <a href="#"><?php echo donusumleriGeriDondur($getName["user_login"])?></a>
                           </h1>
                           <p class="date"><?php echo time_elapsed_string($result["create_time"])?></p>
                        </header>
                        <p class="status"><?php echo donusumleriGeriDondur($result["post"])?></p>
                        <?php
                           if($result["img"] != null) {?>
                              <img class="img-content" src="<?php echo 'assets/images/posts/'.$result["img"]?>" />
                           <?php
                           }
                        ?>
                        <div class="action">
                           <?php
                              $searchLike = $dbh->prepare("SELECT * FROM likes WHERE user_id = ? AND post_id = ?");
                              $searchLike->execute([$user_id, $result["id"]]);
                              $likedCount = $searchLike->rowCount();
                              $searchPostInLikes= $dbh->prepare("SELECT * FROM likes WHERE post_id = ?");
                              $searchPostInLikes->execute([$result["id"]]);
                              $postLikes = $searchPostInLikes->rowCount();
                                    if($likedCount>0) {?>
                                       <div class="like">
                                          <a href="./src/server/process.php?post_id=<?php echo $result["id"] ?>&likeprocess=unlike">
                                          <i style="color: blue" class="fa fa-thumbs-up" aria-hidden="true"></i>
                                             <p><?php echo $postLikes?></p>
                                          </a>
                                       </div>
                                    <?php
                                    } else {?>        
                                    <div class="like">
                                          <a href="./src/server/process.php?post_id=<?php echo $result["id"] ?>&likeprocess=like">
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
                                       $countCommentsFetch->execute([$result["id"]]);
                                    ?>
                                    <a href="?page=comments&post=<?php echo $result["id"]?>">
                                       <i class="fa fa-comment" aria-hidden="true"></i>
                                       <p><?php echo  $countCommentsFetch->rowCount()?></p>
                                    </a>
                                 </div>
                              </div>
                           </div>  
                        <?php
                  }
               ?> 
               <?php
               } else {?>
                  <div class="npResult">
                     Heç bir post tapılmadı
                  </div>   
               <?php
               }
            ?>
         </div>
         <div class="search__main__elan">
            <div class="div_user">Tapılan elanlar</div>
            <?php
               if($elanSayi==0) {?>
                   <div class="npResult">
                     Heç bir elanlar tapılmadı
                  </div>   
               <?php
                  
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

   <?php
      include("./src/components/AsideRight/AsideRight.php");
   ?>
  </div>
