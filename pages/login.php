<?php
session_start();

$chars        = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
$captcha_code = substr(str_shuffle($chars), 0, 6);
$_SESSION['captcha_code'] = $captcha_code;
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
  <a href="index.php" class="btn-back"> ← Back</a>
    <h2 class="title">Log In</h2>

    <form action="authenticate.php" method="post">
      <label>
        Username:
        <input type="text" name="username" required>
      </label>

      <label>
        Password:
        <input type="password" name="password" required>
      </label>

      <div class="captcha-box">
        <label for="display-captcha">Captcha Code:</label>
        <input
          type="text"
          id="display-captcha"
          readonly
          value="<?php echo htmlspecialchars($captcha_code); ?>"
        >
      </div>

      <label>
        Enter the code you see:
        <input
          type="text"
          name="captcha_input"
          required
          placeholder="Type the letters you see in ALL CAPS"
        >
      </label>

      <button type="submit">Sign In</button>
    </form>
  </div>
</body>
</html>
