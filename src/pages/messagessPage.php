<?php
  include('./src/components/Header/header.php');
  include("./src/components/AsideLeft/AsideLeft.php");
  $fethMessages = $dbh->prepare("SELECT * FROM messaggess WHERE (to_id=? AND from_id=?) OR (from_id=? AND to_id=?)");
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

