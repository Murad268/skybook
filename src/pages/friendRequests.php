<?php
  include('./src/components/Header/header.php');
  include("./src/components/AsideLeft/AsideLeft.php");
  $frequestFetch = $dbh->prepare("SELECT * FROM frequests WHERE to_id = ?");
  $frequestFetch->execute([$user_id]);
  $requests = $frequestFetch->fetchAll(PDO::FETCH_ASSOC);
?>

  <div class="friend__requests__main">
   <div></div>
   <div>
      <?php
         if($frequestFetch->rowCount() > 0) {
            foreach($requests as $request) {
               $getNemeFetch = $dbh->prepare("SELECT * FROM users WHERE id = ?");
               $getNemeFetch->execute([$request["from_id"]]);
               $getName = $getNemeFetch->fetch(PDO::FETCH_ASSOC);?>
                  <div class="friend__request">
                     <div class="friend__request__img">
                        <img src="assets/users/image.png" alt="">
                     </div>
                     <div class="friend__request__login">
                        <a href="index.php?page=userpage&user=<?php echo $getName["id"] ?>"><?php echo donusumleriGeriDondur($getName["user_login"])?></a>
                     </div>
                     <div class="friend__request__controlls">
                     <a onclick="return confirm('dostluq təklifini qəbul etmək istədiyinizdən əminsiniz?')" href="./src/server/process.php?frrequest=confirmfriend&req_id=<?php echo $request["id"]?>" class="btn btn-success">qəbul et</a>
                        <a onclick="return confirm('dostluq təklifini ləğv etmək istədiyinizdən əminsiniz?')" href="./src/server/process.php?frrequest=cancelfriend&req_id=<?php echo $request["id"]?>" class="btn btn-danger">ləğv et</a>
                     </div>
                  </div>
            <?php
            }
         } else {?>
            <div class="noreq">
               Hazırda heç bir dostluq istəyi mövcud deyil
            </div>
         <?php
         }
      ?>
   </div>
   <?php
      include("./src/components/AsideRight/AsideRight.php");
   ?>
  </div>

