<?php
session_start();

if (
    empty($_POST['username']) ||
    empty($_POST['password']) ||
    empty($_POST['captcha_input'])
) {
    die('Please fill in all fields. <a href="login.php">Go back</a>.');
}

if (
    !isset($_SESSION['captcha_code']) ||
    strcasecmp($_POST['captcha_input'], $_SESSION['captcha_code']) !== 0
) {
    unset($_SESSION['captcha_code']);
    die('CAPTCHA incorrect. <a href="login.php">Try again</a>.');
}
unset($_SESSION['captcha_code']);

$username = trim($_POST['username']);
$password = $_POST['password'];
$hashed   = sha1($password);   

$mysqli = new mysqli(
    'localhost',
    'webuser',
    'YourWebUserPass',
    'UserDatabase'
);
if ($mysqli->connect_error) {
    die('DB connection error: ' . htmlspecialchars($mysqli->connect_error));
}

$stmt = $mysqli->prepare(
    'SELECT clearance
       FROM UserAccounts
      WHERE username = ?
        AND password = ?'
);
if (! $stmt) {
    die('Prepare failed: ' . htmlspecialchars($mysqli->error));
}
$stmt->bind_param('ss', $username, $hashed);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
    $stmt->bind_result($clearance);
    $stmt->fetch();

    $_SESSION['username']  = $username;
    $_SESSION['clearance'] = $clearance;

    header('Location: dashboard.php');
    exit;
} else {
    echo 'Invalid username or password. <a href="login.php">Try again</a>.';
}

$stmt->close();
$mysqli->close();
