<form class="mr-top-m" action="/auth/restore-password/send-email" method="POST" style="border:1px solid #ccc">
    <div class="container">
        <h1>Forgot password?</h1>
        <p>Enter your email. After that you will receive an email for password recovery.</p>
        <hr>
        <?php if (isset($errors['email'])): ?>
        <p class="error-text"><?php echo $errors['email'] ?></p>
        <?php endif; ?>
        <input type="text" placeholder="Enter your email" name="email" required>

        <div class="clearfix">
            <button type="submit" class="signupbtn">Send restore link</button>
        </div>
    </div>
</form>