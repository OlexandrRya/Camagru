<form class="mr-top-m" action="/login/post" method="POST" style="border:1px solid #ccc">
    <div class="container">
        <h1>Login</h1>
        <p>Please fill in this form to login.</p>
        <hr>
        <?php if (isset($errors['userNameAndPassword'])): ?>
            <p class="error-text"><?php echo $errors['userNameAndPassword'] ?></p>
        <?php endif; ?>
        <label for="email"><b>User name</b></label>
        <input type="text" placeholder="Enter user name" name="user_name" required>

        <label for="psw"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="password" required>

        <div class="clearfix">
            <button type="submit" class="signupbtn">Login</button>
        </div>
        <a href="/auth/forgot-password/show">
            <p>Forgot password? Click here!</p>
        </a>
    </div>
</form>