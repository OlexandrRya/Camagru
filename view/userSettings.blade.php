<form class="mr-top-m" action="/login/post" method="POST" style="border:1px solid #ccc">
    <div class="container">
        <h1>Login</h1>
        <p>Please fill in this form to login.</p>
        <hr>
        <?php if (isset($errors['emailAndPassword'])): ?>
        <p class="error-text"><?php echo $errors['emailAndPassword'] ?></p>
        <?php endif; ?>
        <label for="email"><b>Email</b></label>
        <input type="text" placeholder="Enter Email" name="email" required>

        <label for="psw"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="password" required>

        <div class="clearfix">
            <button type="submit" class="signupbtn">Login</button>
        </div>
    </div>
</form>