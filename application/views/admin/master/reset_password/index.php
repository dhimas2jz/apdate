
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Password</h2>
    <form method="post" action="<?php echo site_url('resetpassword/submit'); ?>">
        <label>Email:</label>
        <input type="email" name="email" required>
        <button type="submit">Reset</button>
    </form>
</body>
</html>