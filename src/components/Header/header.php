<nav class="navbar">
   <div class="navbar__logo">
      <img src="assets/icons/logo.png" alt="">
   </div>
   <ul class="navbar__links">
      <li class="navbar__link">
         <a href="index.php"><i class="fa fa-home" aria-hidden="true"></i></a>
      </li>
      <li class="navbar__link">
         <a href="index.php?page=friendsrequests"><i class="fa fa-user-friends"></i></a>
      </li>
      <li class="navbar__link">
         <a href="index.php?page=elanlar"><i class="fa-solid fa-shop"></i></a>
      </li>
   </ul>
   <div class="navbar__search">
      <form method="post" action="./src/server/process.php">
         <input placeholder="daxil et" type="search" name="search">
         <button name="tosearch">axtar</button>
      </form>
   </div>
   <ul class="navbar__user">
      <li>
         <a href="">
            <i class="fa-solid fa-bell"></i>
         </a>
      </li>
      <li>
         <a href="">
            <i class="fab fa-facebook-messenger"></i>
         </a>
      </li>
      <li>
         <a href="">
            <i class="fa-solid fa-user-group"></i>
         </a>
      </li>
      <li class="user__icon">
         <a href="">
            <img src="assets/users/image.png" alt="">
         </a>
      </li>
   </ul>
</nav>