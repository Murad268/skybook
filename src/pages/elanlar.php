<?php
  include('./src/components/Header/header.php');
  if(!isset($_REQUEST["elantype"])) {
      $fetchElanlar = $dbh->prepare("SELECT * FROM elanlar");
  } elseif($_REQUEST["elantype"] == "new") {
      $fetchElanlar = $dbh->prepare("SELECT * FROM elanlar ORDER BY id DESC");
  } elseif($_REQUEST["elantype"] == "old") {
      $fetchElanlar = $dbh->prepare("SELECT * FROM elanlar ORDER BY id ASC");
  } elseif($_REQUEST["elantype"] == "popular") {
   $fetchElanlar = $dbh->prepare("SELECT * FROM elanlar ORDER BY views DESC");
  }

  $fetchElanlar->execute();
  $elanlar = $fetchElanlar->fetchAll(PDO::FETCH_ASSOC);
  $page = $_GET["page"];
  ?>
 
  <div class="elanlar__main">
   <div>
      <div class="elanlar__main__btns">
         <a href="?page=<?php echo $page?>&elantype=new" class="newElan btn btn-success">ən yeni elanlar</a>
         <a href="?page=<?php echo $page?>&elantype=old" class="newElan btn btn-danger">ən köhnə elanlar</a>
         <a href="?page=<?php echo $page?>&elantype=popular" class="newElan btn btn-primary">ən populyar elanlar</a>
      </div>
      <div class="blog-slider">
         <div class="blog-slider__wrp swiper-wrapper">
         <?php
            foreach($elanlar as $elan) {?>
               <div class="blog-slider__item swiper-slide">
                     <div class="blog-slider__img"> 
                     <img src="assets/images/elanlar/<?php echo $elan["elan_img"]?>" alt="">
                     </div>
                     <div class="blog-slider__content">
                     <span class="blog-slider__code"><?php echo $elan["create_time"]?></span>
                     <div class="blog-slider__title"><?php echo $elan["elan_title"]?></div>
                     <div class="blog-slider__text"><?php echo mb_substr($elan["elan_desc"], 0, 20)?></div>
                     <a href="index.php?page=elan&<?php echo "elan_id=".$elan["id"]?>" class="blog-slider__button">tam oxu</a>
                     </div>
                  </div>  
            <?php
            }
         ?>
      
         </div>
      <div class="blog-slider__pagination"></div>
      </div>
</div>


  </div>
  <?php
  
?>

<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
<script>
   var swiper = new Swiper('.blog-slider', {
      spaceBetween: 30,
      effect: 'fade',
      loop: true,
      mousewheel: {
        invert: false,
      },
      // autoHeight: true,
      pagination: {
        el: '.blog-slider__pagination',
        clickable: true,
      }
    });
</script>
