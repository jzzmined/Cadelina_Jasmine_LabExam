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
    <div class="social">
    <a href="#" aria-label="Sign up with Google">
        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
    </a>
    <a href="#" aria-label="Sign up with Facebook">
        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
    </a>
    <a href="#" aria-label="Sign up with Apple">
        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12.152 6.896c-.948 0-2.415-1.078-3.96-1.04-2.04.027-3.91 1.183-4.961 3.014-2.117 3.675-.546 9.103 1.519 12.09 1.013 1.454 2.208 3.09 3.792 3.039 1.52-.065 2.09-.987 3.935-.987 1.831 0 2.35.987 3.96.948 1.637-.026 2.676-1.48 3.676-2.948 1.156-1.688 1.636-3.325 1.662-3.415-.039-.013-3.182-1.221-3.22-4.857-.026-3.04 2.48-4.494 2.597-4.559-1.429-2.09-3.623-2.324-4.39-2.376-2-.156-3.675 1.09-4.61 1.09zM15.53 3.83c.843-1.012 1.4-2.427 1.245-3.83-1.207.052-2.662.805-3.532 1.818-.78.896-1.454 2.338-1.273 3.714 1.338.104 2.715-.688 3.559-1.701"/></svg>
    </a>
    </div>
    <p class="switch">No account yet? <a href="register.php">Sign up</a></p>
  </section>
  <script src="assets/js/script.js"></script>
</body>
