<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
</head>

<body>
    <h2>Login</h2>
    <?php if(session('error')): ?>
    <div style="color:red;"><?= session('error') ?></div>
    <?php endif; ?>
    <form action="<?= site_url('auth/attemptLogin') ?>" method="post">
        <label>Email:</label>
        <input type="email" name="email" required><br>
        <label>Password:</label>
        <input type="password" name="password" required><br>
        <button type="submit">Login</button>
    </form>
</body>

</html>