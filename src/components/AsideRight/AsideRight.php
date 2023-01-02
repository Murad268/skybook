<aside class="asideRight">
   <div class="asideRight__top">
      <div class="asideRight__top__left">
         Elanlar
      </div>
      <div class="asideRight__top__right">
         <a href=""><i class="fa-brands fa-golang"></i></a>
      </div>
   </div>
   <div title="elan elave et" class="elan__add">
      <img src="assets/icons/plus-removebg-preview.png" alt="">
   </div>
   <div class="elanlar">
      <?php
         $fethElanlar = $dbh->prepare("SELECT * FROM elanlar ORDER BY create_time DESC LIMIT 0, 3");
         $fethElanlar->execute();
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
                     if(mb_strlen(donusumleriGeriDondur($elan["elan_desc"])) > 21) {?>
                        <a href="">...</a>
                     <?php    
                     }?>
                     <?php
                  ?>
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
</aside>


<div class="add_elan__modal">
   <div class="add_elan__modal__box">
         <div class="addElanModalExit">
            <i class="fa fa-window-close" aria-hidden="true"></i>
         </div>
         <form enctype="multipart/form-data" method="post" action="./src/server/process.php">
               <div>
                  <div class="mb-4 d-flex justify-content-center">
                     <input name="img" type="file" class="form-control" id="customFile1" />
                  </div>
                  <div class="mb-4 d-flex justify-content-center">
                     <input name="title" placeholder="elanın başlığını daxil edin" class="form-control" type="text">
                  </div>
               </div>
               <div class="mb-3">
                  <textarea name="elan" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
               </div>
               <button type="submit" name="add__elan__post" class="btn btn-success">Əlavə et</button>
         </form>
   </div>
</div>

<script>
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

   // activationModal(".openAddPostModal", ".add_image__modal", ".addPostModalExit", "add_image__modal__active");
   activationModal(".elan__add", ".add_elan__modal", ".addElanModalExit", "add_elan__modal__active");
</script>