<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Login</title>
		<link rel="stylesheet" href="../css/login.css" />
		<link
			href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
			rel="stylesheet"
		/>
	</head>
	<body>
		<img src="../picture/logo.png" class="header-img" />
		<div class="wrapper">
			<form action="#" method="post">
				<h1>Login</h1>
				<div class="input-box">
					<input
						type="email"
						name="txtEmail"
						placeholder="Email"
						required
					/>
				</div>
				<div class="input-box">
					<input
						type="password"
						name="txtPassword"
						placeholder="Password"
						required
					/>
				</div>
				<div class="forgot">
					<a href="#">Forgot Password?</a>
				</div>
				<input type="submit" class="submit" value="Login" />
				<div class="register-link">
					<p>Don't have an account? <a href="../html/register.html"">Sign Up</a></p>
				</div>
			</form>
		</div>
		<!-- copyright part -->
		<div class="copyright">
			<p>© 2024 BreezeQuiz. All rights reserved.</p>
		</div>
	</body>
</html>
