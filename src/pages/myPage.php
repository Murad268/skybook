<?php
  include('./src/components/Header/header.php');
  $fetchUser = $dbh->prepare("SELECT * FROM users WHERE id = ?");
  $fetchUser->execute([$user_id]);
  $user = $fetchUser->fetch(PDO::FETCH_ASSOC);
?>
  <div class="myPage__main">
      <section style="background-color: transparent;">
         <div class="container py-5">
            <div class="row">
               <div class="col-lg-4">
               <div class=" mb-4 avatar__img">
                     <?php
                        if($fetchUser->rowCount() > 0) {?>
                        <img src="assets/users/<?php echo $user["avatar"]?>" alt="avatar"
                     class="" >
                        <?php
                        } else {?>
                        <img src="assets/users/image.png" alt="avatar"
                     class="" >
                        <?
                        }
                     ?>
               </div>
               <div class="change__profile__page">
                     <form method="post" enctype="multipart/form-data" action="./src/server/process.php">
                        <label for="changeAvatar" class="changeAvatar form-label">Yeni profil şəkli seç</label>
                        <input class="form-control" type="file" name="avatar" id="changeAvatar">
                        <button type="submit" name="change__avatar" class="btn btn-dark">rəsmi dəyiş</button>
                     </form>
               </div>
               </div>
               <div class="col-lg-8">
                  <div class="card mb-4">
                     <div class="card-body">
                        <div class="row">
                           <div class="col-sm-3">
                              <p class="mb-0">Login</p>
                           </div>
                           <div class="col-sm-9">
                              <p class="text-muted mb-0"><?php echo $user["user_login"]?></p>
                           </div>
                        </div>
                        <hr>
                        <div class="row">
                           <div class="col-sm-3">
                              <p class="mb-0">Email</p>
                           </div>
                           <div class="col-sm-9">
                              <p class="text-muted mb-0"><?php echo $user["user_email"]?></p>
                           </div>
                        </div>
                     
                     </div>
                  </div>
                  <form method="post" action="./src/server/process.php">
                     <div class="card mb-4">
                           <div class="card-body">
                              <div class="row">
                                 <div class="col-sm-3">
                                    <p class="mb-0">Login</p>
                                 </div>
                                 <div class="col-sm-9">
                                    <input name="login" value="<?php echo $user["user_login"]?>"  class="form-control" type="text">
                                 </div>
                              </div>
                              <hr>
                              <div class="row">
                                 <div class="col-sm-3">
                                    <p class="mb-0">Email</p>
                                 </div>
                                 <div class="col-sm-9">
                                    <input name="email" value="<?php echo $user["user_email"]?>" class="form-control" type="email">
                                 </div>
                              </div>
                              <?php
                              if(isset($_SESSION["have_email"])) {?>
                                 <div class="row">
                                    <div class="col-sm-12">
                                       <p class="mt-3 text-danger mb-0"><?php echo $_SESSION["have_email"]?></p>
                                    </div>
                                 </div>
                              <?php
                           }
                        ?>
                           </div>
                     </div>
                     <button type="submit" name="changeInfo" class="btn btn-primary">Məlumatları dəyiş</button>
                  </form>
                  <form method="post" action="./src/server/process.php">
                     <div class="mt-4 card mb-4">
                           <div class="card-body">
                              <div class="row">
                                 <div class="col-sm-3">
                                    <p class="mb-0">Şifrə</p>
                                 </div>
                                 <div class="col-sm-9">
                                    <input name="password"   class="form-control" type="text">
                                 </div>
                              </div>
                           </div>
                     </div>
                     <button type="submit" name="changePass" class="btn btn-primary">Şifrəni dəyiş</button>
                  </form>
               </div>
               
            </div>
         </div>
      </section>
  </div>

