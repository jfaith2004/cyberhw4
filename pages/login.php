<?php
session_start();

ob_start();
include __DIR__ . '/../captcha.php';
$captcha_code = ob_get_clean();
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
    <h2 class="title">Log In</h2>

    <form action="authenticate.php" method="post">
      <!-- Username -->
      <label>
        Username:
        <input type="text" name="username" required>
      </label>

      <!-- Password -->
      <label>
        Password:
        <input type="password" name="password" required>
      </label>

      <!-- Display Captcha Code -->
      <div class="captcha-box">
        <label for="display-captcha">Captcha Code:</label>
        <input
          type="text"
          id="display-captcha"
          readonly
          value="<?php echo htmlspecialchars(file_get_contents(__DIR__ . '/../captcha.php')); ?>"
        >
      </div>

      <!-- User Enters Captcha -->
      <label>
        Enter the code you see:
        <input
          type="text"
          name="captcha_input"
          required
          placeholder="Type the letters you see"
        >
      </label>

      <!-- Submit -->
      <button type="submit">Sign In</button>
    </form>
  </div>
</body>
</html>
