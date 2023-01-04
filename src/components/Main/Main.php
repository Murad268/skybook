<?php
   if(isset($_REQUEST["sayfalama"])) {
      $sayfalama = $_REQUEST["sayfalama"];
   } else {
      $sayfalama = 1;
   }
   if(isset($_REQUEST["posts"])) {
      $posts = $_REQUEST["posts"];
      $sayfalamaKosulu = "&posts=$posts";
   } else {
      $sayfalamaKosulu = "";
   }
  
   $sayfalamaIcinButonSayisi = 2;
   $sayfaBasinaGosterilecek = 30;
   $toplamKayitSayisiSorgusu = $dbh->prepare("SELECT * FROM posts");
   $toplamKayitSayisiSorgusu->execute();
   $toplamKayitSayisi = $toplamKayitSayisiSorgusu->rowCount();
   $sayfalamayBaslayacaqKayotSayisi = ($sayfalama*$sayfaBasinaGosterilecek) - $sayfaBasinaGosterilecek;
   $bulunanSafyaSayisi = ceil($toplamKayitSayisi/$sayfaBasinaGosterilecek);
   if(!isset($_GET["posts"])) {
      $searchPosts = $dbh->prepare("SELECT * FROM posts ORDER BY likes DESC LIMIT $sayfalamayBaslayacaqKayotSayisi, $sayfaBasinaGosterilecek");
   } else {
      $query = $_GET["posts"];
      if($query=="uplikes") {
         $searchPosts = $dbh->prepare("SELECT * FROM posts ORDER BY likes DESC LIMIT $sayfalamayBaslayacaqKayotSayisi, $sayfaBasinaGosterilecek");
      } else if($query=="downlikes") {
         $searchPosts = $dbh->prepare("SELECT * FROM posts ORDER BY likes ASC LIMIT $sayfalamayBaslayacaqKayotSayisi, $sayfaBasinaGosterilecek");
      } else if($query=="newposts") {
         $searchPosts = $dbh->prepare("SELECT * FROM posts ORDER BY create_time DESC LIMIT $sayfalamayBaslayacaqKayotSayisi, $sayfaBasinaGosterilecek");
      } else if($query=="lastposts") {
         $searchPosts = $dbh->prepare("SELECT * FROM posts ORDER BY create_time ASC LIMIT $sayfalamayBaslayacaqKayotSayisi, $sayfaBasinaGosterilecek");
      }
   }
   $searchPosts->execute();
   $posts = $searchPosts->fetchAll(PDO::FETCH_ASSOC);
?>
<div></div>
<section class="main">	
   <div class="main__wrapper">
      <div class="main__statuses">
         <div class="main__status">
            <img draggable=false src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSU5Unu6nHYatqAloTpYHZ9lEJkLW8xj-nzQxZ7hvOcOEUosivjh_IfBOZz80AwgcZpHTU&usqp=CAU" alt="">
            <div class="add_story">
               <i class="fa-solid fa-plus"></i>
            </div>
            <div class="main__status__name">
               Hekayə əlavə et
            </div>
         </div>
         <div class="main__status">
            <img draggable=false src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSU5Unu6nHYatqAloTpYHZ9lEJkLW8xj-nzQxZ7hvOcOEUosivjh_IfBOZz80AwgcZpHTU&usqp=CAU" alt="">
            <div class="main__status__icon">
               <img src="assets/users/image.png" alt="">
            </div>
            <div class="main__status__name">
               Murad Agamedov
            </div>
         </div>
         <div class="main__status">
            <img draggable=false src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSU5Unu6nHYatqAloTpYHZ9lEJkLW8xj-nzQxZ7hvOcOEUosivjh_IfBOZz80AwgcZpHTU&usqp=CAU" alt="">
            <div class="main__status__icon">
               <img src="assets/users/image.png" alt="">
            </div>
            <div class="main__status__name">
               Murad Agamedov
            </div>
         </div>
         <div class="main__status">
            <img draggable=false src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSU5Unu6nHYatqAloTpYHZ9lEJkLW8xj-nzQxZ7hvOcOEUosivjh_IfBOZz80AwgcZpHTU&usqp=CAU" alt="">
            <div class="main__status__icon">
               <img src="assets/users/image.png" alt="">
            </div>
            <div class="main__status__name">
               Murad Agamedov
            </div>
         </div>
         <div class="main__status">
            <img draggable=false src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSU5Unu6nHYatqAloTpYHZ9lEJkLW8xj-nzQxZ7hvOcOEUosivjh_IfBOZz80AwgcZpHTU&usqp=CAU" alt="">
            <div class="main__status__icon">
               <img src="assets/users/image.png" alt="">
            </div>
            <div class="main__status__name">
               Murad Agamedov
            </div>
         </div>
         <div class="main__status">
            <img draggable=false src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSU5Unu6nHYatqAloTpYHZ9lEJkLW8xj-nzQxZ7hvOcOEUosivjh_IfBOZz80AwgcZpHTU&usqp=CAU" alt="">
            <div class="main__status__icon">
               <img src="assets/users/image.png" alt="">
            </div>
            <div class="main__status__name">
               Murad Agamedov
            </div>
         </div>
         <div class="main__status">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSU5Unu6nHYatqAloTpYHZ9lEJkLW8xj-nzQxZ7hvOcOEUosivjh_IfBOZz80AwgcZpHTU&usqp=CAU" alt="">
            <div class="main__status__icon">
               <img src="assets/users/image.png" alt="">
            </div>
            <div class="main__status__name">
               Murad Agamedov
            </div>
         </div>
         <div style="background-color: white;" class="main__status">
            <div class="main__status__more">
               <i style="font-size: 50px; cursor:pointer" class="fa fa-sign-out" aria-hidden="true"></i>
            </div>
         </div>
      </div>
      <div class="left"><i class="fa-solid fa-arrow-left"></i></div>
      <div class="right"><i class="fa-solid fa-arrow-right"></i></div>
   </div>
   <main class="contentMain">
      <div class="filter__posts">
         <a href="" class="friends btn btn-success">Dostlarımın postları</a>
         <a href="?posts=uplikes" class="friends btn btn-primary">Ən çox bəyənilənlər</a>
         <a href="?posts=downlikes" class="friends btn btn-danger">Ən az bəyənilənlər</a>
         <a href="?posts=newposts" class="friends btn btn-warning">Ən yeni postlar</a>
         <a href="?posts=lastposts" class="friends btn btn-dark">Ən köhnə postlar</a>
      </div>
      <div class="add__post">
         <form method="post" action="./src/server/process.php">
            <input name="post" placeholder="yeni nələr var?" type="text" >
            <i class="openAddPostModal fas fa-image"></i>
            <button type="submit" name="add_post" class="btn btn-success">
            əlavə et
         </button>
         </form>
      </div>
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
                     <?php
                        if($user_id == $getName["id"]) {?>
                            <a><?php echo donusumleriGeriDondur($getName["user_login"])?></a>
                        <?php
                        } else {?>
                           <a href="index.php?page=userpage&user=<?php echo $post["user_id"] ?>"><?php echo donusumleriGeriDondur($getName["user_login"])?></a>
                        <?php
                        }
                     ?>
                    
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
   
   </main>
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
</section>



