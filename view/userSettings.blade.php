<h1 class="mr-top-l text-center">Profile Settings</h1>

<form class="mr-top-m" action="/settings/change/user-name" method="POST" style="border:1px solid #ccc">
    <div class="container">
        <h3>Change user name:</h3>
        <p>Your current user name are <?php echo auth()->name ?> </p>
        <p>Please fill new user name in this form to change current user name:</p>
        <hr>
        <?php if (isset($errors['newUserName'])): ?>
            <p class="error-text"><?php echo $errors['newUserName'] ?></p>
        <?php endif; ?>
        <label for="email"><b>User name</b></label>
        <input type="text" placeholder="Enter new user name" name="new_user_name" required>

        <div class="clearfix">
            <button type="submit" class="signupbtn">Change</button>
        </div>
    </div>
</form>

<form class="mr-top-m" action="/settings/change/email" method="POST" style="border:1px solid #ccc">
    <div class="container">
        <h3>Change email:</h3>
        <p>Your current user name are <?php echo auth()->email ?> </p>
        <p>Please fill new email in this form to change current email:</p>
        <hr>
        <?php if (isset($errors['newEmail'])): ?>
            <p class="error-text"><?php echo $errors['newEmail'] ?></p>
        <?php endif; ?>
        <label for="email"><b>Email</b></label>
        <input type="text" placeholder="Enter new email" name="new_email" required>

        <div class="clearfix">
            <button type="submit" class="signupbtn">Change</button>
        </div>
    </div>
</form>

<form class="mr-top-m" action="/settings/change/password" method="POST" style="border:1px solid #ccc">
    <div class="container">
        <h3>Change password:</h3>
        <p>Please fill new password in this form to change current password:</p>
        <hr>
        <?php if (isset($errors['oldPassword'])): ?>
        <p class="error-text"><?php echo $errors['oldPassword'] ?></p>
        <?php endif; ?>

        <label for="psw"><b>Old Password</b></label>
        <input type="password" placeholder="Enter old Password" name="old_password" required>

        <?php if (isset($errors['newPassword'])): ?>
        <p class="error-text"><?php echo $errors['newPassword'] ?></p>
        <?php endif; ?>
        <label for="psw"><b>New password</b></label>
        <input type="password" placeholder="Enter new password" name="new_password" required>

        <label for="psw"><b>Repeat new Password</b></label>
        <input type="password" placeholder="Repeat new Password" name="repeat_new_password" required>

        <div class="clearfix">
            <button type="submit" class="signupbtn">Change</button>
        </div>
    </div>
</form>