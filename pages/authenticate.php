<?php
session_start();

// 1) Ensure all fields are submitted
if (
    empty($_POST['username']) ||
    empty($_POST['password']) ||
    empty($_POST['captcha_input'])
) {
    die('Please fill in all fields.');
}

// 2) Verify the captcha
if (
    !isset($_SESSION['captcha_code']) ||
    strcasecmp($_POST['captcha_input'], $_SESSION['captcha_code']) !== 0
) {
    unset($_SESSION['captcha_code']);
    die('CAPTCHA incorrect. <a href="login.php">Try again</a>.');
}
unset($_SESSION['captcha_code']);

// 3) Hash the password
$username = $_POST['username'];
$password = $_POST['password'];
$hashed   = sha1($password);   // assuming your DB stores SHA1

// 4) Connect to MySQL
$mysqli = new mysqli(
    'localhost',
    'root',
    'YourMySQLRootPassword',
    'UserDB'
);
if ($mysqli->connect_error) {
    die('DB connection error: ' . $mysqli->connect_error);
}

// 5) Prepared statement to avoid SQL injection
$stmt = $mysqli->prepare(
    'SELECT clearance
       FROM UserAccounts
      WHERE username = ?
        AND password = ?'
);
$stmt->bind_param('ss', $username, $hashed);
$stmt->execute();
$stmt->store_result();

// 6) Check credentials
if ($stmt->num_rows === 1) {
    $stmt->bind_result($clearance);
    $stmt->fetch();

    // Success: show welcome (or redirect to protected area)
    echo "<h2>Welcome, " . htmlspecialchars($username) . "!</h2>";
    echo "<p>Your clearance level: " . htmlspecialchars($clearance) . "</p>";
} else {
    echo 'Invalid username or password. <a href="login.php">Try again</a>.';
}

$stmt->close();
$mysqli->close();
