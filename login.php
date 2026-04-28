<?php
$redirect_id = $_GET["redirect_to"] ?? "";
// $artist_id = $_POST["artist_id"];
?>
<div class="login-container">
    <div>
        <form class="login-form" action="process_login.php" method="post">
            <label><strong>Username</strong><input type="text" name="username" size="16"></label> <br>


            <label><strong>Password</strong><input type="password" name="password" size="16"></label><br>

            <input type="hidden" name="redirect_to" value="<?= htmlspecialchars($redirect_id) ?>">

            <button type="submit"> Login </button>

            <div class="links"><a href="signup.php">Don't have an account? Sign up here</a></div>
        </form>
    </div>
</div>