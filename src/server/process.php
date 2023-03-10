
<?php
   session_start();
   use PHPMailer\PHPMailer\PHPMailer;
   use PHPMailer\PHPMailer\SMTP;
   use PHPMailer\PHPMailer\Exception;
   require '../../vendor/autoload.php';
   include('connect.php');
   include('parameters.php');
   if(isset($_POST["registration__btn"])) {
      $login = minseo($_POST["user_login"]);
      $email = minseo($_POST["user_email"]);
      $pass = minseo($_POST["user_pass"]);
      $mail = new PHPMailer(true);
      $mail->CharSet = 'utf-8';
      if(mb_strlen($pass) < 6) {
         $_SESSION["user_reg"] = "Şifrə minimum 6 simvoldan ibarət olmalıdır.";
         header("Location: ../../autofication.php");
         exit();
      }
      try {
         $searchUser = $dbh->prepare("SELECT * FROM users WHERE user_email = ? OR user_login = ?");
         $searchUser->execute([$email, $login]);
         $countUser = $searchUser->rowCount();
         if($countUser>0) {
            $_SESSION["user_reg"] = "Bu elektron poçt və ya login ilə artıq istifadəçi mövcuddur";
            header("Location: ../../autofication.php");
         } else {
            $code = createActivationCode();
            $message = "Dəyərli istifadəçi, təstiqləmə linkiniz: "."<a href="."http://localhost/skybook/src/server/activation.php?email=".$email."&code=".$code.">tıklayın</a>";
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.mail.ru';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'agamedov94@mail.ru';                     //SMTP username
            $mail->Password   = '';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            //Recipients
            $mail->setFrom('agamedov94@mail.ru', 'Mailer');
            $mail->addAddress($email, $login);     //Add a recipient
            // $mail->addAddress('ellen@example.com');               //Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');
   
            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
   
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'skyJoke qeydiyyat';
            $mail->Body  = $message;
            $mail->send();
            $addUser = $dbh->prepare("INSERT INTO users (user_login, user_email, user_pass, activation_code)
            VALUES (?, ?, ?, ?)");
            $addUser->execute([$login, $email, md5($pass), $code]);
            $count = $addUser->rowCount();
            if($count>0) {
               $_SESSION["user_reg"] = "Təstiqləmə kodunuz daxil etdiyiniz elektron poçta göndərildi!";
               header("Location: ../../autofication.php");
               exit();
            }
         }
         //Server settings
       
      } catch (Exception $e) {
         echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      }
   }

   if(isset($_POST["user_enter"])) {
      $email = minseo($_POST["user_email"]);
      $pass = md5(minseo($_POST["user_pass"]));
      $mail = new PHPMailer(true);
      $mail->CharSet = 'utf-8';
      $searchUser = $dbh->prepare("SELECT * FROM users WHERE user_email = ? AND user_pass = ?");
      $searchUser->execute([$email, $pass]);
      $countUsers = $searchUser->rowCount();
      if($countUsers>0) {
         $searchUser = $dbh->prepare("SELECT * FROM users WHERE user_email = ? AND user_pass = ? AND status = ?");
         $searchUser->execute([$email, $pass, 0]);
         $countUsers = $searchUser->rowCount();
         if($countUsers>0) {
            try {
                  $code = createActivationCode();
                  $message = "Dəyərli istifadəçi, təstiqləmə linkiniz: "."<a href="."http://localhost/skybook/src/server/activation.php?email=".$email."&code=".$code.">tıklayın</a>";
                  $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                  $mail->isSMTP();                                            //Send using SMTP
                  $mail->Host       = 'smtp.mail.ru';                     //Set the SMTP server to send through
                  $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                  $mail->Username   = 'agamedov94@mail.ru';                     //SMTP username
                  $mail->Password   = '';                               //SMTP password
                  $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                  $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                  //Recipients
                  $mail->setFrom('agamedov94@mail.ru', $login);
                  $mail->addAddress($email, "John Doe");     //Add a recipient
                  // $mail->addAddress('ellen@example.com');               //Name is optional
                  // $mail->addReplyTo('info@example.com', 'Information');
                  // $mail->addCC('cc@example.com');
                  // $mail->addBCC('bcc@example.com');
         
                  //Attachments
                  // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                  // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
         
                  //Content
                  $mail->isHTML(true);                                  //Set email format to HTML
                  $mail->Subject = 'skyJoke qeydiyyat';
                  $mail->Body  = $message;
                  $mail->send();
                  $addUser = $dbh->prepare("UPDATE  users SET activation_code=? WHERE user_email=?");
                  $addUser->execute([$code, $email]);
                  $count = $addUser->rowCount();
                  if($count>0) {
                     $_SESSION["user_reg"] = "Hesabınız hələ təstiqlənməyib. Təstiqləmə kodu yenidən elektron poçtunuza göndərildi";
                     header("Location: ../../autofication.php");
                     exit();
                  }
         
             
            } catch (Exception $e) {
               echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
            header("Location: ../../autofication.php");
            exit();
         }
         $searchUser = $dbh->prepare("SELECT * FROM users WHERE user_email = ? AND user_pass = ? AND status = ?");
         $searchUser->execute([$email, $pass, 1]);
         $countUsers = $searchUser->rowCount();
         if($countUsers > 0) {
            $activateUserActive = $dbh->prepare("UPDATE users SET active=? WHERE user_email=? AND status = ?");
            $activateUserActive->execute([1, $email, 1]);
            if($activateUserActive->rowCount() > 0) {
               unset ($_SESSION['user_reg']);
               $_SESSION["email"] = $email;
               header("Location: ../../index.php");
               exit();
            }
         }
      } else {
         $_SESSION["user_reg"] = "Elekron poçt və ya şifrə yanlışdır";
         header("Location: ../../autofication.php");
         exit();
      }
   }
  
   if(isset($_POST['add_post'])) {
      $post = minseo($_POST["post"]);
      if($post != "") {
         $addPost = $dbh->prepare("INSERT into posts (post, user_id, create_time) VALUES (?,?,?)");
         $time = time();
         $addPost->execute([$post, $user_id, $time]);
         header('Location: ' . $_SERVER['HTTP_REFERER']);
      } else {
         header('Location: ' . $_SERVER['HTTP_REFERER']);
      }
   }


   if(isset($_POST['add__img__post'])) {
      $post = minseo($_POST["post"]);
      $img = $_FILES["img"];
  
      if($post AND $img) {
        $imagetemp =  $img['tmp_name'];
        $imagename = $img['name'];
        $add_post = $dbh->prepare("INSERT INTO posts (post, user_id, img, create_time) VALUES (?, ?, ?, ?)");
        $time = time();
        $rrr = createActivationCode();
        $add_post->execute([$post, $user_id, $rrr.$imagename, $time]);
         if(move_uploaded_file($imagetemp, '../../assets/images/posts/' .$rrr.$imagename)) {
             header('Location: ' . $_SERVER['HTTP_REFERER']);
         } else {
             echo "Failed to move your image.";
         }
      } else {
         header('Location: ' . $_SERVER['HTTP_REFERER']);
      }
   }

   if(isset($_REQUEST["likeprocess"])) {
      if($_REQUEST["likeprocess"]=="like") {
         $addLike = $dbh->prepare("INSERT INTO likes (user_id, post_id) VALUES (?,?)");
         $addLike->execute([$user_id, (int)$_GET["post_id"]]);
         $addedLikeCount = $addLike->rowCount();
         if($addedLikeCount > 0) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
         }
      } else {
         $unlike = $dbh->prepare("DELETE FROM likes WHERE user_id = ? AND  post_id = ?");
         $unlike->execute([$user_id, (int)$_GET["post_id"]]);
         $unlikeLikeCount = $unlike->rowCount();
         if($unlikeLikeCount > 0) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
         }
      }
   }


   if(isset($_POST["add_comment"])) {
      if($_POST["comment"] == "") {
         header('Location: ' . $_SERVER['HTTP_REFERER']);
      }
      $addComment = $dbh->prepare("INSERT INTO comments (post_id, comment, user_id) VALUES (?,?,?)");
      $addComment->execute([minseo($_POST["post_id"]), minseo($_POST["comment"]),$user_id]);
      $addedCommentCount = $addComment->rowCount();
  
  
      if($addedCommentCount>0) {
         $search_post = $dbh->prepare("SELECT * FROM posts WHERE id = ?");
         $search_post->execute([$_POST["post_id"]]);
         $post = $search_post->fetch(PDO::FETCH_ASSOC);
         if($post["user_id"] != $user_id) {
            $notComment = $dbh->prepare("INSERT INTO notification (type, to_id, from_id, comment, comment_id) VALUES (?,?,?,?,?)");
            $notComment->execute([1, $post["user_id"], $user_id, minseo($_POST["comment"]), $_POST["post_id"]]);
            if($notComment->rowCount()>0) {
               header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
         }
         header('Location: ' . $_SERVER['HTTP_REFERER']);
      }
   }







   if(isset($_REQUEST["commentprocess"])) {
      if($_REQUEST["commentprocess"]=="delete") {
         $deleteFetch = $dbh->prepare("DELETE FROM posts WHERE user_id = ? AND id = ?");
         $deleteFetch->execute([$user_id, $_GET["id"]]);
         $deletedCount = $deleteFetch->rowCount();
         if($deletedCount>0) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
         }
      }
   }



   if(isset($_POST['add__elan__post'])) {
      $post = minseo($_POST["elan"]);
      $img = $_FILES["img"];
      $title = minseo($_POST["title"]);
      if($post AND $img AND $title) {
        $imagetemp =  $img['tmp_name'];
        $imagename = $img['name'];
        
        $add_post = $dbh->prepare("INSERT INTO elanlar (elan_title, elan_img, elan_desc, user_id, create_time) VALUES (?, ?, ?, ?, ?)");
        $time = time();
        $rrr = createActivationCode();
        $add_post->execute([minseo($_POST["title"]), $rrr.$imagename, minseo($_POST["elan"]), $user_id, $time]);
         if(move_uploaded_file($imagetemp, '../../assets/images/elanlar/'.$rrr.$imagename)) {
             header('Location: ../../index.php?page=elanlar' );
         } else {
             echo "Failed to move your image.";
         }
      } else {
         header('Location: ' . $_SERVER['HTTP_REFERER']);
      }
   }



   if(isset($_REQUEST["deleteelan"])) {
     $fetchDeleteElan = $dbh->prepare("DELETE FROM elanlar WHERE id = ? AND user_id = ?");
     $fetchDeleteElan->execute([$_GET["id"], $user_id]);
     $deletedElan = $fetchDeleteElan->rowCount();
     if($deletedElan>0) {
         header('Location: ../../index.php?page=elanlar');
     }
   }


   if(isset($_REQUEST["tosearch"])) {
      $search = minseo($_POST["search"]);
      if($search=="") {
         header('Location: ' . $_SERVER['HTTP_REFERER']);
      } else {
         header('Location: ../../index.php?page=search&query='.$search);
      }
    }

    if(isset($_REQUEST["frrequest"])) {
     
  

      if($_REQUEST["frrequest"] == "addfriend") {
         $to_id = $_GET["user_id"];
         if(!isset($user_id)) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
         }
         $addFriendFetch = $dbh->prepare(("INSERT INTO frequests (to_id, from_id) VALUES (?,?)"));
         $addFriendFetch->execute([$to_id, $user_id]);
         if($addFriendFetch->rowCount()>0) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
         }
      } elseif($_REQUEST["frrequest"] == "cancelfriend") {
         $req_id = $_REQUEST["req_id"];
         $deleteReqFetch = $dbh->prepare("DELETE FROM frequests WHERE id = ?");
         $deleteReqFetch->execute([$req_id]);
         if($deleteReqFetch->rowCount()>0) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
         }
      } elseif($_REQUEST["frrequest"] == "confirmfriend") {
         $req_id = $_REQUEST["req_id"];
         $reqFetch = $dbh->prepare("SELECT * FROM frequests WHERE id = ?");
         $reqFetch->execute([$req_id]);
         $req = $reqFetch->fetch(PDO::FETCH_ASSOC);
         
         $deleteReqFetch = $dbh->prepare("DELETE FROM frequests WHERE id = ?");
         $deleteReqFetch->execute([$req_id]);
         if($deleteReqFetch->rowCount()>0) {
            $addFriendFetch = $dbh->prepare("INSERT INTO friends (friend_first, friend_second) VALUES (?,?)");
            $addFriendFetch->execute([$req["from_id"], $req["to_id"]]);
            if($addFriendFetch->rowCount()>0) {
               header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
         }
      } elseif($_REQUEST["frrequest"] == "deletefriend") {
         $req_id = $_REQUEST["req_id"];
         $deleteReqFetch = $dbh->prepare("DELETE FROM friends WHERE id = ?");
         $deleteReqFetch->execute([$req_id]);
         if($deleteReqFetch->rowCount()>0) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
         }
      } 
    
    }


    if(isset($_POST["change__avatar"])) {
      $avatar = $_FILES["avatar"];
      if($avatar != "") {
         $imagetemp =  $avatar['tmp_name'];
         $imagename = $avatar['name'];
         $add_post = $dbh->prepare("UPDATE users SET avatar = ? WHERE id=?");
         $time = time();
         $rrr = createActivationCode();
         $add_post->execute([$rrr.$imagename, $user_id]);
          if(move_uploaded_file($imagetemp, '../../assets/users/' .$rrr.$imagename)) {
              header('Location: ' . $_SERVER['HTTP_REFERER']);
          } else {
              echo "Failed to move your image.";
          }
       } else {
          header('Location: ' . $_SERVER['HTTP_REFERER']);
       }
    }

    if(isset($_POST["changeInfo"])) {
      $login = minseo($_POST["login"]);
      $email = minseo($_POST["email"]);
      $userFetch = $dbh->prepare("SELECT * FROM users WHERE id = ?");
      $userFetch->execute([$user_id]);
      $user = $userFetch->fetch(PDO::FETCH_ASSOC);
      if($email==$user["user_email"]) {
         $changeFetch = $dbh->prepare("UPDATE users SET user_login=? WHERE id = ?");
         $changeFetch->execute([$login, $user_id]);
         if($changeFetch->rowCount()>0) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
         }
      } else {
            $changeFetch = $dbh->prepare("SELECT * FROM users WHERE user_email = ?");
            $changeFetch->execute([$email]);   
            if($changeFetch->rowCount()>0) {
               $changeFetchh = $dbh->prepare("UPDATE users SET user_login=? WHERE id = ?");
               $changeFetchh->execute([$login, $user_id]);
               $_SESSION["have_email"] = "Bu elektron poçt ilə hesab artıq mövcuddur";
               header('Location: ' . $_SERVER['HTTP_REFERER']);
               exit();  
            } else {
                  try {
                     $mail = new PHPMailer(true);
                     $mail->CharSet = 'utf-8';
                     $code = createActivationCode();
                     $message = "Dəyərli istifadəçi, təstiqləmə linkiniz: "."<a href="."http://localhost/skybook/src/server/changeEmail.php?email=".$email."&code=".$code.">tıklayın</a>";
                     $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                     $mail->isSMTP();                                            //Send using SMTP
                     $mail->Host       = 'smtp.mail.ru';                     //Set the SMTP server to send through
                     $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                     $mail->Username   = 'agamedov94@mail.ru';                     //SMTP username
                     $mail->Password   = '';                               //SMTP password
                     $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                     $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                     //Recipients
                     $mail->setFrom('agamedov94@mail.ru', $login);
                     $mail->addAddress($email, $login);     //Add a recipient
                     // $mail->addAddress('ellen@example.com');               //Name is optional
                     // $mail->addReplyTo('info@example.com', 'Information');
                     // $mail->addCC('cc@example.com');
                     // $mail->addBCC('bcc@example.com');
            
                     //Attachments
                     // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                     // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
                     //Content
                     $mail->isHTML(true);                                  //Set email format to HTML
                     $mail->Subject = 'skyJoke qeydiyyat';
                     $mail->Body  = $message;
                     $mail->send();
                     $changeCode = $dbh->prepare("UPDATE users SET user_email = ?,  user_login = ?, activation_code = ?, status = ? WHERE id=?");
                     $changeCode->execute([$email, $login, $code, 0, $user_id]);
                     if($changeCode->rowCount()>0) {
                        session_destroy();   
                        header('Location: ../../index.php');
                        $_SESSION["user_reg"] = "Hesabınız hələ təstiqlənməyib. Təstiqləmə kodu yenidən elektron poçtunuza göndərildi";
                     }
               } catch (Exception $e) {
                  echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
               }
            }
        
         }
      }
  
      if(isset($_POST["changePass"])) {
         $pass = md5(minseo($_POST["password"]));
         $changePass = $dbh->prepare("UPDATE users SET user_pass = ? WHERE id=?");
         $changePass->execute([$pass, $user_id]);
         if($changePass->rowCount()>0) {
            session_destroy();
            header('Location: ../../index.php');
            exit();
         } else {
            header('Location: ../../index.php');
            exit();
         }
      }

      if(isset($_POST["resetBtn"])) {
         $email = minseo($_POST["confirmPassword"]);
         if( $email=="") {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
         } else {
            $emailSorgula = $dbh->prepare("SELECT * FROM users WHERE user_email = ?");
            $emailSorgula->execute([$email]);
            if( $emailSorgula->rowCount()==0) {
               $_SESSION["user_reg"] = "Belə bir elektron poçt ilə qeydiyyatda olan istifadəçi tapılmadı";
               header('Location: ../../index.php');
            }
            try {
               $mail = new PHPMailer(true);
               $mail->CharSet = 'utf-8';
               $userCode = createActivationCode();
               $code = md5($userCode);
               $message = "yeni şifrəniz: ".$userCode."    - daha sonra istfadəçi səhifəsindən şifrənizi dəyişə bilərsiniz";
               $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
               $mail->isSMTP();                                            //Send using SMTP
               $mail->Host       = 'smtp.mail.ru';                     //Set the SMTP server to send through
               $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
               $mail->Username   = 'agamedov94@mail.ru';                     //SMTP username
               $mail->Password   = '';                               //SMTP password
               $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
               $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
               //Recipients
               $mail->setFrom('agamedov94@mail.ru', "reset");
               $mail->addAddress($email, "reset");     //Add a recipient
               // $mail->addAddress('ellen@example.com');               //Name is optional
               // $mail->addReplyTo('info@example.com', 'Information');
               // $mail->addCC('cc@example.com');
               // $mail->addBCC('bcc@example.com');
      
               //Attachments
               // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
               // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
               //Content
               $mail->isHTML(true);                                  //Set email format to HTML
               $mail->Subject = 'skyJoke şifrə bərpası';
               $mail->Body  = $message;
               $mail->send();
               $changePass = $dbh->prepare("UPDATE users SET user_pass=? WHERE user_email=?");
               $changePass->execute([$code, $email]);
               if($changePass->rowCount()>0) {
                  $_SESSION["user_reg"] = "Avtomatik təyin edilmiş şifrə elektron poçtunuza göndərildi";
                  header('Location: ../../index.php');
               }
         } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
         }
         }
      }



      if(isset($_POST["sendmess"])) {
         $id = $_POST["id"];
         $mess = minseo($_POST["mess"]);
         if($mess == "" or $id == "") {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
         } else {
            $searchMess = $dbh->prepare("SELECT * FROM messlist WHERE (to_id=? AND from_id=?) OR (from_id=? OR to_id=?)");
            $searchMess->execute([$id, $user_id, $id, $user_id]);
            if($searchMess->rowCount()>0) {
               $sendMess = $dbh->prepare("INSERT INTO messaggess (to_id, from_id, mess, sendtime ) VALUES (?, ?, ?, ?)");
               $sendMess->execute([$id, $user_id, $mess, time()]);
               if($sendMess->rowCount()>0) {
                  header('Location: ' . $_SERVER['HTTP_REFERER']);
               }
            } else {
               $sendMessFetch = $dbh->prepare("INSERT INTO messlist (to_id, from_id ) VALUES (?, ?)");
               $sendMessFetch->execute([$id, $user_id]);
               if($sendMessFetch->rowCount()>0) {
                  $sendMess = $dbh->prepare("INSERT INTO messaggess (to_id, from_id, mess, sendtime ) VALUES (?, ?, ?, ?)");
                  $sendMess->execute([$id, $user_id, $mess, time()]);
                  if($sendMess->rowCount()>0) {
                     header('Location: ' . $_SERVER['HTTP_REFERER']);
                  }      
               }
            }   
         }
      }

      if(isset($_GET["messprocess"])) {
         $id = $_GET["id"];
         $searchMess = $dbh->prepare("SELECT * FROM messaggess WHERE id = ? AND from_id=?");
         $searchMess->execute([$id, $user_id]);
         if( $searchMess->rowCount()>0) {
            $deleteMess = $dbh->prepare("DELETE FROM messaggess WHERE id=?");
            $deleteMess->execute([$id]);
            if($deleteMess->rowCount()>0) {
               header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
         } else {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
         }   
      }

      if(isset($_POST['add__status'])) {
         $img = $_FILES["status"];   
         if($img["size"] != 0) {
         $imagetemp =  $img['tmp_name'];
         $imagename = $img['name'];
         $add_post = $dbh->prepare("INSERT INTO statuses (user_id, status) VALUES (?, ?)");
         $rrr = createActivationCode();
         $add_post->execute([$user_id, $rrr.$imagename]);
            if(move_uploaded_file($imagetemp, '../../assets/images/statuses/' .$rrr.$imagename)) {
               header('Location: ' . $_SERVER['HTTP_REFERER']);
            } else {
               echo "Failed to move your image.";
            }
         } else {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
         }
      }
?>
