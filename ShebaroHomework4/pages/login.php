<?php
session_start();

$num1 = rand(1, 9);
$num2 = rand(1, 9);
$_SESSION['captcha_answer'] = $num1 + $num2;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sign In</title>
</head>
<body>
  <h1>Sign In</h1>
  <form action="authenticate.php" method="post">
    <p>
      <label>
        Username:<br>
        <input type="text" name="username" required>
      </label>
    </p>
    <p>
      <label>
        Password:<br>
        <input type="password" name="password" required>
      </label>
    </p>
    <p>
      <label>
        What is <?= $num1 ?> + <?= $num2 ?>? 
        <input type="text" name="captcha" required>
      </label>
    </p>
    <button type="submit">Sign In</button>
  </form>
</body>
</html>
