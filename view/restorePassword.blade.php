<form class="mr-top-m" action="/auth/restore-password" method="POST" style="border:1px solid #ccc">
    <div class="container">
        <h1>Restore password</h1>
        <p>Enter new password.</p>
        <hr>

        <input type="hidden" name="confirmCode" required value="<?php echo $confirmCode; ?>">
        <?php if (isset($errors['password'])): ?>
            <p class="error-text"><?php echo $errors['password'] ?></p>
        <?php endif; ?>
        <?php if (isset($errors['verificationCodeError'])): ?>
        <p class="error-text"><?php echo $errors['verificationCodeError'] ?></p>
        <?php endif; ?>
        <label for="psw"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="password" required>

        <label for="psw"><b>Repeat Password</b></label>
        <input type="password" placeholder="Repeat Password" name="repeat_password" required>

        <div class="clearfix">
            <button type="submit" class="signupbtn">Confirm password</button>
        </div>
    </div>
</form>