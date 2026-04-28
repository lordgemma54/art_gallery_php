<?php
if (session_status() === PHP_SESSION_NONE) {
      session_start();
}
$artist_id = $_SESSION["artist_id"] ?? null;

?>
<nav class="navbar">
      <a href="index.php">Home</a>

      <?php if ($artist_id) { ?>
            <a href="profile.php?id=<?= $artist_id ?>">Profile</a>
            <a href="logout.php">Logout</a>

      <?php } else { ?>
            <a href="login.php">Login</a>
            <a href="signup.php">Sign Up</a>
      <?php } ?>

</nav>