<div class="add_image__modal">
   <div class="add_image__modal__box">
         <div class="addPostModalExit">
            <i class="fa fa-window-close" aria-hidden="true"></i>
         </div>
         <form enctype="multipart/form-data" method="post" action="./src/server/process.php">
               <div>
                  <div class="mb-4 d-flex justify-content-center">
                     <div class="btn btn-primary btn-rounded">
                           <label class="form-label text-white m-1" for="customFile1">Choose file</label>
                           <input name="img" type="file" class="form-control d-none" id="customFile1" />
                     </div>
                  </div>
               </div>
               <div class="mb-3">
                  <textarea name="post" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
               </div>
               <button type="submit" name="add__img__post" class="btn btn-success">Əlavə et</button>
         </form>
   </div>
</div>

<script>
      const statuses = () => {
      const main = document.querySelector(".main__statuses");
      const mainStatus = document.querySelectorAll(".main__status")
      const margin = window.getComputedStyle(document.querySelector(".main__status")).marginRight;
      const main__statusWidth = document.querySelector(".main__status").clientWidth;
      const butttonLeft = document.querySelector(".left");
      const butttonRight = document.querySelector(".right");
      const mainWidth = +mainStatus.length*(parseFloat(margin)+main__statusWidth);

      let offset = 0;

      function righting() {
         if(offset!==(mainWidth-(parseFloat(margin)+main__statusWidth))) {
            offset+=+main__statusWidth + parseFloat(margin)
         } else {
            offset=0
         }
   
         main.style.transform =`translateX(-${offset}px)`
      }
      function lefting() {
         if(offset!==0) {
            offset-=main__statusWidth+parseFloat(margin)
         
         } else {
            offset=(mainWidth-(parseFloat(margin)+main__statusWidth))
         }

         main.style.transform =`translateX(-${offset}px)`
      }

      main.addEventListener("swiped-right", () => {
         righting()
      })
      main.addEventListener("swiped-left", () => {
         lefting()
      })
      butttonRight.addEventListener("click", () => {
         righting()
      })
      butttonLeft.addEventListener("click", () => {
         lefting()
      })
   }
   statuses()

   function activationModal(openSelector, addImageSelector, addPostSelector, activeClass) {
   const btn = document.querySelector(openSelector),
         modal = document.querySelector(addImageSelector);
         close = document.querySelector(addPostSelector);
   btn.addEventListener("click", () => {
   
      modal.classList.add(activeClass);
   })
   close.addEventListener("click", () => {
      modal.classList.remove(activeClass);
   })
}

   activationModal(".openAddPostModal", ".add_image__modal", ".addPostModalExit", "add_image__modal__active");
</script>