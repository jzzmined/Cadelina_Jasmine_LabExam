<?php
require 'includes/functions.php';
if (isset($_SESSION['user'])) redirect('dashboard.php');

$errors = [];
$email  = $_COOKIE['remember_email'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = clean($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!csrf_ok()) {
        $errors['form'] = 'Session expired. Please try again.';
    } else {
        if ($email === '')                                   $errors['email'] = 'Email is required.';
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL))  $errors['email'] = 'Enter a valid email address.';
        if ($password === '')                                $errors['password'] = 'Password is required.';

        if (!$errors) {
            $user = find_user($email);
            if (!$user || !password_verify($password, $user['password'])) {
                $errors['form'] = 'Incorrect email or password.';
            } else {
                session_regenerate_id(true);
                $_SESSION['user'] = ['name' => $user['email'], 'email' => $user['email']];
                if (!empty($_POST['remember'])) setcookie('remember_email', $email, time() + 60*60*24*30, '/');
                else setcookie('remember_email', '', time() - 3600, '/');
                flash('success', 'Welcome back! You are now logged in.');
                redirect('dashboard.php');
            }
        }
    }
}
$flash = get_flash();
$title = 'Login';
include 'includes/auth_form_head.php';
?>
<body class="auth">
  <div class="photo"></div>
  <section class="card">
    <h2>Login</h2>
    <?php if ($flash): ?><div class="alert <?= e($flash['type']) ?>"><?= e($flash['msg']) ?></div><?php endif; ?>
    <?php if (isset($errors['form'])): ?><div class="alert error"><?= e($errors['form']) ?></div><?php endif; ?>

    <form method="post" novalidate id="authForm">
      <input type="hidden" name="csrf" value="<?= csrf_token() ?>">

      <div class="field">
        <input type="email" name="email" placeholder="Email" value="<?= e($email) ?>" class="<?= isset($errors['email']) ? 'invalid' : '' ?>">
        <?php if (isset($errors['email'])): ?><small class="err"><?= e($errors['email']) ?></small><?php endif; ?>
      </div>

      <div class="field pw">
        <input type="password" name="password" placeholder="Password" class="<?= isset($errors['password']) ? 'invalid' : '' ?>">
        <button type="button" class="eye" aria-label="Show password">👁</button>
        <?php if (isset($errors['password'])): ?><small class="err"><?= e($errors['password']) ?></small><?php endif; ?>
      </div>

      <div class="row">
        <label><input type="checkbox" name="remember" <?= isset($_COOKIE['remember_email']) ? 'checked' : '' ?>> Remember me</label>
        <a href="#" id="forgot">Forgot Password?</a>
      </div>

      <button class="btn" type="submit">Login</button>
    </form>

    <div class="divider"><span>Or sign up with</span></div>
    <div class="social"><span>G</span><span>f</span><span></span></div>
    <p class="switch">No account yet? <a href="register.php">Sign up</a></p>
  </section>
  <script src="assets/js/script.js"></script>
</body>
</html><?php
require 'includes/functions.php';
if (isset($_SESSION['user'])) redirect('dashboard.php');

$errors = [];
$email  = $_COOKIE['remember_email'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = clean($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!csrf_ok()) {
        $errors['form'] = 'Session expired. Please try again.';
    } else {
        if ($email === '')                                   $errors['email'] = 'Email is required.';
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL))  $errors['email'] = 'Enter a valid email address.';
        if ($password === '')                                $errors['password'] = 'Password is required.';

        if (!$errors) {
            $user = find_user($email);
            if (!$user || !password_verify($password, $user['password'])) {
                $errors['form'] = 'Incorrect email or password.';
            } else {
                session_regenerate_id(true);
                $_SESSION['user'] = ['name' => $user['email'], 'email' => $user['email']];
                if (!empty($_POST['remember'])) setcookie('remember_email', $email, time() + 60*60*24*30, '/');
                else setcookie('remember_email', '', time() - 3600, '/');
                flash('success', 'Welcome back! You are now logged in.');
                redirect('dashboard.php');
            }
        }
    }
}
