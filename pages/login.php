<?php
session_start();

// No more math! We’ll show the image instead.
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Log In</title>
  <link rel="stylesheet" href="/css/login.css">
</head>
<body>
  <div class="login-container">
    <h1>Log In</h1>
    <form action="authenticate.php" method="post">
      <label>
        Username:
        <input type="text" name="username" required>
      </label>

      <label>
        Password:
        <input type="password" name="password" required>
      </label>

      <label>
        CAPTCHA:
        <div style="margin: .5rem 0;">
          <img src="/captcha.php" alt="CAPTCHA image">
        </div>
        <input type="text" name="captcha" required placeholder="Type the letters you see">
      </label>

      <button type="submit">Sign In</button>
    </form>
  </div>
</body>
</html>