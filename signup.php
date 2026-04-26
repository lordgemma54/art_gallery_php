<?php
include("top.html");
?>

<div class="container">
    <div class="card">
        <form class="signup-form" action="process-signup.php" method="post">
            <label><strong>Username</strong> <input type="text" name="username" size="16" required></label> <br>
            <label><strong>Password</strong> <input type="password" name="password" size="16" required></label> <br>
            <label><strong>Email</strong> <input type="email" name="email" size="16" required></label> <br>
            <div class="form-actions">
                <input class="button button-primary action-btn" type="submit" value="Sign up">
            </div>
        </form>
        <div class="links"><a href="login.php">Back to login</a></div>
    </div>
</div>

<?php
include("bottom.html");
?>