<?php
   session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"
/>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
   <link rel="stylesheet" href="./src/styles/style.css">
   <title>Document</title>
</head>
<body>
   <div class="container">
      <?php
      include "./src/server/parameters.php";
         if(isset($_SESSION['email'])) {
            if(!isset($_REQUEST["page"])) {
               require('./src/pages/mainMenu.php');
            } elseif($_REQUEST["page"]=="comments") {
               $post_id = $_REQUEST["post"];
               require('./src/pages/comments.php');
            } elseif($_REQUEST["page"]=="elanlar") {
               require('./src/pages/elanlar.php');
            }  elseif($_REQUEST["page"]=="elan") {
               $elan_id = $_REQUEST["elan_id"];
               require('./src/pages/elan.php');
            } elseif($_REQUEST["page"]=="search") {
               require('./src/pages/searchResults.php');
            }
          
         } else {
            header("Location: ./autofication.php");
         }
      ?>
   </div>
   <script src="./src/js/swiped-events.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  </body>
   <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
   <script src="./src/js/script.js"></script>
</body>
</html>