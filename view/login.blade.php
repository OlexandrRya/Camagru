<form class="mr-top-m" action="/login/post" method="POST" style="border:1px solid #ccc">
    <div class="container">
        <h1>Sign Up</h1>
        <p>Please fill in this form to login.</p>
        <hr>
        <?php if (isset($error)): ?>
            <p class="error-text"><?php echo $error ?></p>
        <?php endif; ?>
        <label for="email"><b>Email</b></label>
        <input type="text" placeholder="Enter Email" name="email" required>

        <label for="psw"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="password" required>

        <div class="clearfix">
            <button type="submit" class="signupbtn">Sign Up</button>
        </div>
    </div>
</form>