<form class="mr-top-m" action="/sign-up/create" method="POST" style="border:1px solid #ccc">
    <div class="container">
        <h1>Sign Up</h1>
        <p>Enter name, email and password to login.</p>
        <hr>
        <?php if (isset($errors)): ?>
            <?php foreach ($errors as $error):?>
                <p class="error-text"><?php echo $error ?></p>
            <?php endforeach;?>
        <?php endif; ?>
        <label><b>Name</b></label>
        <input type="text" placeholder="Enter Name" name="name" required>

        <label for="email"><b>Email</b></label>
        <input type="text" placeholder="Enter Email" name="email" required>

        <label for="psw"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="password" required>

        <label for="psw"><b>Repeat Password</b></label>
        <input type="password" placeholder="Repeat Password" name="repeat_password" required>

        <div class="clearfix">
            <button type="submit" class="signupbtn">Sign Up</button>
        </div>
    </div>
</form>