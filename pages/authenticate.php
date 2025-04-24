<?php
session_start();

// 1) basic presence check
if (
    !isset($_POST['username'], $_POST['password'], $_POST['captcha'])
) {
    die('Please fill in all fields.');
}

// 2) verify the image‐CAPTCHA
if (
    !isset($_SESSION['captcha_text']) ||
    strcasecmp($_POST['captcha'], $_SESSION['captcha_text']) !== 0
) {
    // clear it so it can’t be reused
    unset($_SESSION['captcha_text']);
    die('CAPTCHA incorrect. <a href="login.php">Try again</a>.');
}
// clear for next request
unset($_SESSION['captcha_text']);

// 3) grab & hash credentials
$username = $_POST['username'];
$password = $_POST['password'];
$hashed   = sha1($password);   // matches your CHAR(40) column

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
    $stmt->bind_result($clearance);
    $stmt->fetch();

    // On success, you might redirect to a protected page instead
    echo "<h2>Welcome, " . htmlspecialchars($username) . "!</h2>";
    echo "<p>Your clearance level is: " . htmlspecialchars($clearance) . "</p>";
} else {
    echo 'Invalid username or password. <a href="login.php">Try again</a>.';
}

$stmt->close();
$mysqli->close();
