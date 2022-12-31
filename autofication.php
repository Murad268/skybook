<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
   <link rel="stylesheet" href="./src/styles/autofication.css">
   <title>Document</title>
</head>
<body class="autBody">
<div class="container" id="container">
	<div class="form-container sign-up-container">
		<form method="post" action="./src/server/process.php">
			<h1>Qeydiyyat</h1>
			<div class="social-container">
				<a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
				<a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
				<a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
			</div>
			<span>və ya qeydiyyat üçün e-poçtunuzdan istifadə edin</span>
			<input name="user_login" type="text" placeholder="Login" />
			<input name="user_email" type="email" placeholder="Elektron poçt" />
			<input name="user_pass" type="password" placeholder="Şifrə" />
			<button type="submit" name="registration__btn">Qeyd ol</button>
		</form>
	</div>
	<div class="form-container sign-in-container">
		<form method="post" action="./src/server/process.php">
			<h1>Daxil olmaq</h1>
			<div class="social-container">
				<a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
				<a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
				<a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
			</div>
			<span>ya da öz hesabın ilə daxil ol</span>
			<input name="user_email" type="email" placeholder="Elektron poçt" />
			<input name="user_pass" type="password" placeholder="Şifrə" />
			<?php
				if(isset($_SESSION["user_reg"])) {?>
					<div style="font-size: 12px;" class="alert alert-primary" role="alert">
						<?php
							echo $_SESSION["user_reg"];
						?>
					</div>
				<?php
				}
			?>
			<a href="#">Şifrəni unutmusan?</a>
			<button type="submit" name="user_enter">Daxil ol</button>
		</form>
	</div>
	<div class="overlay-container">
		<div class="overlay">
			<div class="overlay-panel overlay-left">
				<h1>Xoş gəlmisiniz!!</h1>
				<p>Əgər artıq hesabınız mövcuddursa, daxil olun</p>
				<button class="ghost" id="signIn">Daxil ol</button>
			</div>
			<div class="overlay-panel overlay-right">
				<h1>Xoş gördük, Dost!</h1>
				<p>Məlumatlarınızı daxil edin və bizimlə səyahətə başlayın</p>
				<button class="ghost" id="signUp">Qeyd ol</button>
			</div>
		</div>
	</div>
</div>


   <script>
      const signUpButton = document.getElementById('signUp');
      const signInButton = document.getElementById('signIn');
      const container = document.getElementById('container');

      signUpButton.addEventListener('click', () => {
         container.classList.add("right-panel-active");
      });

      signInButton.addEventListener('click', () => {
         container.classList.remove("right-panel-active");
      });
	
	
   </script>
</body>
</html>