<?php
session_start();

// 1) Require a valid login
if (empty($_SESSION['username']) || empty($_SESSION['clearance'])) {
  header('Location: login.php');
  exit;
}

// 2) Choose which images to show based on clearance
$all = [
  'T' => ['TopSecret.png','Secret.png','Confidential.png','Unclassified.png'],
  'S' => ['Secret.png','Confidential.png','Unclassified.png'],
  'C' => ['Confidential.png','Unclassified.png'],
  'U' => ['Unclassified.png'],
];

$level = $_SESSION['clearance'];
$files = isset($all[$level]) ? $all[$level] : [];  // fallback to none

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <link rel="stylesheet" href="/css/dashboard.css">
  <style>
    .images { display: flex; flex-wrap: wrap; gap: 1rem; justify-content: center; }
    .images img { max-width: 200px; border: 2px solid #fff; border-radius: 4px; }
    .header { text-align: center; margin-bottom: 2rem; color: #fff; }
    .btn-logout { display: block; margin: 2rem auto 0; padding: 0.5rem 1rem; background: #ee0979; color: #fff; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; }
  </style>
</head>
<body>
  <div class="dashboard-container">
    <h2 class="title header">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
    <p class="header">Your clearance level is <strong><?php echo htmlspecialchars($level); ?></strong></p>

    <div class="images">
      <?php foreach ($files as $img): ?>
        <img src="/files/<?php echo $img; ?>" alt="<?php echo pathinfo($img, PATHINFO_FILENAME); ?>">
      <?php endforeach; ?>
    </div>

    <a href="logout.php" class="btn-logout">Log Out</a>
  </div>
</body>
</html>
