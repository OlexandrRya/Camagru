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