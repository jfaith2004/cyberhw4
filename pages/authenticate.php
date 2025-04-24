<?php
session_start();

if (
    !isset($_POST['username'], $_POST['password'], $_POST['captcha'])
) {
    die('Please fill in all fields.');
}

// 2) verify CAPTCHA
if ((int)$_POST['captcha'] !== $_SESSION['captcha_answer']) {
    die('CAPTCHA incorrect. <a href="login.php">Try again</a>.');
}

// 3) grab & hash credentials
$username = $_POST['username'];
$password = $_POST['password'];
$hashed   = sha1($password);   // matches CHAR(40) column

// 4) connect to MySQL – update credentials/database as needed
$mysqli = new mysqli(
    'localhost',
    'root',
    'YourMySQLRootPassword',
    'UserDB'
);
if ($mysqli->connect_error) {
    die('DB connection error: ' . $mysqli->connect_error);
}

// 5) prepared statement to avoid SQL injection
$stmt = $mysqli->prepare(
    'SELECT clearance
       FROM UserAccounts
      WHERE username = ?
        AND password = ?'
);
$stmt->bind_param('ss', $username, $hashed);
$stmt->execute();
$stmt->store_result();

// 6) check result
if ($stmt->num_rows === 1) {
    // successful login
    $stmt->bind_result($clearance);
    $stmt->fetch();
    echo "<h2>Welcome, " . htmlspecialchars($username) . "!</h2>";
    echo "<p>Your clearance level is: " . htmlspecialchars($clearance) . "</p>";
    // here you could set additional session vars and redirect
} else {
    echo 'Invalid username or password. <a href="login.php">Try again</a>.';
}

$stmt->close();
$mysqli->close();