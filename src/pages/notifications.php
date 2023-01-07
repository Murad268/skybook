<?php
  include('./src/components/Header/header.php');
  include("./src/components/AsideLeft/AsideLeft.php");
  $updateSeen = $dbh->prepare("UPDATE notification SET seen = 1 WHERE to_id = ?");
  $updateSeen->execute([$user_id]);
?>
  <div class="notifications__main">
   <div></div>
   
   <div class="notifications__main__list">
      <?php
        $fethcNot = $dbh->prepare("SELECT * FROM notification WHERE to_id = ?");
        $fethcNot->execute([$user_id]);
        $nots = $fethcNot->fetchAll(PDO::FETCH_ASSOC);
      
        if($fethcNot->rowCount() > 0) {
          foreach($nots as $not) {
            $getNemeFetch = $dbh->prepare("SELECT * FROM users WHERE id = ?");
            $getNemeFetch->execute([$not["from_id"]]);
            $getName = $getNemeFetch->fetch(PDO::FETCH_ASSOC);?>
            <div class="notifications__main__list__el">
              <span><a href="index.php?page=userpage&user=<?php echo $not["from_id"]?>"><?php echo donusumleriGeriDondur($getName["user_login"])?></a></span> sizin statusunuza komment yazdi - <span><a href="?page=comments&post=<?php echo $not["comment_id"]?>"><?php echo mb_substr(donusumleriGeriDondur($not["comment"]), 0, 22)."..."?></a></span>
            </div>
          <?php
          }
        } else {?>
          <div class="no__not">
            Hazırda heç bir bildirişiniz yoxdur
          </div>
        <?php
        }
      ?>
    
   </div>
     

<?php
   include("./src/components/AsideRight/AsideRight.php");
?>
</div>

