<?php
  include('./src/components/Header/header.php');
  include("./src/components/AsideLeft/AsideLeft.php");
  $seenFetch = $dbh->prepare("UPDATE messaggess SET seen=? WHERE from_id=? AND to_id=?");
  $seenFetch->execute([1, $_GET["message"], $user_id, ]);
   if(isset($_REQUEST["sayfalama"])) {
      $sayfalama = $_REQUEST["sayfalama"];
   } else {
      $sayfalama = 1;
   }
   if(isset($_REQUEST["page"])) {
      $page = $_REQUEST["page"];
      $mess = $_REQUEST["message"];
      $sayfalamaKosulu = "&page=".$page."&message=".$mess;
   } else {
      $sayfalamaKosulu = "";
   }

   $sayfalamaIcinButonSayisi = 2;
   $sayfaBasinaGosterilecek = 20;
   $toplamKayitSayisiSorgusu = $dbh->prepare("SELECT * FROM messaggess WHERE (to_id=? AND from_id=?) OR (from_id=? AND to_id=?)");
   $toplamKayitSayisiSorgusu->execute([$user_id, $_GET["message"], $user_id, $_GET["message"]]);
   $toplamKayitSayisi = $toplamKayitSayisiSorgusu->rowCount();
   $sayfalamayBaslayacaqKayotSayisi = ($sayfalama*$sayfaBasinaGosterilecek) - $sayfaBasinaGosterilecek;
   $bulunanSafyaSayisi = ceil($toplamKayitSayisi/$sayfaBasinaGosterilecek);

  $fethMessages = $dbh->prepare("SELECT * FROM messaggess WHERE (to_id=? AND from_id=?) OR (from_id=? AND to_id=?) LIMIT $sayfalamayBaslayacaqKayotSayisi, $sayfaBasinaGosterilecek");
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
             <a onclick="return confirm('mesajı silmək istədiyinizdən əminsiniz?')" class="exit" href="./src/server/process.php?messprocess=deleteallmess&id=<?php echo$message["id"]?>">
             <i class="fa fa-window-close" aria-hidden="true"></i></a>
                  <?php
                     echo donusumleriGeriDondur($message["mess"]);
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
         <div class="mt-5 sendMess">
            <form method="post" action="./src/server/process.php">
               <input type="hidden" value="<?php echo $_GET["message"]?>" name="id">
               <textarea name="mess" class="form-control"></textarea>
               <button name="sendmess" class="mt-3 btn btn-success">Göndər</button>
            </form>
         </div>
   </div>

<?php
   include("./src/components/AsideRight/AsideRight.php");
?>
</div>

