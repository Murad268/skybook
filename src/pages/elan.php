<?php
  include('./src/components/Header/header.php');
  include("./src/components/AsideLeft/AsideLeft.php");
  $fethElan = $dbh->prepare("SELECT * FROM elanlar WHERE id = ?");
  $fethElan->execute([$elan_id]);
  $elan = $fethElan->fetch(PDO::FETCH_ASSOC);
  $getNemeFetch = $dbh->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
  $getNemeFetch->execute([$elan["user_id"]]);
  $getName = $getNemeFetch->fetch(PDO::FETCH_ASSOC);
?>
  <div class="elan__main">
   <div></div>
   <div>
      <div class="elan__main__img">
         <img src="assets/images/elanlar/<?php echo $elan["elan_img"]?>" alt="">
      </div>
      <div class="elan__body">
         <div class="elan__body__name">Kim paylaşıb : <span><a href=""><?php echo $getName["user_login"]?></a></span></div>
         <div class="elan__body__views">Baxış sayı : <span><?php echo $elan["views"] ?> dəfə</span></div>
         <div class="elan__body__date">Paylaşılma tarixi:<span><?php echo time_elapsed_string($elan["create_time"])?></span></div>
         <?php
             if($elan["user_id"] == $user_id) {?>
               <div class="mt-2 elan__body__btns">
                  <a onclick="return confirm('elanı silmək istədiyinizdən əminsinizmi?')" href="./src/server/process.php?deleteelan=true&id=<?php echo $elan["id"]?>" class="btn btn-danger">Sil</a>
               </div>
            <?
             }
         ?>
        
      </div>
      <div class="elan__body__desc">
            <?php
               echo donusumleriGeriDondur($elan["elan_desc"]);
            ?>
      </div>
   </div>

     

<?php
   include("./src/components/AsideRight/AsideRight.php");
?>
</div>

