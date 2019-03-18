<div class="w3-top">
	<div class="w3-bar w3-teal w3-card">
        <div class="url-bar">
            <a href="/" class="w3-bar-item w3-button w3-padding-large">Home</a>
            <?php if (auth()): ?>
                <p class="w3-bar-item header-p">Hello, <?php echo auth()->name ?></p>
                <a href="/settings" class="w3-bar-item w3-button w3-padding-large">Profile Settings</a>
                <a href="/logout" class="w3-bar-item w3-button w3-padding-large">Logout</a>
            <?php else:?>
                <a href="/login" class="w3-bar-item w3-button w3-padding-large">Login</a>
                <a href="/sign-up" class="w3-bar-item w3-button w3-padding-large">Sign Up</a>
            <?php endif;?>
        </div>
	</div>
</div>